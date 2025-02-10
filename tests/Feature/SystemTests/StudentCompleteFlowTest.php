<?php

namespace Tests\Feature\SystemTests;

use App\Models\{User, Course, CourseFee, Payment, RegistrationFee};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('handles complete student flow: registration, payment, enrollment, and grade viewing', function () {
    
    // 1. Set up: Create a course with a fee and a registration fee
    $course = Course::factory()->create();
    CourseFee::factory()->create(['course_id' => $course->id, 'amount' => 250]);
    RegistrationFee::factory()->create(['amount' => 50]);
    
    Mail::fake();

    // 2. Registration and Registration Payment
    $studentData = [
        'full_name' => 'Test Student',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $this->post(route('register'), $studentData)
         ->assertRedirect(route('show.registration.payment'));

    // Simulate successful registration payment via Stripe
    $this->postJson(route('process.registration.payment'), ['token' => 'tok_visa'])
         ->assertJson(['success' => true]);

    // Assertions for registration and payment
    $student = User::where('email', $studentData['email'])->first();
    $this->assertAuthenticatedAs($student);
    $this->assertDatabaseHas('payments', [
        'student_id' => $student->id,
        'payment_type' => 'registration',
        'status' => 'completed',
    ]);

    $this->assertDatabaseHas('receipts', [
        'receipt_email' => $student->email,
        'status' => 'completed',
        'description' => 'Registration Fee',
    ]);

    // 3. Logout
    Auth::logout();
    $this->assertGuest();

    // 4. Login
    $this->post('/login', [
            'email' => $studentData['email'],
            'password' => $studentData['password'],
        ])->assertRedirect('/student/dashboard');
        
        $this->assertAuthenticatedAs($student);

    // 5. View Available Courses and Enroll
    $this->get(route('student.available-courses'))
         ->assertStatus(200)
         ->assertSee($course->name);

    $this->post(route('student.enroll', $course->id))
            ->assertRedirect(route('student.course.payment', ['course' => $course->id]));



    // 6. Course Payment 
    $this->postJson(route('process.course.payment', $course->id), ['token' => 'tok_visa'])
            ->assertJson(['success' => true]);

    // Assertions for course enrollment and payment
    $this->assertDatabaseHas('student_course_enrollments', [
        'student_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'approved',
    ]);
    $this->assertDatabaseHas('payments', [
        'student_id' => $student->id,
        'payment_type' => 'course_enrollment',
        'course_id' => $course->id,
        'status' => 'completed',
    ]);
    $this->assertDatabaseHas('receipts', [
        'receipt_email' => $student->email,
        'status' => 'completed',
        'description' => 'Course Enrollment Fee',
    ]);


    // 7. View Enrolled Courses
    $this->get(route('student.enrolled-courses'))
         ->assertStatus(200)
         ->assertSee($course->name);

});
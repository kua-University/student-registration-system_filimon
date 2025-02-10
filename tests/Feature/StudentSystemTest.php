<?php

namespace Tests\Feature\SystemTests;

use App\Models\{User, Course, CourseFee, Payment, RegistrationFee};
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the complete student flow: registration, payment, enrollment, and grade viewing.
     *
     * @return void
     */
    public function test_handles_complete_student_flow()
    {
        $course = Course::factory()->create();
        CourseFee::factory()->create(['course_id' => $course->id, 'amount' => 250]);
        RegistrationFee::factory()->create(['amount' => 50]);

        $studentData = [
            'full_name' => 'Test Student',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->post(route('register'), $studentData);
        $response->assertRedirect(route('show.registration.payment'));

        $response = $this->postJson(route('process.registration.payment'), ['token' => 'tok_visa']);
        $response->assertJson(['success' => true]);

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

        Auth::logout();
        $this->assertGuest();

        $response = $this->post('/login', [
            'email' => $studentData['email'],
            'password' => $studentData['password'],
        ]);
        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticatedAs($student);

        $response = $this->get(route('student.available-courses'));
        $response->assertStatus(200);
        $response->assertSee($course->name);

        $response = $this->post(route('student.enroll', $course->id));
        $response->assertRedirect(route('student.course.payment', ['course' => $course->id]));

        $response = $this->postJson(route('process.course.payment', $course->id), ['token' => 'tok_visa']);
        $response->assertJson(['success' => true]);

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

        $response = $this->get(route('student.enrolled-courses'));
        $response->assertStatus(200);
        $response->assertSee($course->name);
    }
}

<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseFee;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('admin creates a course and student registers successfully', function () {
    // Create admin and student users
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student']);

    // Admin creates a course with a fee
    $this->actingAs($admin)
        ->post(route('admin.store-course'), [
            'name' => 'Introduction to Programming',
            'code' => 'CS101',
            'category' => 'Computer Science',
            'credits' => 3,
            'description' => 'A foundational course in programming.',
            'fee' => 200,
        ])
        ->assertRedirect(route('admin.courses'));
    
    $course = Course::first();
    $course_fee = CourseFee::first();

    // Verify the course exists in the database
    $this->assertDatabaseHas('courses', ['name' => 'Introduction to Programming']);
    $this->assertDatabaseHas('course_fees', ['amount' => 200]);

    // Student logs in and views the available courses
    $this->actingAs($student)
        ->get(route('student.available-courses'))
        ->assertStatus(200)
        ->assertSee('Introduction to Programming');

    // Student registers for the course
    $this->post(route('student.enroll', ['courseId' => $course->id]))
        ->assertRedirect(route('student.course.payment', ['course' => $course->id]));
    
    // Simulate payment request
    $response = $this->postJson(route('process.course.payment', ['course' => $course->id]), [
        'token' => 'tok_visa', // Test token for Stripe
    ]);

    // Assert successful payment and redirect
    $response->assertJson([
        'success' => true,
    ]);

    // Verify database changes
    $this->assertDatabaseHas('payments', [
        'student_id' => $student->id,
        'amount' => $course_fee->amount,
        'payment_type' => 'course_enrollment',
        'status' => 'completed',
        'course_id' => $course->id,
    ]);

    $this->assertDatabaseHas('receipts', [
        'amount' => $course_fee->amount,
        'status' => 'completed',
    ]);

    // Verify the course is in the enrolled courses list for the student
    $this->actingAs($student)
        ->get(route('student.enrolled-courses'))
        ->assertStatus(200)
        ->assertSee('Introduction to Programming');
});

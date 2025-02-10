<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use App\Models\Course;
use App\Models\StudentCourseEnrollment;
use App\Models\CourseFee;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->student = User::factory()->create([
        'role' => 'student',
        'password' => bcrypt('student123'),
    ]);

    $this->course = Course::factory()->create();

    CourseFee::factory()->create([
        'course_id' => $this->course->id,
        'amount' => 200,
    ]);

    $this->enrollment = StudentCourseEnrollment::factory()->create([
        'student_id' => $this->student->id,
        'course_id' => $this->course->id,
        'status' => 'approved',
    ]);
});

it('shows all enrolled courses for the authenticated student', function () {
    $response = $this->actingAs($this->student)->get(route('student.enrolled-courses'));

    $response->assertStatus(200);
    $response->assertSee($this->course->name);
});

it('shows all available courses for the authenticated student', function () {
    $availableCourse = Course::factory()->create();
    CourseFee::factory()->create([
        'course_id' => $availableCourse->id,
        'amount' => 300,
    ]);

    $response = $this->actingAs($this->student)->get(route('student.available-courses'));

    $response->assertStatus(200);
    $response->assertSee($availableCourse->name);
});

it('allows successful enrollment in a course', function () {
    $newCourse = Course::factory()->create();
    CourseFee::factory()->create([
        'course_id' => $newCourse->id,
        'amount' => 400,
    ]);

    $this->actingAs($this->student)->post(route('student.enroll', $newCourse->id))
            ->assertRedirect(route('student.course.payment', ['course' => $newCourse->id]));

    $this->actingAs($this->student)->postJson(route('process.course.payment', $newCourse->id), ['token' => 'tok_visa'])
            ->assertJson(['success' => true]);

    $this->assertDatabaseHas('student_course_enrollments', [
        'student_id' => $this->student->id,
        'course_id' => $newCourse->id,
        'status' => 'approved',
    ]);
});

it('fails enrollment if student is already enrolled in the course', function () {
    $response = $this->actingAs($this->student)->post(route('student.enroll', $this->course->id));

    $response->assertRedirect();
    $response->assertSessionHas('error', 'You are already enrolled in this course.');

    $this->assertDatabaseCount('student_course_enrollments', 1);
});

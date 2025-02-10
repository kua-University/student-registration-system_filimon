<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseFee;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('shows all courses for authenticated admin', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('admin.courses'));

    $response->assertStatus(200);
    $response->assertSee('Courses');
});

it('shows course creation form for authenticated admin', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('admin.create-course'));

    $response->assertStatus(200);
    $response->assertSee('Create Course');
});

it('creates a course successfully', function () {
    $admin = User::factory()->admin()->create();

    $courseData = [
        'name' => 'Organic Chemistry',
        'code' => 'CH201',
        'category' => 'Chemistry',
        'credits' => 3,
        'description' => 'Study of carbon-containing compounds.',
    ];

    $feeData = [
        'fee' => 200,
    ];

    $requestData = array_merge($courseData, $feeData);

    $response = $this->actingAs($admin)->post(route('admin.store-course'), $requestData);

    $response->assertRedirect(route('admin.courses'));
    $this->assertDatabaseHas('courses', $courseData);

    $course = Course::where('code', 'CH201')->first();
    $this->assertDatabaseHas('course_fees', [
        'course_id' => $course->id,
        'amount' => 200,
    ]);
});

it('displays correct details in edit course form', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();

    $response = $this->actingAs($admin)->get(route('admin.edit-course', $course->id));

    $response->assertStatus(200);
    $response->assertSee($course->name);
    $response->assertSee($course->description);
});

it('updates a course successfully', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();

    $updateData = [
        'name' => 'Updated Course Name',
        'description' => 'Updated description.',
        'code' => 'CS101',
        'category' => 'Computer Science',
        'credits' => 4,
    ];

    $feeData = [
        'fee' => 200,
    ];

    $requestData = array_merge($updateData, $feeData);

    $response = $this->actingAs($admin)->post(route('admin.update-course', $course->id), $requestData);

    $response->assertRedirect(route('admin.courses'));
    $this->assertDatabaseHas('courses', $updateData);
});

it('shows course deletion confirmation page', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();

    $response = $this->actingAs($admin)->get(route('admin.destroy-course', $course->id));

    $response->assertStatus(200);
    $response->assertSee('Are you sure');
});

it('deletes a course successfully', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();

    $response = $this->actingAs($admin)->post(route('admin.delete-course', $course->id));

    $response->assertRedirect(route('admin.courses'));
    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
});

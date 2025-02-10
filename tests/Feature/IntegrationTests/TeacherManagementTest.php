<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use App\Models\Course;
use App\Models\TeacherCourseAssignment;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('shows the teacher listing page for authenticated admins', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $teacher = User::factory()->create(['role' => 'teacher']);
    
    TeacherCourseAssignment::create([
        'teacher_id' => $teacher->id,
        'course_id' => Course::factory()->create()->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.teachers'));

    $response->assertStatus(200);
    $response->assertSee('Teachers');
    $response->assertSee($teacher->name);
});

it('allows admins to access the teacher creation form', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.create-teacher'));

    $response->assertStatus(200);
    $response->assertSee('Register New Teacher');
});

it('allows admins to successfully create a teacher', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $course = Course::factory()->create();

    $teacherData = [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'course_id' => $course->id,
    ];

    $response = $this->actingAs($admin)->post(route('admin.store-teacher'), $teacherData);

    $response->assertRedirect(route('admin.teachers'));
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'role' => 'teacher',
    ]);

    $teacher = User::where('email', 'johndoe@example.com')->first();
    $this->assertDatabaseHas('teacher_course_assignments', [
        'teacher_id' => $teacher->id,
        'course_id' => $course->id,
    ]);
});

it('displays correct details on the teacher edit form', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->create();

    TeacherCourseAssignment::create([
        'teacher_id' => $teacher->id,
        'course_id' => $course->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.edit-teacher', $teacher->id));

    $response->assertStatus(200);
    $response->assertSee($teacher->name);
    $response->assertSee($teacher->email);
});

it('allows admins to successfully update a teacher', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->create();

    TeacherCourseAssignment::create([
        'teacher_id' => $teacher->id,
        'course_id' => $course->id,
    ]);

    $updateData = [
        'name' => 'Updated Teacher Name',
        'email' => 'updatedteacher@example.com',
        'course_id' => $course->id,
    ];

    $response = $this->actingAs($admin)->put(route('admin.update-teacher', $teacher->id), $updateData);

    $response->assertRedirect(route('admin.teachers'));
    $this->assertDatabaseHas('users', [
        'id' => $teacher->id,
        'name' => 'Updated Teacher Name',
        'email' => 'updatedteacher@example.com',
    ]);

    $this->assertDatabaseHas('teacher_course_assignments', [
        'teacher_id' => $teacher->id,
        'course_id' => $course->id,
    ]);
});

it('displays a confirmation page for teacher deletion', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $teacher = User::factory()->create(['role' => 'teacher']);

    $response = $this->actingAs($admin)->get(route('admin.destroy-teacher', $teacher->id));

    $response->assertStatus(200);
    $response->assertSee('Are you sure you want to delete this teacher?');
});

it('allows admins to successfully delete a teacher', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->create();

    TeacherCourseAssignment::create([
        'teacher_id' => $teacher->id,
        'course_id' => $course->id,
    ]);

    $response = $this->actingAs($admin)->post(route('admin.delete-teacher', $teacher->id));

    $response->assertRedirect(route('admin.teachers'));
    $this->assertDatabaseMissing('users', ['id' => $teacher->id]);
    $this->assertDatabaseMissing('teacher_course_assignments', ['teacher_id' => $teacher->id]);
});

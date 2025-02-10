<?php

namespace Tests\Feature\SystemTests;

use App\Models\{User, Course, CourseFee, TeacherCourseAssignment, Payment, RegistrationFee, StudentCourseEnrollment};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);


it('handles complete admin flow: course management, teacher management, student management, and revenue management', function () {
    // 1. Set Up:  Create an admin user
    $admin = User::factory()->create(['role' => 'admin', 'password' => Hash::make('admin123')]);
    $this->actingAs($admin);


    // 2. Course Management
    // 2.1 Create a Course
    $courseData = [
        'name' => 'Test Course 101',
        'code' => 'TC101',
        'category' => 'Testing',
        'credits' => 3,
        'description' => 'A test course description.',
        'fee' => 300,
    ];
    $this->post(route('admin.store-course'), $courseData)
         ->assertRedirect(route('admin.courses'));
    $this->assertDatabaseHas('courses', ['code' => 'TC101']);

    $createdCourse = Course::where('code', 'TC101')->first();
    $this->assertDatabaseHas('course_fees', ['course_id' => $createdCourse->id, 'amount' => 300]);
    

    // 2.2 Edit an existing course
    $updatedCourseData = [
        'name' => 'Updated Course Name',
        'description' => 'Updated description.',
        'code' => 'UC102', // Updated code
        'category' => 'Testing-Updated',
        'credits' => 4,
        'fee' => 400
    ];

    $this->post(route('admin.update-course', $createdCourse->id), $updatedCourseData)
         ->assertRedirect(route('admin.courses'));

    $this->assertDatabaseHas('courses', ['id' => $createdCourse->id, 'code' => 'UC102']);
    $this->assertDatabaseHas('course_fees', ['course_id' => $createdCourse->id, 'amount' => 400]);

    // 2.3. Delete Course
    $this->followingRedirects()
        ->post(route('admin.delete-course', $createdCourse->id))
        ->assertViewIs('admin.courses');

    $this->assertDatabaseMissing('courses', ['id' => $createdCourse->id]);
    $this->assertDatabaseMissing('course_fees', ['course_id' => $createdCourse->id]);





    // 3. Teacher Management
    // 3.1 Create a Teacher
    $teacherData = [
        'name' => 'Test Teacher',
        'email' => 'teacher@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'course_id' => Course::factory()->create()->id,
    ];
    $this->post(route('admin.store-teacher'), $teacherData)
         ->assertRedirect(route('admin.teachers'));

    $createdTeacher = User::where('email', $teacherData['email'])->first();
    $this->assertNotNull($createdTeacher);
    $this->assertDatabaseHas('teacher_course_assignments', ['teacher_id' => $createdTeacher->id]);


    // 3.2. Update Teacher
    $newCourse = Course::factory()->create();
    $updatedTeacherData = [
        'name' => 'Updated Teacher Name',
        'email' => 'updatedteacher@example.com',
        'course_id' => $newCourse->id,
    ];

    $this->put(route('admin.update-teacher', $createdTeacher->id), $updatedTeacherData)
            ->assertRedirect(route('admin.teachers'));

    $this->assertDatabaseHas('users', [
        'id' => $createdTeacher->id,
        'name' => $updatedTeacherData['name'],
        'email' => $updatedTeacherData['email'],
    ]);
    $this->assertDatabaseHas('teacher_course_assignments', [
        'teacher_id' => $createdTeacher->id,
        'course_id' => $newCourse->id,
    ]);

    // 3.3. Delete Teacher
    $this->followingRedirects()
        ->post(route('admin.delete-teacher', $createdTeacher->id))
        ->assertSee('Manage Teachers');


    $this->assertDatabaseMissing('users', ['id' => $createdTeacher->id]);
    $this->assertDatabaseMissing('teacher_course_assignments', ['teacher_id' => $createdTeacher->id]);


    // 4. Revenue Management
    // 4.1 View Revenue Report
    $registrationFee = RegistrationFee::factory()->create();

    $this->actingAs($admin)
        ->get(route('admin.revenue'))
        ->assertStatus(200);

    // 4.2 Update Registration Fee
    $newFee = 750.50;
    $this->post(route('admin.update-registration-fee.store'), ['registration_fee' => $newFee])
        ->assertRedirect(route('admin.revenue'));
    $this->assertDatabaseHas('registration_fees', ['amount' => $newFee]);
});
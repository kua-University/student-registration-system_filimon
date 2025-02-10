<?php

namespace Tests\Feature;

use App\Models\{User, Course, CourseFee, TeacherCourseAssignment, Payment, RegistrationFee, StudentCourseEnrollment};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the complete admin flow: course management, teacher management,
     * student management, and revenue management.
     */
    public function test_handles_complete_admin_flow()
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => Hash::make('admin123')]);
        $this->actingAs($admin);

        $courseData = [
            'name' => 'Test Course 101',
            'code' => 'TC101',
            'category' => 'Testing',
            'credits' => 3,
            'description' => 'A test course description.',
            'fee' => 300,
        ];
        $response = $this->post(route('admin.store-course'), $courseData);
        $response->assertRedirect(route('admin.courses'));
        $this->assertDatabaseHas('courses', ['code' => 'TC101']);

        $createdCourse = Course::where('code', 'TC101')->first();
        $this->assertDatabaseHas('course_fees', ['course_id' => $createdCourse->id, 'amount' => 300]);

        $updatedCourseData = [
            'name' => 'Updated Course Name',
            'description' => 'Updated description.',
            'code' => 'UC102',
            'category' => 'Testing-Updated',
            'credits' => 4,
            'fee' => 400
        ];

        $response = $this->post(route('admin.update-course', $createdCourse->id), $updatedCourseData);
        $response->assertRedirect(route('admin.courses'));

        $this->assertDatabaseHas('courses', ['id' => $createdCourse->id, 'code' => 'UC102']);
        $this->assertDatabaseHas('course_fees', ['course_id' => $createdCourse->id, 'amount' => 400]);

        $this->followingRedirects()
            ->post(route('admin.delete-course', $createdCourse->id))
            ->assertViewIs('admin.courses');

        $this->assertDatabaseMissing('courses', ['id' => $createdCourse->id]);
        $this->assertDatabaseMissing('course_fees', ['course_id' => $createdCourse->id]);

        $teacherData = [
            'name' => 'Test Teacher',
            'email' => 'teacher@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'course_id' => Course::factory()->create()->id,
        ];
        $response = $this->post(route('admin.store-teacher'), $teacherData);
        $response->assertRedirect(route('admin.teachers'));

        $createdTeacher = User::where('email', $teacherData['email'])->first();
        $this->assertNotNull($createdTeacher);
        $this->assertDatabaseHas('teacher_course_assignments', ['teacher_id' => $createdTeacher->id]);

        $newCourse = Course::factory()->create();
        $updatedTeacherData = [
            'name' => 'Updated Teacher Name',
            'email' => 'updatedteacher@example.com',
            'course_id' => $newCourse->id,
        ];

        $response = $this->put(route('admin.update-teacher', $createdTeacher->id), $updatedTeacherData);
        $response->assertRedirect(route('admin.teachers'));

        $this->assertDatabaseHas('users', [
            'id' => $createdTeacher->id,
            'name' => $updatedTeacherData['name'],
            'email' => $updatedTeacherData['email'],
        ]);
        $this->assertDatabaseHas('teacher_course_assignments', [
            'teacher_id' => $createdTeacher->id,
            'course_id' => $newCourse->id,
        ]);

        $this->followingRedirects()
            ->post(route('admin.delete-teacher', $createdTeacher->id))
            ->assertSee('Manage Teachers');

        $this->assertDatabaseMissing('users', ['id' => $createdTeacher->id]);
        $this->assertDatabaseMissing('teacher_course_assignments', ['teacher_id' => $createdTeacher->id]);

        $registrationFee = RegistrationFee::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.revenue'))
            ->assertStatus(200);

        $newFee = 750.50;
        $response = $this->post(route('admin.update-registration-fee.store'), ['registration_fee' => $newFee]);
        $response->assertRedirect(route('admin.revenue'));
        $this->assertDatabaseHas('registration_fees', ['amount' => $newFee]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\TeacherCourseAssignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $teacher;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $this->teacher = User::factory()->create([
            'role' => 'teacher',
            'password' => bcrypt('teacher123'),
        ]);

        $this->course = Course::factory()->create();

        TeacherCourseAssignment::create([
            'teacher_id' => $this->teacher->id,
            'course_id' => $this->course->id,
        ]);
    }

    /**
     * Test the teacher listing page shows all teachers for authenticated admins.
     */
    public function test_teacher_listing_page_shows_all_teachers_for_authenticated_admin()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.teachers'));

        $response->assertStatus(200);
        $response->assertSee('Teachers');
        $response->assertSee($this->teacher->name);
    }

    /**
     * Test the teacher creation form is accessible by authenticated admin users.
     */
    public function test_teacher_creation_form_is_accessible_by_admin()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.create-teacher'));

        $response->assertStatus(200);
        $response->assertSee('Register New Teacher');
    }

    /**
     * Test successful creation of a teacher.
     */
    public function test_successful_teacher_creation()
    {
        $teacherData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'course_id' => $this->course->id,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.store-teacher'), $teacherData);

        $response->assertRedirect(route('admin.teachers'));
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'role' => 'teacher',
        ]);

        $teacher = User::where('email', 'johndoe@example.com')->first();
        $this->assertDatabaseHas('teacher_course_assignments', [
            'teacher_id' => $teacher->id,
            'course_id' => $this->course->id,
        ]);
    }

    /**
     * Test editing a teacher form displays correct details.
     */
    public function test_edit_teacher_form_displays_correct_details()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.edit-teacher', $this->teacher->id));

        $response->assertStatus(200);
        $response->assertSee($this->teacher->name);
        $response->assertSee($this->teacher->email);
    }

    /**
     * Test successful teacher update.
     */
    public function test_successful_teacher_update()
    {
        $updateData = [
            'name' => 'Updated Teacher Name',
            'email' => 'updatedteacher@example.com',
            'course_id' => $this->course->id,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.update-teacher', $this->teacher->id), $updateData);

        $response->assertRedirect(route('admin.teachers'));
        $this->assertDatabaseHas('users', [
            'id' => $this->teacher->id,
            'name' => 'Updated Teacher Name',
            'email' => 'updatedteacher@example.com',
        ]);

        $this->assertDatabaseHas('teacher_course_assignments', [
            'teacher_id' => $this->teacher->id,
            'course_id' => $this->course->id,
        ]);
    }

    /**
     * Test the teacher deletion confirmation page.
     */
    public function test_teacher_deletion_confirmation_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.destroy-teacher', $this->teacher->id));

        $response->assertStatus(200);
        $response->assertSee('Are you sure you want to delete this teacher?');
    }

    /**
     * Test successful teacher deletion.
     */
    public function test_successful_teacher_deletion()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.delete-teacher', $this->teacher->id));

        $response->assertRedirect(route('admin.teachers'));
        $this->assertDatabaseMissing('users', ['id' => $this->teacher->id]);
        $this->assertDatabaseMissing('teacher_course_assignments', ['teacher_id' => $this->teacher->id]);
    }
}
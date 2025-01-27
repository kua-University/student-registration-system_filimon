<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseFee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $courses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();

        $this->courses = Course::factory()
            ->count(3)
            ->has(CourseFee::factory()->state(['amount' => 200]), 'courseFee')
            ->create();
    }

    /**
     * Test the course listing page shows all courses for authenticated admins.
     */
    public function test_course_listing_page_shows_all_courses_for_authenticated_admin()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.courses'));

        $response->assertStatus(200);
        $response->assertSee('Courses');
    }

    /**
     * Test the course creation form is accessible by authenticated admin users.
     */
    public function test_course_creation_form_is_accessible_by_admin()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.create-course'));

        $response->assertStatus(200);
        $response->assertSee('Create Course');
    }

    /**
     * Test successful creation of a course.
     */
    public function test_successful_course_creation()
    {
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

        $response = $this->actingAs($this->admin)->post(route('admin.store-course'), $requestData);

        $response->assertRedirect(route('admin.courses'));

        $this->assertDatabaseHas('courses', $courseData);

        $course = Course::where('code', 'CH201')->first();
        $this->assertDatabaseHas('course_fees', [
            'course_id' => $course->id,
            'amount' => 200,
        ]);
    }

    /**
     * Test editing a course form displays correct details.
     */
    public function test_edit_course_form_displays_correct_details()
    {
        $course = $this->courses->first();

        $response = $this->actingAs($this->admin)->get(route('admin.edit-course', $course->id));

        $response->assertStatus(200);
        $response->assertSee($course->name);
        $response->assertSee($course->description);
    }

    /**
     * Test successful course update.
     */
    public function test_successful_course_update()
    {
        $course = $this->courses->first();

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

        $response = $this->actingAs($this->admin)->post(route('admin.update-course', $course->id), $requestData);

        $response->assertRedirect(route('admin.courses'));
        $this->assertDatabaseHas('courses', $updateData);
    }

    /**
     * Test the course deletion confirmation page.
     */
    public function test_course_deletion_confirmation_page()
    {
        $course = $this->courses->first();

        $response = $this->actingAs($this->admin)->get(route('admin.destroy-course', $course->id));

        $response->assertStatus(200);
        $response->assertSee('Are you sure');
    }

    /**
     * Test successful course deletion.
     */
    public function test_successful_course_deletion()
    {
        $course = $this->courses->first();

        $response = $this->actingAs($this->admin)->post(route('admin.delete-course', $course->id));

        $response->assertRedirect(route('admin.courses'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
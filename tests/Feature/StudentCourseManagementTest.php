<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\StudentCourseEnrollment;
use App\Models\CourseFee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCourseManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $student;
    protected $course;
    protected $enrollment;

    protected function setUp(): void
    {
        parent::setUp();

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
    }

    /**
     * Test the enrolled courses page shows all enrolled courses for the authenticated student.
     */
    public function test_enrolled_courses_page_shows_all_enrolled_courses()
    {
        $response = $this->actingAs($this->student)->get(route('student.enrolled-courses'));

        $response->assertStatus(200);
        $response->assertSee($this->course->name);
    }

    /**
     * Test the available courses page shows all available courses for the authenticated student.
     */
    public function test_available_courses_page_shows_all_available_courses()
    {
        $availableCourse = Course::factory()->create();
        CourseFee::factory()->create([
            'course_id' => $availableCourse->id,
            'amount' => 300,
        ]);

        $response = $this->actingAs($this->student)->get(route('student.available-courses'));

        $response->assertStatus(200);
        $response->assertSee($availableCourse->name);
    }

    /**
     * Test successful enrollment in a course.
     */
    public function test_successful_course_enrollment()
    {
        $newCourse = Course::factory()->create();
        CourseFee::factory()->create([
            'course_id' => $newCourse->id,
            'amount' => 400,
        ]);

        $response = $this->actingAs($this->student)->post(route('student.enroll', $newCourse->id));

        $response->assertRedirect(route('student.course.payment', ['course' => $newCourse->id]));

        $this->assertDatabaseHas('student_course_enrollments', [
            'student_id' => $this->student->id,
            'course_id' => $this->course->id,
            'status' => 'approved',
        ]);
    }

    /**
     * Test enrollment fails if the student is already enrolled in the course.
     */
    public function test_enrollment_fails_if_student_is_already_enrolled()
    {
        $response = $this->actingAs($this->student)->post(route('student.enroll', $this->course->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'You are already enrolled in this course.');

        $this->assertDatabaseCount('student_course_enrollments', 1);
    }
}
<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a student can view their edit profile page.
     */
    public function test_student_can_view_edit_profile_page()
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)
            ->get(route('student.edit-profile'))
            ->assertStatus(200)
            ->assertSee('Edit Profile');
    }

    /**
     * Test that a student can update their profile with valid data.
     */
    public function test_student_can_update_profile_with_valid_data()
    {
        $student = User::factory()->create(['role' => 'student']);

        $newData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ];

        $this->actingAs($student)
            ->put(route('student.update-profile'), $newData)
            ->assertRedirect(route('student.dashboard'));

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);
    }

    /**
     * Test that a student profile update fails with invalid email.
     */
    public function test_student_profile_update_fails_with_invalid_email()
    {
        $student = User::factory()->create(['role' => 'student']);

        $invalidData = [
            'name' => 'Another Name',
            'email' => 'invalid-email',
        ];

        $response = $this->actingAs($student)
            ->put(route('student.update-profile'), $invalidData);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('users', ['email' => 'invalid-email']);
    }

    /**
     * Test that a student profile update fails with missing required fields.
     */
    public function test_student_profile_update_fails_with_missing_required_fields()
    {
        $student = User::factory()->create(['role' => 'student']);

        $emptyData = [
            'name' => '',
            'email' => '',
        ];

        $response = $this->actingAs($student)
            ->put(route('student.update-profile'), $emptyData);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    /**
     * Test that a non-authenticated user cannot access the edit profile page.
     */
    public function test_non_authenticated_user_cannot_access_edit_profile_page()
    {
        $this->get(route('student.edit-profile'))
            ->assertRedirect(route('login'));
    }
}

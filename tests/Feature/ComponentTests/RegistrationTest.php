<?php

namespace Tests\Feature\ComponentTests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the registration form is accessible.
     */
    public function test_registration_form_is_accessible()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    /**
     * Test successful registration of a student.
     */
    public function test_successful_student_registration()
    {
        $studentData = [
            'full_name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('register'), $studentData);

        $response->assertRedirect(route('show.registration.payment'));

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
        ]);

        $user = User::where('email', 'johndoe@example.com')->first();
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test registration fails with invalid email.
     */
    public function test_registration_fails_with_invalid_email()
    {
        $studentData = [
            'full_name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('register'), $studentData);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test registration fails with mismatched passwords.
     */
    public function test_registration_fails_with_mismatched_passwords()
    {
        $studentData = [
            'full_name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ];

        $response = $this->post(route('register'), $studentData);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    /**
     * Test registration fails with missing fields.
     */
    public function test_registration_fails_with_missing_fields()
    {
        $studentData = [
            'full_name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->post(route('register'), $studentData);

        $response->assertSessionHasErrors(['full_name', 'email', 'password']);
        $this->assertGuest();
    }
}
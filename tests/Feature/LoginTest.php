<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected $student;
    protected $payment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = User::factory()->create([
            'role' => 'student',
            'password' => bcrypt('student123'),
        ]);

        $this->payment = Payment::factory()->create([
            'student_id' => $this->student->id,
            'status' => 'completed',
        ]);
    }

    /**
     * Test login with valid credentials
     */
    public function test_login_using_valid_credentials()
    {
        $response = $this->post('/login', [
            'email' => $this->student->email,
            'password' => 'student123',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticatedAs($this->student);
    }

    /**
     * Test login redirects to payment page if payment status is not completed.
     */
    public function test_login_with_valid_credentials_redirects_to_payment_page_if_payment_status_is_not_completed()
    {
        $this->payment->update(['status' => 'pending']);

        $response = $this->post('/login', [
            'email' => $this->student->email,
            'password' => 'student123',
        ]);

        $response->assertRedirect(route('show.registration.payment'));

        $this->assertAuthenticatedAs($this->student);
    }

    /**
     * Test login with invalid credentials.
     */
    public function test_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'wronguser@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test login with empty fields.
     */
    public function test_login_with_empty_fields()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }
}
<?php

namespace Tests\Feature\ComponentTests;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('logs in with valid credentials', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'password' => bcrypt('student123'),
    ]);

    $payment = Payment::factory()->create([
        'student_id' => $student->id,
        'payment_type' => 'registration',
        'status' => 'completed',
    ]);

    $response = $this->post('/login', [
        'email' => $student->email,
        'password' => 'student123',
    ]);

    $response->assertRedirect('/student/dashboard');
    $this->assertAuthenticatedAs($student);
});

it('redirects to payment page if payment status is not completed', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'password' => bcrypt('student123'),
    ]);

    $payment = Payment::factory()->create([
        'student_id' => $student->id,
        'payment_type' => 'registration',
        'status' => 'pending',
    ]);

    $response = $this->post('/login', [
        'email' => $student->email,
        'password' => 'student123',
    ]);

    $response->assertRedirect(route('show.registration.payment'));
    $this->assertAuthenticatedAs($student);
});

it('fails login with invalid credentials', function () {
    $response = $this->post('/login', [
        'email' => 'wronguser@example.com',
        'password' => 'wrongpass',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

it('fails login with empty fields', function () {
    $response = $this->post('/login', [
        'email' => '',
        'password' => '',
    ]);

    $response->assertSessionHasErrors(['email', 'password']);
});

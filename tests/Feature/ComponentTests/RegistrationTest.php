<?php

namespace Tests\Feature\ComponentTests;

use App\Models\{User, RegistrationFee};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('displays the registration form', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
    $response->assertSee('Register');
});

it('registers a student successfully', function () {
    RegistrationFee::factory()->create(['amount' => 50]);
    
    $studentData = [
        'full_name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $this->post(route('register'), $studentData)
         ->assertRedirect(route('show.registration.payment'));
 
    $this->assertDatabaseHas('users', ['name' => 'John Doe']);

    $user = User::where('email', 'johndoe@example.com')->first();
    $this->assertAuthenticatedAs($user);
});

it('fails registration with invalid email', function () {
    $studentData = [
        'full_name' => 'John Doe',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post(route('register'), $studentData);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

it('fails registration with mismatched passwords', function () {
    $studentData = [
        'full_name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'password_confirmation' => 'differentpassword',
    ];

    $response = $this->post(route('register'), $studentData);

    $response->assertSessionHasErrors(['password']);
    $this->assertGuest();
});

it('fails registration with missing fields', function () {
    $studentData = [
        'full_name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    $response = $this->post(route('register'), $studentData);

    $response->assertSessionHasErrors(['full_name', 'email', 'password']);
    $this->assertGuest();
});

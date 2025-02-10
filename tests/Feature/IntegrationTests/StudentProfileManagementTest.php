<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('allows a student to view their edit profile page', function () {
    $student = User::factory()->create(['role' => 'student']);

    $response = $this->actingAs($student)
        ->get(route('student.edit-profile'));

    $response->assertStatus(200);
    $response->assertSee('Edit Profile');
});

it('allows a student to update their profile with valid data', function () {
    $student = User::factory()->create(['role' => 'student']);

    $newData = [
        'name' => 'Updated Name',
        'email' => 'updatedemail@example.com',
    ];

    $response = $this->actingAs($student)
        ->put(route('student.update-profile'), $newData);

    $response->assertRedirect(route('student.dashboard'));

    $this->assertDatabaseHas('users', [
        'id' => $student->id,
        'name' => 'Updated Name',
        'email' => 'updatedemail@example.com',
    ]);
});

it('fails profile update with an invalid email', function () {
    $student = User::factory()->create(['role' => 'student']);

    $invalidData = [
        'name' => 'Another Name',
        'email' => 'invalid-email',
    ];

    $response = $this->actingAs($student)
        ->put(route('student.update-profile'), $invalidData);

    $response->assertSessionHasErrors(['email']);
    $this->assertDatabaseMissing('users', ['email' => 'invalid-email']);
});

it('fails profile update with missing required fields', function () {
    $student = User::factory()->create(['role' => 'student']);

    $emptyData = [
        'name' => '',
        'email' => '',
    ];

    $response = $this->actingAs($student)
        ->put(route('student.update-profile'), $emptyData);

    $response->assertSessionHasErrors(['name', 'email']);
});

it('prevents non-authenticated users from accessing the edit profile page', function () {
    $this->get(route('student.edit-profile'))
        ->assertRedirect(route('login'));
});

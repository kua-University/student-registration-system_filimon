<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use App\Models\RegistrationFee;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('admin views revenue report and updates registration fee', function () {
    // Create an admin user
    $admin = User::factory()->create(['role' => 'admin']);

    // Create a registration fee
    RegistrationFee::factory()->create();

    // Admin logs in and views the revenue report
    $this->actingAs($admin)
        ->get(route('admin.revenue'))
        ->assertStatus(200)
        ->assertSee('Total Revenue');

    // Admin updates the registration fee
    $newFee = 150;
    $this->post(route('admin.update-registration-fee.store'), [
        'registration_fee' => $newFee,
    ])->assertRedirect(route('admin.revenue'));

    // Confirm database reflects the updated fee
    $this->assertDatabaseHas('registration_fees', [
        'amount' => $newFee,
    ]);
});

it('fails when admin updates registration fee with a negative value', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.update-registration-fee.store'), [
            'registration_fee' => -50,
        ])
        ->assertSessionHasErrors('registration_fee');
});

it('fails when admin updates registration fee with a missing value', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.update-registration-fee.store'), [])
        ->assertSessionHasErrors('registration_fee');
});

it('fails when admin updates registration fee with a non-numeric value', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.update-registration-fee.store'), [
            'registration_fee' => 'abc',
        ])
        ->assertSessionHasErrors('registration_fee');
});

<?php

namespace Tests\Feature\IntegrationTests;

use App\Models\User;
use App\Models\RegistrationFee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRevenueManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the workflow where an admin logs in, views the revenue report, and updates the registration fee.
     */
    public function test_admin_views_revenue_report_and_updates_registration_fee()
    {
        // Create an admin user
        $admin = User::factory()->create(['role' => 'admin']);

        // Create a registration fee
        $registrationFee = RegistrationFee::factory()->create();

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
    }


    /**
     * Test updating registration fee with an invalid input (negative value).
     */
    public function test_admin_updates_registration_fee_with_negative_value_fails()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.update-registration-fee.store'), [
                'fee' => -50,
            ])
            ->assertSessionHasErrors('registration_fee');
    }

    /**
     * Test missing fee input when updating the registration fee.
     */
    public function test_admin_updates_registration_fee_with_missing_value_fails()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.update-registration-fee.store'), [])
            ->assertSessionHasErrors('registration_fee');
    }

    /**
     * Test updating registration fee with a non-numeric value fails.
     */
    public function test_admin_updates_registration_fee_with_non_numeric_value_fails()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.update-registration-fee.store'), [
                'registration_fee' => 'abc',
            ])
            ->assertSessionHasErrors('registration_fee');
    }
}
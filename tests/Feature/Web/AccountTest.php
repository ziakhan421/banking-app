<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_deposit_create_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('accounts.deposit.create'));

        $response->assertStatus(200)
            ->assertViewIs('web.account.deposit');
    }

    /** @test */
    public function it_can_store_deposit_amount_to_account()
    {
        $user = User::factory()->create();
        $user->account()->create(['balance' => 1000]);

        $response = $this->actingAs($user)->post(route('accounts.deposit.store'), [
            'amount' => 500,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Amount deposited successfully.');

        $this->assertEquals(1500, $user->account->fresh()->balance);
    }

    /** @test */
    public function it_can_show_withdraw_create_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('accounts.withdraw.create'));

        $response->assertStatus(200)
            ->assertViewIs('web.account.withdraw');
    }

    /** @test */
    public function it_can_store_withdrawal_amount_from_account()
    {
        $user = User::factory()->create();
        $user->account()->create(['balance' => 1000]);

        $response = $this->actingAs($user)->post(route('accounts.withdraw.store'), [
            'amount' => 500,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Amount withdrawal successfully.');

        $this->assertEquals(500, $user->account->fresh()->balance);
    }

    /** @test */
    public function it_prevents_withdrawal_if_insufficient_balance()
    {
        $user = User::factory()->create();
        $user->account()->create(['balance' => 100]);

        $response = $this->actingAs($user)->post(route('accounts.withdraw.store'), [
            'amount' => 500,
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors(['amount' => 'Insufficient balance.']);

        $this->assertEquals(100, $user->account->fresh()->balance);
    }

    /** @test */
    public function it_can_show_transfer_create_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('accounts.transfer.create'));

        $response->assertStatus(200)
            ->assertViewIs('web.account.transfer');
    }

    /** @test */
    public function it_can_store_transfer_amount_to_another_account()
    {
        $user = User::factory()->create();
        $user->account()->create(['balance' => 1000]);

        $receiver = User::factory()->create();
        $receiver->account()->create(['balance' => 500]);

        $response = $this->actingAs($user)->post(route('accounts.transfer.store'), [
            'email' => $receiver->email,
            'amount' => 300,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Amount transferred successfully.');

        $this->assertEquals(700, $user->account->fresh()->balance);
        $this->assertEquals(800, $receiver->account->fresh()->balance);
    }

    /** @test */
    public function it_prevents_transfer_if_insufficient_balance()
    {
        $user = User::factory()->create();
        $user->account()->create(['balance' => 100]);

        $receiver = User::factory()->create();
        $receiver->account()->create(['balance' => 500]);

        $response = $this->actingAs($user)->post(route('accounts.transfer.store'), [
            'email' => $receiver->email,
            'amount' => 200,
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors(['amount' => 'Insufficient balance.']);

        $this->assertEquals(100, $user->account->fresh()->balance);
        $this->assertEquals(500, $receiver->account->fresh()->balance);
    }

    /** @test */
    public function it_prevents_transfer_to_nonexistent_user()
    {
        $user = User::factory()->create();
        $user->account()->create(['balance' => 1000]);

        $response = $this->actingAs($user)->post(route('accounts.transfer.store'), [
            'email' => 'nonexistent@example.com',
            'amount' => 300,
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors(['email' => 'The requested email address does not found.']);

        $this->assertEquals(1000, $user->account->fresh()->balance);
    }

}

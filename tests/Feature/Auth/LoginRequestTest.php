<?php

namespace Tests\Feature\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_authenticates_user_with_valid_credentials()
    {
        $user = User::factory()->create();

        $request = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->assertFalse(Auth::check());

        $loginRequest = new LoginRequest($request);

        try {
            $loginRequest->authenticate();
        } catch (ValidationException $e) {
            // Catch validation exception for invalid credentials
            $this->fail('Authentication failed unexpectedly: ' . $e->getMessage());
        }

        $this->assertTrue(Auth::check());
    }

    /** @test */
    public function it_throttles_login_attempts_after_multiple_failures()
    {
        $request = new LoginRequest([
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $this->expectException(ValidationException::class);

        for ($i = 0; $i < 6; $i++) {
            $request->authenticate();
        }

        $this->assertFalse(Auth::check());
    }

}

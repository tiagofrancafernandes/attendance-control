<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanAuthenticateUsingToken(): void
    {
        $user = User::factory()->create();
        $token = $user->plainTextToken('testUsersCanAuthenticateUsingToken');
        $this->assertTrue(is_string($token) && ((bool) trim($token)));

        $response = $this->withHeaders([
            'Authorization' =>  "Bearer {$token}",
        ])->postJson(
            route('user_info'),
            [
                'select' =>  [
                    'id',
                    'name',
                ],
            ]
        );

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('name', $user->name);
    }

    public function testUsersCanGenerateToken(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $token = $user->plainTextToken('testUsersCanGenerateToken');
        $this->assertTrue(is_string($token) && ((bool) trim($token)));

        $response = $this->withHeaders([
            'Authorization' =>  "Bearer {$token}",
        ])->postJson(
            route('login'),
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );

        $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonPath('token', fn ($item) => $item && \strlen($item) > 20)
        ->assertJsonPath('user.id', fn ($item) => $item && Str::isUuid($item))
        ->assertJsonPath('user.name', fn ($item) => $item == $user->name)
        ->assertJsonPath('user.email', fn ($item) => $item && filter_var($item, FILTER_VALIDATE_EMAIL));
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->postJson(
            route('login'),
            [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]
        )->assertStatus(422)
        ->assertJsonCount(2)
        ->assertJsonPath('message', 'These credentials do not match our records.')
        ->assertJsonPath('errors.email.0', 'These credentials do not match our records.');

        $this->postJson(
            route('login'),
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        )->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonPath('token', fn ($item) => $item && \strlen($item) > 20);
    }
}

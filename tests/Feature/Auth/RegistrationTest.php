<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testNewUsersCanRegister(): void
    {
        $user = User::factory()->make();

        $response = $this->postJson(
            route('register'),
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        )
        ->assertStatus(201)
        ->assertJsonCount(3)
        ->assertJsonPath('message', 'Account created successfully')
        ->assertJsonPath('token', fn ($item) => $item && \strlen($item) > 20)
        ->assertJsonPath('user.id', fn ($item) => $item && Str::isUuid($item))
        ->assertJsonPath('user.name', fn ($item) => $item == $user->name)
        ->assertJsonPath('user.email', fn ($item) => $item && filter_var($item, FILTER_VALIDATE_EMAIL));
    }
}

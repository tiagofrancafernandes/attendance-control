<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => \sprintf('Project ', Str::random(5)),
            'created_by' => User::factory(),
            'owner_id' => fn ($attr) => ($attr['created_by'] ?? null) ?: User::factory(),
        ];
    }
}

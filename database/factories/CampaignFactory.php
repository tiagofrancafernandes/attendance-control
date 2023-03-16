<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => \sprintf('Campaign %s', Str::random(5)),
            'description' => fake()->boolean(70) ? fake()->words(6, true) : \null,
            'created_by' => User::factory(),
            'tags' => Arr::random([
                \null,
                \fake()->words(\rand(2, 6)),
            ]),
            'active' => (bool) (rand() % 2),
            'project_id' => fn ($attr) => ($attr['created_by'] ?? null)
                ? Project::factory(state: [
                    'created_by' => $attr['created_by'],
                ])
                : Project::factory(),
        ];
    }
}

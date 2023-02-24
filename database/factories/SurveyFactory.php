<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use App\Models\SurveyType;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => \sprintf('Survey ', Str::random(5)),
            'created_by' => User::factory(),
            'description' => fake()->boolean(70) ? fake()->words(6, true) : \null,
            'active' => fake()->boolean(90),
            'published' => fake()->boolean(90),
            'will_start_in' => Arr::random([
                now()->subDays(10),
                now()->subDays(20),
                now()->subDays(30),
                \null,
                \null
            ]),
            'will_finish_in' => Arr::random([
                \null,
                now()->subDays(1),
                now()->subDays(3),
                now()->subDays(5),
                now()->addDays(20),
                now()->addDays(30),
                now()->addDays(rand(60, 90)),
                \null,
                \null
            ]),
            'project_id' => fn ($attr) => ($attr['created_by'] ?? null)
                ? Project::factory(state: [
                    'created_by' => $attr['created_by'],
                ])
                : Project::factory(),
            'survey_type' => fn ($attr) => Arr::random([
                SurveyType::factory(state: [
                    'project_id' => $attr['project_id'],
                ]),
                SurveyType::factory(),
                \null,
            ]),
            'tags' => Arr::random([
                \null,
                \fake()->words(\rand(2, 6)),
            ]),
        ];
    }
}

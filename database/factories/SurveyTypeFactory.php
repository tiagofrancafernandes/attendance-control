<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyType>
 */
class SurveyTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => \sprintf('Type ', \fake()->words(3, true)),
            'initial_template' => \null,
            'project_id' => Arr::random([null, Project::factory()]),
            'is_global' => fn ($attr) => !($attr['project_id'] ?? \null) ? true : (bool) (rand() % 2),
            'active' => (bool) (rand() % 2),
        ];
    }
}

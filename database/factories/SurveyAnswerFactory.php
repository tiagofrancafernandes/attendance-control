<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyAnswer>
 */
class SurveyAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'survey_id' => Survey::factory(),
            'campaign_id' => \null,
            'answer_data' => [
                'rating' => \rand(0, 10),
                'message' => Arr::random([
                    \null, \null, \null, \null,
                    \fake()->words(rand(3, 6), true),
                ]),
            ],
            'flag_01' => 'via_faker',
            'flag_02' => 'client_id_' . rand(8777, 11878),
        ];
    }
}

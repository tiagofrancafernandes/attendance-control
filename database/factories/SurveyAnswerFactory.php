<?php

namespace Database\Factories;

use App\Models\Survey;
use App\Models\Campaign;
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
            'campaign_id' => Arr::random([
                Campaign::factory(),
                \null
            ]),
            'answer_data' => [
                'question_01' => \fake()->words(5, true),
                'question_02' => \fake()->words(rand(3, 9), true),
                'question_03' => \fake()->words(rand(3, 9), true),
                'question_long' => \fake()->paragraphs(asText: true),
            ],
            'responder_identifier_01' => 'via_faker',
            'responder_identifier_02' => 'client_id_' . rand(8777, 11878),
        ];
    }
}

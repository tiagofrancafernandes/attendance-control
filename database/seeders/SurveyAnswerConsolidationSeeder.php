<?php

namespace Database\Seeders;

use App\Models\Survey;
use Illuminate\Support\Str;
use App\Models\SurveyAnswer;
use Illuminate\Database\Seeder;

class SurveyAnswerConsolidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php'),
        ]);

        $surveyAnswers = SurveyAnswer::factory(10)->create([
            'survey_id' => $survey->id,
            'answer_data' => [
                'vote' => rand(1, 5),
                'message' => Str::random(10),
            ],
        ]);
    }
}

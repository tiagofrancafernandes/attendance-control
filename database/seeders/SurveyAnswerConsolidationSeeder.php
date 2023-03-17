<?php

namespace Database\Seeders;

use App\Models\Survey;
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
        $demoId = '98b5c111-2c24-4c2b-89c5-68c666bcc44d';

        $demoData = Survey::factory()->make([
            'id' => $demoId,
            'questions' => require \resource_path('survay_templates/nps-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $demoSurvey = Survey::updateOrCreate([
            'id' => $demoId,
        ], $demoData->toArray());

        if ($demoSurvey) {
            $demoSurveyAnswerData =
                [
                    'survey_id' => $demoSurvey->id,
                    'flag_01' => 'cli-123',
                    'flag_02' => 'pages/page1.html'
                ];

            $demoSurveyAnswerData['answer_data'] = \array_merge(
                $demoSurveyAnswerData,
                [
                    'rating' => 10,
                    'message' => 'Customer message',
                ]
            );

            $demoSurveyAnswer = SurveyAnswer::updateOrCreate(
                [
                    'survey_id' => $demoSurvey->id,
                    'flag_01' => 'cli-123',
                    'flag_02' => 'pages/page1.html',
                ],
                $demoSurveyAnswerData
            );

            echo \PHP_EOL;
            \dump("Demo survey ID: {$demoSurvey->id}");
            echo \PHP_EOL;
            \dump("Demo answer ID: {$demoSurveyAnswer->id}");
            echo \PHP_EOL;
        }

        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php'),
        ]);

        SurveyAnswer::factory(10)
            ->create([
                'survey_id' => $survey->id,
            ]);
    }
}

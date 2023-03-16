<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Survey;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Illuminate\Testing\Fluent\AssertableJson;

class SurveyAnswerTest extends TestCase
{
    /**
     *
     * @test
     * put an answer to survey withow required values
     *
     * @return void
     */
    public function invalidForm()
    {
        $response = $this->post(\route('surveys.new_answer'));

        $response->assertStatus(302);

        $response->assertInvalid([
            'survey_id' => 'The survey id field is required.'
        ]);
    }

    /**
     *
     * @test
     *
     * @return void
     */
    public function invalidSurveyId()
    {
        $response = $this->post(
            \route('surveys.new_answer'),
            [
                'survey_id' => Str::uuid()->toString(),
            ]
        );

        $response->assertStatus(404);

        $response->assertJsonCount(0);
    }

    /**
     *
     * @test
     *
     * @return void
     */
    public function putAnAnswerToSurvey()
    {
        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php')
        ]);

        /**
         * @var TestResponse $response
         */
        $response = $this->post(
            \route('surveys.new_answer'),
            [
                'survey_id' => $survey->id,
                'rating' => \rand(0, 10), // NPS
                'flag_01' => 'cli_0123',
                'flag_02' => 'tdd_test',
                'message' => Str::random(10),
            ]
        );

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonCount(2);
        $response->assertJsonCount(1, 'data');

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->whereAllType([
                    'data' => 'array',
                    'data.answer' => 'string|null',
                ])->etc()
        );

        $response->assertJsonPath('data.answer', fn ($item) => \is_null($item) || Str::isUuid($item));
    }

    /**
     *
     * @test
     *
     * @return void
     */
    public function validateFlagOnAnswer()
    {
        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $flag_01 = $flag_02 = \null;

        $postData = [
            'survey_id' => $survey->id,
            'rating' => \rand(0, 10), // NPS
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'message' => Str::random(10),
        ];

        $survey->answers()->create([
            'survey_id' => $survey->id,
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'answer_data' => $postData,
        ]);

        /**
         * @var TestResponse $response
         */
        $response = $this->post(
            \route('surveys.new_answer'),
            $postData
        );

        $response->assertStatus(302);

        $response->assertInvalid([
            'flag_01' => 'The flag 01 field is required when hflag 01 is not present.',
        ]);
    }

    /**
     *
     * @test
     *
     * @return void
     */
    public function validateLimitToOneAnswer()
    {
        $flag_01 = 'cli_999';
        $flag_02 = 'tdd_test|oneAnsuer';

        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $postData = [
            'survey_id' => $survey->id,
            'rating' => \rand(0, 10), // NPS
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'message' => Str::random(10),
        ];

        $survey->answers()->create([
            'survey_id' => $survey->id,
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'answer_data' => $postData,
        ]);

        /**
         * @var TestResponse $response
         */
        $response = $this->post(
            \route('surveys.new_answer'),
            $postData
        );

        $response->assertStatus(302);

        $response->assertInvalid([
            'answered' => 'An answer has already been sent previously.',
        ]);
    }

    /**
     *
     * @test
     *
     * @return void
     */
    public function validateHashOnFlagInputAnswer()
    {
        $flag_01 = 'cli_789';
        $flag_02 = 'tdd_test|HashOnFlag';

        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $postData = [
            'survey_id' => $survey->id,
            'rating' => \rand(0, 10), // NPS
            'hflag_01' => \base64_encode($flag_01),
            'hflag_02' => \base64_encode($flag_02),
            'message' => Str::random(10),
        ];

        $survey->answers()->create([
            'survey_id' => $survey->id,
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'answer_data' => $postData,
        ]);

        /**
         * @var TestResponse $response
         */
        $response = $this->post(
            \route('surveys.new_answer'),
            $postData
        );

        $response->assertStatus(302);

        $response->assertInvalid([
            'answered' => 'An answer has already been sent previously.',
        ]);
    }

    /**
     *
     * @test
     *
     * @return void
     */
    public function getSurveyResultList()
    {
        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/nps-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $ratings = [
            0 => 5,
            2 => 4,
            3 => 1,
            5 => 5,
            7 => 9,
            9 => 10,
            10 => 20,
        ];

        $inc = 1;
        foreach ($ratings as $rating => $count) {
            if (!$count || !is_integer($count)) {
                continue;
            }

            foreach (range(1, $count) as $ii) {
                $postData = [
                    'survey_id' => $survey->id,
                    'rating' => $rating, // NPS
                    'flag_01' => "cli_997{$inc}{$ii}",
                    'flag_02' => 'tdd_test|getSurveyResultList',
                    'message' => null,
                ];

                $survey->answers()->create(
                    \array_merge(
                        $postData,
                        [
                            'answer_data' => $postData,
                        ]
                    )
                );

                $inc++;
            }
        }

        /**
         * @var TestResponse $response
         */
        $response = $this->post(
            \route('surveys.result_list'),
            ['survey_id' => $survey->id, ]
        );

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonCount(2);
        $response->assertJsonCount(3, 'data');

        $response->assertJsonPath('data.answer_values.rating.0', 5);
        $response->assertJsonPath('data.answer_values.rating.2', 4);
        $response->assertJsonPath('data.answer_values.rating.3', 1);
        $response->assertJsonPath('data.answer_values.rating.5', 5);
        $response->assertJsonPath('data.answer_values.rating.7', 9);
        $response->assertJsonPath('data.answer_values.rating.9', 10);
        $response->assertJsonPath('data.answer_values.rating.10', 20);

        $response->assertJsonPath('data.surveyId', fn ($item) => \is_null($item) || Str::isUuid($item));
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->whereAllType([
                    'data' => 'array',
                    'data.answer_values' => 'array',
                    'data.answer_values.rating' => 'array',
                    'data.answerCount' => 'integer',
                ])->etc()
        );
    }
}

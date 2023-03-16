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
            'questions' => require \resource_path('survay_templates/level-of-satisfaction-01.php')
        ]);

        /**
         * @var TestResponse $response
         */
        $response = $this->post(
            \route('surveys.new_answer'),
            [
                'survey_id' => $survey->id,
                'vote' => rand(1, 5),
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
            'questions' => require \resource_path('survay_templates/level-of-satisfaction-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $flag_01 = $flag_02 = \null;

        $postData = [
            'survey_id' => $survey->id,
            'vote' => rand(1, 5),
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'message' => Str::random(10),
        ];

        $survey->answers()->create([
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
            'questions' => require \resource_path('survay_templates/level-of-satisfaction-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $postData = [
            'survey_id' => $survey->id,
            'vote' => rand(1, 5),
            'flag_01' => $flag_01,
            'flag_02' => $flag_02,
            'message' => Str::random(10),
        ];

        $survey->answers()->create([
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
        $flag_02 = 'tdd_test|oneAnsuer';

        $survey = Survey::factory()->createOne([
            'questions' => require \resource_path('survay_templates/level-of-satisfaction-01.php'),
            'limit_to_1_answer' => \true,
        ]);

        $postData = [
            'survey_id' => $survey->id,
            'vote' => rand(1, 5),
            'hflag_01' => \base64_encode($flag_01),
            'hflag_02' => \base64_encode($flag_02),
            'message' => Str::random(10),
        ];

        $survey->answers()->create([
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Helpers\StringHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class SurveyAnswerController extends Controller
{
    /**
     * function newAnswer
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function newAnswer(Request $request): JsonResponse
    {
        $request->validate([
            'survey_id' => 'required|uuid',
        ]);

        $survey = Survey::whereId($request->input('survey_id'))->first();

        if (!$survey) {
            return response()->json([], 404);
        }

        /**
         * @var Collection $questions
         */
        $questions = \collect($survey->questions);  // TODO mover linhas abaixo para uma classe chamada SurveyQuestions

        /**
         * @var Collection $questions
         */
        $inputs = \collect($questions->get('inputs'));

        $inputNames = [];
        $rules = [];

        $flag_01 = $flag_02 = \null;

        static::getFlagIds($request, $flag_01, $flag_02);

        if ($survey->limit_to_1_answer) {
            $rules['flag_01'] = 'required_without:hflag_01|string|min:3';
            $rules['hflag_01'] = 'nullable|string|min:3';
        }

        $inputs->each(function ($input) use (&$rules, &$inputNames) {
            if (!$input) {
                return;
            }

            $input = \collect($input);

            if (!$input->has('name')) {
                return;
            }

            $inputNames[] = $input->get('name');

            if (!$input->has('validation') || !$input->get('validation')) {
                return;
            }

            $rules[$input->get('name')] = $input->get('validation');
        });

        $onlyInputs = $request->only(
            \array_merge(
                $inputNames,
                [
                    'flag_01',
                    'hflag_01',
                ]
            )
        );

        if ($rules) {
            (new Request($onlyInputs))
                ->validate($rules);
        }

        if ($survey->limit_to_1_answer) {
            $existsAnAnswer = $survey->answers()
                ->where('flag_01', $flag_01)
                ->where('flag_02', $flag_02)
                ->exists();

            if ($existsAnAnswer) {
                return response()->json([
                    'errors' => [
                        'answered' => 'An answer has already been sent previously.',
                    ]
                ], 302);
            }
        }

        try {
            $surveyAnswer = $survey->answers()->create([
                'answer_data' => \collect($onlyInputs)->merge([
                    'flag_01' => $flag_01,
                    'flag_02' => $flag_02,
                ])->all(),
                'survey_id' => $survey->id,
                'campaign_id' => $survey->campaign_id,
                'flag_01' => $flag_01 ?: \null,
                'flag_02' => $flag_02 ?: \null,
            ]);
        } catch (\Throwable $th) {
            $reponse = [
                'message' => 'Fail on save answer',
            ];

            if (
                !app()->environment([
                    'production',
                    'beta',
                ])
            ) {
                $reponse['trace'] = $th->getTrace();
            }

            \Log::error($th);

            return response()->json($reponse, 500);
        }

        $reponse ??= [];
        $reponseStatus = 200;

        if ($surveyAnswer ?? \null) {
            $reponse['success'] = true;

            $reponse['data'] = [
                'answer' => $surveyAnswer->id ?? \null,
            ];

            $reponseStatus = 201;
        }

        return response()->json($reponse, $reponseStatus ?: 200);
    }

    /**
     * function surveyResultList
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function surveyResultList(Request $request): JsonResponse
    {
        $request->validate([
            'survey_id' => 'required|uuid',
        ]);

        $survey = Survey::whereId($request->input('survey_id'))->first();

        if (!$survey) {
            return response()->json([], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $survey->getResultList(true),
        ], 200);
    }

    /**
     * function answered
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function answered(Request $request): JsonResponse
    {
        $request->validate([
            'survey_id' => 'required|uuid',
            'flag_01' => 'required_without:hflag_01|string|min:3',
            'hflag_01' => 'nullable|string|min:3',
            'flag_02' => 'required_without:hflag_02|string|min:3',
            'hflag_02' => 'nullable|string|min:3',
        ]);

        $survey = Survey::whereId($request->input('survey_id'))->first();

        if (!$survey) {
            return response()->json([], 404);
        }

        $flag_01 = $flag_02 = \null;

        static::getFlagIds($request, $flag_01, $flag_02);

        $existsAnAnswer = $flag_01 ? $survey->answers()
            ->where('flag_01', $flag_01)
            ->where('flag_02', $flag_02)
            ->exists() : \false;

        return response()->json([
            'answered' => $existsAnAnswer,
            'message' => $existsAnAnswer
                ? 'An answer has already been sent previously.'
                : 'This survey has not yet been answered.',
        ], 200);
    }

    /**
     * function myFunction
     *
     * @param Request $request
     * @param string &$flag_01
     * @param string &$flag_02
     *
     * @return void
     */
    protected static function getFlagIds(Request $request, &$flag_01, &$flag_02): void
    {
        // 'hflag_01' or 'hflag_02' is a way to send an identify as base64 hash for flag_01/02
        $hashedFlag_01 = StringHandler::base64Decode($request->string('hflag_01'));
        $hashedFlag_02 = StringHandler::base64Decode($request->string('hflag_02'));

        $flag_01 = $hashedFlag_01 ?: $request->string(
            'flag_01',
            $request->string('flag_01')
        );

        $flag_02 = $hashedFlag_02 ?: $request->string(
            'flag_02',
            $request->string('flag_02')
        );
    }
}

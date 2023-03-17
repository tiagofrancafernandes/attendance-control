<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * function myFunction
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = ($perPage = (int) $request->integer('per_page', 10)) > 0 && $perPage < 150 ? $perPage : 10;

        $allowedValuesToGet = [
            'id',
            'name',
            'description',
            'created_by',
            'project_id',
            'campaign_id',
            'survey_type',
            'questions',
            'active',
            'tags',
            'published',
            'will_start_in',
            'will_finish_in',
            'started_at',
            'limit_to_1_answer',
        ];

        $keyToGetEvery = [
            'id',
            'name',
            'active',
            'limit_to_1_answer',
            'created_at',
        ];

        $defaultValuesToGet = [
            'description',
            'project_id',
            'campaign_id',
            'published',
        ];

        $requestedKeysToGet = \is_array(
            $requestedKeysToGet = $request->input('add_select', [])
        )
            ? \array_values($requestedKeysToGet)
            : $defaultValuesToGet;

        $valuesToGet = array_values(\array_filter(
            array_values(array_merge($keyToGetEvery, $requestedKeysToGet)),
            fn ($item) => \in_array($item, $allowedValuesToGet)
        ));

        $surveys = Survey::select($valuesToGet)->latest('created_at')->paginate($perPage);

        return response()->json($surveys, 200);
    }
}

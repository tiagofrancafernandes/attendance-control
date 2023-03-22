<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Core\CollectModel\Base;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class SurveyQuestions extends Base
{
    public Survey $survey;
    public Collection $questions;
    public HasMany $answers;
    public Collection $inputs;
    public Collection $title;

    protected static array $protectedToSet = [
        'survey',
        'questions',
        'answers',
        'inputs',
        'title',
    ];

    protected static array $protectedToGet = [
        //
    ];

    public function __construct(?Survey $survey)
    {
        if (!$survey) {
            return null;
        }

        $this->survey = $survey;
        $this->questions = $this->collectAll($survey->questions);
        $this->answers = $survey->answers();
        $this->inputs = $this->collectAll($this->questions->get('inputs'));
        $this->title = $this->collectAll($this->questions->get('title'));

        return $this;
    }

    /**
     * function getRequiredInputs
     *
     * @param ?string $key Dot notation
     *
     * @return mixed
     */
    public function getRequiredInputs(?string $key = \null): mixed
    {
        $result = $this->collectAll($this->inputs)
            ->filter(
                fn ($input) => collect($input)->get('required')
            );

        if (!$key) {
            return \collect($result);
        }

        return $result->map(fn ($item) => Arr::get($item, $key));
    }

    /**
     * function getReportKeys
     *
     * @param ?int $maxOfKeys Used for limitations (TODO: no limit for paid)
     *
     * @return Collection
     */
    public function getReportKeys(?int $maxOfKeys = \null): Collection
    {
        $validateKeys = fn (Collection $input) => $input->get('required') &&
        $input->get('key_for_reports') && (
            \in_array(
                $input->get('type'),
                [
                    'select',
                    'select_list',
                    'binary_option',
                    'single_line_text',
                ],
                true
            ) ||
            \in_array(
                $input->get('type'),
                [
                    'select',
                    'select_list',
                ],
                true
            ) && !$input->get('multi_select')
        );

        $result = $this->collectAll($this->inputs)
            ->filter(fn ($input) => $validateKeys(\collect($input)))
            ->map(fn ($item) => Arr::get($item, 'name'));

        // TODO: filter only count $maxOfKeys
        if (!$maxOfKeys) {
            return \collect($result);
        }

        return \collect($result);
    }

    /**
     * function resultList
     *
     * @param ?bool $undot
     *
     * @return mixed
     */
    public function resultList(?bool $undot = false): mixed
    {
        /**
         * @var ?int $maxOfKeys
         */
        $maxOfKeys = \null; // WIP

        $reportKeys = $this->getReportKeys($maxOfKeys);

        if (!$reportKeys->count()) {
            return null;
        }

        $answers = $this->answers->select('id', 'survey_id', 'answer_data')->get();

        // WIP
        $result = \collect();

        $result->put('answerCount', (int) $answers->count());
        $result->put('surveyId', $this->survey->id);

        $answers->each(
            function (SurveyAnswer $surveyAnswer) use (&$result, $reportKeys) {
                $fields = $reportKeys->all();

                foreach ($fields as $field) {
                    if (!\is_string($field)) {
                        continue;
                    }

                    $value = $surveyAnswer->answer_data->get($field);

                    try {
                        $value = (string) $value;
                    } catch (\Throwable $th) {
                        Log::error([
                            'error' => $th->getMessage(),
                            'file' => $th->getFile(),
                            'line' => $th->getLine(),
                            'value' => $value,
                            'valueType' => \gettype($value),
                            'surveyAnswer' => $surveyAnswer->id,
                            'survey' => $surveyAnswer->survey_id,
                        ]);

                        if (!app()->environment(['production', 'beta'])) {
                            throw $th;
                        }

                        continue;
                    }

                    $key = "answer_values.{$field}.{$value}";
                    $currentTotal = (int) $result->get($key, 0);
                    $newTotal = ++$currentTotal;

                    $result->forget($key);
                    $result->put($key, $newTotal);
                }
            }
        );

        if ($undot) {
            return $result->undot();
        }

        return $result;
    }
}

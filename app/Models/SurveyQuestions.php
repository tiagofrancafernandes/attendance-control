<?php

namespace App\Models;

use Illuminate\Support\Arr;
use App\Core\CollectModel\Base;
use Illuminate\Support\Collection;

class SurveyQuestions extends Base
{
    public Survey $survey;
    public Collection $questions;
    public Collection $inputs;
    public Collection $title;

    protected static array $protectedToSet = [
        'survey',
        'questions',
        'inputs',
        'title',
    ];

    protected static array $protectedToGet = [
        //
    ];

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
        $this->questions = $this->collectAll($survey->questions);
        $this->inputs = $this->collectAll($this->questions->get('inputs'));
        $this->title = $this->collectAll($this->questions)->get('title');

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

        // return \collect(Arr::get($result, $key));
        return $result->map(fn ($item) => Arr::get($item, $key));
    }
}

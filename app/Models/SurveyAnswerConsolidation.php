<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswerConsolidation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'survey_id',
        'report_data',
    ];

    protected $casts = [
        'report_data' => AsCollection::class,
    ];

    /**
     * Get the survey that owns the SurveyAnswerConsolidation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}

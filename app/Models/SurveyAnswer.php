<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyAnswer extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'survey_id',
        'campaign_id',
        'answer_data',
        'responder_identifier_01',
        'responder_identifier_02',
    ];

    protected $casts = [
        'answer_data' => AsCollection::class,
    ];

    /**
     * Get the survey that owns the Survey
     *
     * @return BelongsTo
     */
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the campaign that owns the Survey
     *
     * @return BelongsTo
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}

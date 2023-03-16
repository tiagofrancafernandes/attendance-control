<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\SurveyAnswer
 *
 * @property string $id
 * @property string $survey_id
 * @property string|null $campaign_id
 * @property AsCollection $answer_data
 * @property string|null $flag_01
 * @property string|null $flag_02
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Campaign|null $campaign
 * @property-read \App\Models\Survey $survey
 * @method static \Database\Factories\SurveyAnswerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereAnswerData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereResponderIdentifier01($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereResponderIdentifier02($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereUpdatedAt($value)
 * @property string|null $responder_identifier_01
 * @property string|null $responder_identifier_02
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereFlag01($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyAnswer whereFlag02($value)
 * @mixin \Eloquent
 */
class SurveyAnswer extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'survey_id',
        'campaign_id',
        'answer_data',
        'flag_01', // Sugest for responder ID (userXYZ, customerXYZ, XXXSSSSZZZ, user#ZXD)
        'flag_02', // Sugest for internal use (postX, pageX, productX, ...)
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

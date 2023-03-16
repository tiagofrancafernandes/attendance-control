<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Survey
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $created_by
 * @property string $project_id
 * @property bool|null $active
 * @property bool|null $published
 * @property \Illuminate\Support\Carbon|null $will_start_in
 * @property \Illuminate\Support\Carbon|null $will_finish_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Project $project
 * @method static \Database\Factories\SurveyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereWillFinishIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereWillStartIn($value)
 * @property string|null $campaign_id
 * @property AsCollection|null $tags
 * @property string|null $survey_type
 * @property AsCollection $questions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Campaign|null $campaign
 * @property-read \App\Models\SurveyType|null $surveyType
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereSurveyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereTags($value)
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property bool|null $limit_to_1_answer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyAnswer> $answers
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereLimitTo1Answer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Survey whereStartedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyAnswer> $answers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurveyAnswer> $answers
 * @mixin \Eloquent
 */
class Survey extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
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

    protected $casts = [
        'active' => 'boolean',
        'published' => 'boolean',
        'will_start_in' => 'datetime',
        'will_finish_in' => 'datetime',
        'tags' => AsCollection::class,
        'questions' => AsCollection::class,
        'started_at' => 'datetime',
        'limit_to_1_answer' => 'boolean',
    ];

    protected $dates = [
        'will_start_in',
        'will_finish_in',
        'started_at',
    ];

    /**
     * Get the project that owns the Survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the campaign that owns the Survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the surveyType that owns the Survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function surveyType(): BelongsTo
    {
        return $this->belongsTo(SurveyType::class, 'survey_type', 'id');
    }

    /**
     * Get the creator that owns the Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get all of the answers for the Survey
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(SurveyAnswer::class);
    }
}

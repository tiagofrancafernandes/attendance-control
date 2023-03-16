<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\SurveyType
 *
 * @property string $id
 * @property string $title
 * @property string|null $initial_template
 * @property string|null $project_id
 * @property bool $is_global
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project|null $project
 * @method static \Database\Factories\SurveyTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereInitialTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereIsGlobal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurveyType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SurveyType extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'title',
        'initial_template', // json_file:schema_01.json | php_config:schema_01.php | json:{...}
        'project_id',
        'is_global',
        'active',
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'active' => 'boolean',
    ];

    /**
     * Get the project that owns the SurveyType
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

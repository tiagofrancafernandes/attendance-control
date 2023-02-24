<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

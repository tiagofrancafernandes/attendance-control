<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'project_id',
        'tags',
        'active',
    ];

    protected $casts = [
        'tags' => AsCollection::class,
        'active' => 'boolean',
    ];

    /**
     * Get the project that owns the Survey
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

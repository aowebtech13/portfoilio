<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'category',
        'client',
        'start_date',
        'designer',
        'overview',
        'background_content',
        'hero_image',
        'slug',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class);
    }

    protected static function booted()
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function (Project $project) {
            if (empty($project->slug) || $project->isDirty('title')) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}

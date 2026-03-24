<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
     protected $fillable = [
        'title',
        'job_description',
        'job_requirements',
        'location',
        'category',
        'deadline',
        'job_type',
        'job_poster_id',
    ];

    // Link to the company (job poster)
    public function poster(): BelongsTo
    {
        return $this->belongsTo(JobPoster::class, 'job_poster_id');
    }



public function applications(): HasMany
{
    return $this->hasMany(Application::class);
}

}

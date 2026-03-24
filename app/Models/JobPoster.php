<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPoster extends Model
{
     protected $fillable = [
        'user_id',
        'industry',
        'location',
        'website',
        'about',
    ];

    // Link back to the user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

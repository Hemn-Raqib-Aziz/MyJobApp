<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobSeeker extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'sex',
        'location',
        'skills',
        'bio',
        'email_notifications'
    ];

    // Link back to the user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


public function applications(): HasMany
{
    return $this->hasMany(Application::class);
}

}

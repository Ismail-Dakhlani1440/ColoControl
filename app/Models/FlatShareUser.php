<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlatShareUser extends Pivot
{
    protected $table = 'flat_share_user';
    
    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flatShare(): BelongsTo
    {
        return $this->belongsTo(FlatShare::class);
    }

    public function isActive(): bool
    {
        return $this->left_at === null;
    }
}

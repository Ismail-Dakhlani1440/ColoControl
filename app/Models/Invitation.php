<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['flat_share_id', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function flatShare(): BelongsTo
    {
        return $this->belongsTo(FlatShare::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function markAsExpired(): bool
    {
        $this->status = 'expired';
        return $this->save();
    }
}

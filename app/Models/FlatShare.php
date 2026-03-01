<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlatShare extends Model
{
     protected $fillable = [
        'name', 'max_flatmate', 'token', 'status', 'owner_id'
    ];

    protected $casts = [
        'max_flatmate' => 'integer',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'flat_share_user')
                    ->withPivot('joined_at', 'left_at')
                    ->withTimestamps()
                    ->using(FlatShareUser::class);
    }

    public function activeUsers(): BelongsToMany
    {
        return $this->users()->wherePivotNull('left_at');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Categorie::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }
    
    public function pendingInvitations(): HasMany
    {
        return $this->hasMany(Invitation::class)->where('status', 'pending');
    }

    public function hasAvailableSpace(): bool
    {
        return $this->activeUsers()->count() < $this->max_flatmate;
    }

    public function createInvitation(): Invitation
    {
        return $this->pendingInvitations()->first()
            ?? $this->invitations()->create(['status' => 'pending']);
    }
}

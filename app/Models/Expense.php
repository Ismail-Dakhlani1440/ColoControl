<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    protected $fillable = [
        'title', 'description', 'ammount', 'date',
        'creator_id', 'payer_id', 'flat_share_id', 'category_id'
    ];

    protected $casts = [
        'date' => 'date',
        'ammount' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }   

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function flatShare(): BelongsTo
    {
        return $this->belongsTo(FlatShare::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'payments')
                    ->withPivot('payed')
                    ->withTimestamps()
                    ->using(Payment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'expense_id')->from('payments');
    }

     public function getSplitAmount(): float
    {
        $activeUsers = $this->flatShare->activeUsers()->count();
        return $activeUsers > 0 ? round($this->ammount / $activeUsers, 2) : 0;
    }

    public function getDebtors()
    {
        return $this->users()
                    ->wherePivot('payed', false)
                    ->where('user_id', '!=', $this->payer_id)
                    ->get();
    }

    public function getSettledUsers()
    {
        return $this->users()
                    ->wherePivot('payed', true)
                    ->where('user_id', '!=', $this->payer_id)
                    ->get();
    }

    public function isSettled(): bool
    {
        $totalUsers = $this->flatShare->activeUsers()->count();
        $paidCount = $this->users()->wherePivot('payed', true)->count();
        return $paidCount === $totalUsers;
    }

    public function getOwedAmount(): float
    {
        $unpaidCount = $this->debtors->count();
        return round($this->split_amount * $unpaidCount, 2);
    }

    public function initializePayments(): void
    {
        $activeUsers = $this->flatShare->activeUsers()->get();
        
        foreach ($activeUsers as $user) {
            if (!$this->users()->where('user_id', $user->id)->exists()) {
                $this->users()->attach($user->id, [
                    'payed' => ($user->id == $this->payer_id),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
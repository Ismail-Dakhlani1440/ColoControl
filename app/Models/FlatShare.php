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

    public function getDebtBetween(User $debtor, User $creditor): float
    {
        $expenses = $this->expenses()->with('payments')->get();

        $totalOwed = 0;

        foreach ($expenses as $expense) {
            $creditorPaidThisExpense = $expense->payer_id == $creditor->id;

            if (!$creditorPaidThisExpense) continue;

            $debtorPayment = $expense->payments->firstWhere('user_id', $debtor->id);

            $debtorHasNotPaidBack = $debtorPayment && !$debtorPayment->payed;

            if ($debtorHasNotPaidBack) {
                $totalOwed += $expense->getSplitAmount();
            }
        }

        return round($totalOwed, 2);
    }

    public function getNetDebtBetween(User $memberA, User $memberB): ?array
    {
        $aOwesB = $this->getDebtBetween($memberA, $memberB);
        $bOwesA = $this->getDebtBetween($memberB, $memberA);
        $net    = $aOwesB - $bOwesA;

        if ($net > 0.01)  return ['from' => $memberA, 'to' => $memberB, 'amount' => round($net, 2)];
        if ($net < -0.01) return ['from' => $memberB, 'to' => $memberA, 'amount' => round(abs($net), 2)];

        return null;
    }

    public function getNetDebts(): array
    {
        $members = $this->activeUsers()->get();

        $pairs = $members->crossJoin($members)
            ->filter(fn($pair) => $pair[0]->id < $pair[1]->id)
            ->values();

        return $pairs
            ->map(fn($pair) => $this->getNetDebtBetween($pair[0], $pair[1]))
            ->filter()
            ->values()
            ->toArray();
    }

    public function createInvitation(): Invitation
    {
        return $this->pendingInvitations()->first()
            ?? $this->invitations()->create(['status' => 'pending']);
    }
}

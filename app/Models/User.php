<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_banned',
        'reputation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'reputation' => 'integer',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function flatShares(): BelongsToMany
    {
        return $this->belongsToMany(FlatShare::class, 'flat_share_user')
                    ->withPivot('joined_at', 'left_at')
                    ->withTimestamps()
                    ->using(FlatShareUser::class);
    }

    public function activeFlatShare(): BelongsToMany
    {
        return $this->flatShares()->wherePivotNull('left_at')->where('status', 'active');
    }

    public function ownedFlatShares(): HasMany
    {
        return $this->hasMany(FlatShare::class, 'owner_id');
    }

    public function createdExpenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'creator_id');
    }

    public function paidExpenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'payer_id');
    }

    public function expenses(): BelongsToMany
    {
        return $this->belongsToMany(Expense::class, 'payments')
                    ->withPivot('payed')
                    ->withTimestamps()
                    ->using(Payment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role?->title === 'admin';
    }

    public function amountOwedInFlatShare(FlatShare $flatShare): float
    {
        $expensesPaidByMe = $flatShare->expenses()
            ->with('payments')
            ->where('payer_id', $this->id)
            ->get();

        $totalOwed = 0;

        foreach ($expensesPaidByMe as $expense) {
            $splitAmount = $expense->getSplitAmount() ?? 0;

            $unsettledMembers = $expense->payments
                ->where('user_id', '!=', $this->id)
                ->where('payed', false)
                ->count();

            $totalOwed += $splitAmount * $unsettledMembers;
        }

        return $totalOwed;
    }

    public function amountOwingInFlatShare(FlatShare $flatShare): float
    {
        $expensesPaidByOthers = $flatShare->expenses()
            ->with('payments')
            ->where('payer_id', '!=', $this->id)
            ->get();

        $totalOwing = 0;

        foreach ($expensesPaidByOthers as $expense) {
            $myPayment = $expense->payments->firstWhere('user_id', $this->id);

            $iHaveNotPaidBack = $myPayment && !$myPayment->payed;

            if ($iHaveNotPaidBack) {
                $totalOwing += $expense->getSplitAmount() ?? 0;
            }
        }

        return $totalOwing;
    }

    public function balanceInFlatShare(FlatShare $flatShare): float
    {
        $owed  = $this->amountOwedInFlatShare($flatShare) ?? 0;
        $owing = $this->amountOwingInFlatShare($flatShare) ?? 0;

        return $owed - $owing;
    }

}

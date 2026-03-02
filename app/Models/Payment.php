<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Pivot
{
    protected $table = 'payments';

    protected $fillable = ['user_id', 'expense_id', 'payed'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function isSettled(): bool
    {
        return $this->payed;
    }

    public function getAmount(): float
    {
        return $this->expense->split_amount;
    }

    public function getRecipient(): User
    {
        return $this->expense->payer;
    }
}
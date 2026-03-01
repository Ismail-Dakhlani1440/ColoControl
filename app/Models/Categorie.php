<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    protected $fillable = ['title', 'color', 'flat_share_id'];

    public function flatShare(): BelongsTo
    {
        return $this->belongsTo(FlatShare::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'category_id');
    }
}
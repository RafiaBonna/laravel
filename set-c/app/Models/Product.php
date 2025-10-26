<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'category_id'];

    // সাধারণ রিলেশনশিপ: একটি Product একটি Category-এর অন্তর্ভুক্ত
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // সাধারণ রিলেশনশিপ: একটি Product-এর একাধিক Order থাকতে পারে
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
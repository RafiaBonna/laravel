<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Category extends Model
{
    protected $fillable = ['name'];

    // সাধারণ রিলেশনশিপ: একটি Category-এর একাধিক Product থাকে
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Has One Through Relationship
     * একটি Category-এর মাধ্যমে Product মডেলের একটি Order পাওয়া।
     */
    public function firstOrder(): HasOneThrough
    {
        return $this->hasOneThrough(
            Order::class,    // Final Model: Order
            Product::class   // Intermediate Model: Product
        );
    }
}
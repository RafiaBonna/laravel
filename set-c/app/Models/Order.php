<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = ['name', 'product_id'];

    // সাধারণ রিলেশনশিপ: একটি Order একটি Product-এর অন্তর্ভুক্ত
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
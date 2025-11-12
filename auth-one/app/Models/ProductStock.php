<?php

// app/Models/ProductStock.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_no',
        'expiry_date',
        'available_quantity',
    ];

    /**
     * এই স্টকটি কোন প্রোডাক্টের।
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

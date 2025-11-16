<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReceiveItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_receive_id',
        'product_id',
        'batch_no',
        'production_date',
        'expiry_date',
        'received_quantity',
        'cost_rate',
    ];

    // ✅ Casts: নিশ্চিত float type
    protected $casts = [
        'received_quantity' => 'float',
        'cost_rate' => 'float',
    ];

    public function receive(): BelongsTo
    {
        return $this->belongsTo(ProductReceive::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

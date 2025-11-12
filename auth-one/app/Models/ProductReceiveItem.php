<?php

// app/Models/ProductReceiveItem.php

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

    /**
     * এই আইটেমটি কোন প্রোডাক্ট রিসিভের অংশ।
     */
    public function receive(): BelongsTo
    {
        return $this->belongsTo(ProductReceive::class);
    }

    /**
     * এই আইটেমটি কোন প্রোডাক্ট।
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReceiveItem extends Model
{
    protected $fillable = [
        'product_receive_id',
        'product_id',
        'batch_no',
        'production_date',
        'expiry_date',
        'received_quantity',
        'cost_rate',
        'total_item_cost'
    ];

    public function receive()
    {
        return $this->belongsTo(ProductReceive::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

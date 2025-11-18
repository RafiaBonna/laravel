<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReceive extends Model
{
    protected $fillable = [
        'receive_no',
        'receive_date',
        'note',
        'total_received_qty',
        'received_by_user_id',
        'total_cost'
    ];

    public function items()
    {
        return $this->hasMany(ProductReceiveItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }
}


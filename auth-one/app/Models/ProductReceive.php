<?php

// app/Models/ProductReceive.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'receive_no',
        'receive_date',
        'note',
        'total_received_qty',
        'received_by_user_id',
    ];

    /**
     * এই রিসিভে যোগ হওয়া সমস্ত আইটেম।
     */
    public function items(): HasMany
    {
        return $this->hasMany(ProductReceiveItem::class);
    }

    /**
     * যিনি এই রিসিভটি সম্পন্ন করেছেন।
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }
}

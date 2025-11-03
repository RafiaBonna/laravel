<?php
// app/Models/StockMovement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'raw_material_id',
        'type',
        'quantity',
        'reference_type',
        'reference_id',
        'user_id',
    ];
    
    // Raw Material এর সাথে সম্পর্ক
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }
    
    // Polymorphic Relationship: এটি দেখাবে মুভমেন্টটি কোন সোর্স থেকে এসেছে (Receiving, Consumption)
    public function reference()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
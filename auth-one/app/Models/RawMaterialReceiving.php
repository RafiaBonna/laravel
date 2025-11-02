<?php
// app/Models/RawMaterialReceiving.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialReceiving extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'supplier_id',
        'raw_material_id',
        'quantity',
        'unit_cost',
        'receiving_date',
        'user_id',
    ];
    
    // Raw Material এর সাথে সম্পর্ক
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }
    
    // Supplier এর সাথে সম্পর্ক
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // User এর সাথে সম্পর্ক (যিনি রিসিভ করছেন)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Polymorphic Relationship: StockMovement টেবিলের সাথে সম্পর্ক (IN মুভমেন্টের উৎস হিসেবে)
    public function stockMovement()
    {
        return $this->morphOne(StockMovement::class, 'reference');
    }
}
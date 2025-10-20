<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_material_id', // RawMaterial Master
        'supplier_id',     // Supplier Master
        'received_quantity',
        'unit',
        'unit_price',
        'received_date',
    ];

    // RawMaterial related with Master 
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    // Supplier related with Master 
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
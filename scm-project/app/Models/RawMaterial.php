<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $table = 'raw_materials';

    protected $fillable = [
        'name',
        'unit',
        'current_stock', // ✅ RE-ADDED
        'alert_stock',
    ];

    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'raw_material_id');
    }
}
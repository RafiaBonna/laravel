<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_material_id',
        'issued_by_user_id',
        'issued_quantity',
        'unit',
        'purpose',
        'issue_date',
    ];

    /**
     * Get the raw material that was issued.
     */
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }

    /**
     * Get the user/recipient who issued the stock.
     */
    public function issuer()
    {
        // Assuming your user model is named 'User'
        return $this->belongsTo(\App\Models\User::class, 'issued_by_user_id'); 
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'manager_name',
    ];

    /**
     * Get the stock outs for the depot.
     */
    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
}
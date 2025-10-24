<?php

// app/Models/StockOut.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_material_id', 
        'depot_id', 
        'issued_quantity',
        'unit',
        'cost_price',
        'issued_date',
    ];

    // RawMaterial (Master) এর সাথে সম্পর্ক
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    // Depot/Destination এর সাথে সম্পর্ক (যদি থাকে)
    public function depot()
    {
        return $this->belongsTo(Depot::class); // Depot Model/Table নাম ব্যবহার করা হলো
    }
}
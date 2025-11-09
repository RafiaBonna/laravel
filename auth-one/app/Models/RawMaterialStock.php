<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_material_id', 'batch_number', 'stock_quantity', 
        'average_purchase_price', 'last_in_date'
    ];
    
    // DB::raw ব্যবহার করার জন্য এটি দরকার
    protected $guarded = []; 

    public function rawMaterial() { return $this->belongsTo(RawMaterial::class); }
}
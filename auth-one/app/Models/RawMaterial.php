<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_of_measure',
        'description', // ✅ নিশ্চিত করা হলো
    ];
    
    public function purchaseItems()
    {
        return $this->hasMany(RawMaterialPurchaseItem::class);
    }
}
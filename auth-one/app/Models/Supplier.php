<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact_name',
        'contact_email',
        // অন্যান্য কলাম যেমন address, phone ইত্যাদি থাকলে এখানে যুক্ত হবে
    ];
    
    // Supplier-এর সাথে raw_material_receivings বা purchase_orders এর Relationship এখানে যুক্ত হবে
}
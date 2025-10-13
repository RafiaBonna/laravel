<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = ['name', 'brand', 'value'];

    /**
     * One-to-One relation with CategoryDetail
     * or one category there will be only one details
     */
    public function detail()
    {
        return $this->hasOne(CategoryDetail::class);
    }
}

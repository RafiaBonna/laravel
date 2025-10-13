<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'description'];

    // Relation: CategoryDetail -> Category (belongsTo)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

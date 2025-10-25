<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * একটি ছাত্রের সাথে সম্পর্কিত Subject গুলো Fetch করুন (Many-to-Many).
     */
    public function subjects(): BelongsToMany
    {
        
        return $this->belongsToMany(Subject::class); 
    }
}
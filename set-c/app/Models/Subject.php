<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * একটি Subject-এর সাথে সম্পর্কিত Student-দের Fetch করুন (Many-to-Many).
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
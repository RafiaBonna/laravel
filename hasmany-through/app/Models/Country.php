<?php

// app/Models/Country.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    protected $fillable = ['name']; // <-- ADDED

    /**
     * Get all of the posts for the country (through users).
     */
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            User::class,
            'country_id',
            'user_id',
            'id',
            'id'
        );
    }
}
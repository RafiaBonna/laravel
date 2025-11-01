<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the users that belong to this role.
     * * @return HasMany
     */
    public function users(): HasMany
    {
        // একটি Role এর অধীনে একাধিক User থাকতে পারে (One-to-Many relationship)
        // এটি 'users' টেবিলের 'role_id' কলামকে রেফার করবে।
        return $this->hasMany(User::class);
    }
}
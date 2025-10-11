<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        // 'remember_token' bad dewa holo
    ];

    protected function casts(): array
    {
        return [
            // 'email_verified_at' bad dewa holo
            'password' => 'hashed',
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; // <-- ✅ নতুন আমদানি

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',    // <-- আপনার যোগ করা
        'status',  // <-- আপনার যোগ করা
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // =========================================================
    // ✅ NEW: RELATIONSHIPS FOR DEPO AND DISTRIBUTOR TABLES
    // =========================================================

    /**
     * Get the Depo record associated with the user (if role is 'depo').
     */
    public function depo(): HasOne
    {
        // One user (Depo role) has one Depo record
        return $this->hasOne(Depo::class);
    }
    
    /**
     * Get the Distributor record associated with the user (if role is 'distributor').
     */
    public function distributor(): HasOne
    {
        // One user (Distributor role) has one Distributor record
        return $this->hasOne(Distributor::class);
    }
}
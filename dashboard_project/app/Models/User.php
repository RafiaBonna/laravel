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
        'role', // role fillable করা হলো
    ];

    protected $hidden = [
        'password',
        // 'remember_token' বাদ দেওয়া হলো
    ];

    protected function casts(): array
    {
        return [
            // 'email_verified_at' বাদ দেওয়া হলো
            'password' => 'hashed',
        ];
    }
    
    /**
     * লগইন করার পরে ইউজারকে তার রোল অনুযায়ী ড্যাশবোর্ডের রুটে পাঠাবে।
     */
    public function getDashboardRoute()
    {
        // নিশ্চিত করুন web.php-এ এই route name গুলি আছে
        switch ($this->role) {
            case 'admin':
                return route('admin.dashboard'); 
            case 'distributor':
                return route('distributor.dashboard');
            case 'depo':
                return route('depo.dashboard');
            default:
                return '/'; 
        }
    }
}

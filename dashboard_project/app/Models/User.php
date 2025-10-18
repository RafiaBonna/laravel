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
        'role', // <--- এই লাইনটি যোগ করা হয়েছে
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

    // --- রোল-ভিত্তিক ড্যাশবোর্ড রুট ফাংশন যোগ করা হলো ---
    public function getDashboardRoute()
    {
        switch ($this->role) {
            case 'admin':
                // পরবর্তীতে এই route গুলো routes/web.php এ সেট করব
                return route('admin.dashboard'); 
            case 'distributor':
                return route('distributor.dashboard');
            case 'depo':
                return route('depo.dashboard');
            default:
                return '/'; // যদি রোল না থাকে তবে হোমপেজ
        }
    }
    // ----------------------------------------------------
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id', // Foreign key to the users table
    ];

    /**
     * Get the user that owns the Post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo for type-hinting

class Shipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * CRITICAL FIX: Added necessary fields for mass assignment to resolve QueryException.
     */
    protected $fillable = [
        'shipment_date',
        'raw_material_id',
        'source_depo_id',
        'destination_depo_id',
        'quantity',
        'user_id', // The user (Superadmin) who created the shipment
        'status', // e.g., 'pending', 'transferred', 'received'
        'depo_id', // <--- NEW FIX: Added to resolve 'Field depo_id doesn't have a default value' error
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'shipment_date' => 'date',
    ];

    /**
     * Define relationship with RawMaterial.
     */
    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }

    /**
     * Define relationship with the source Depo.
     */
    public function sourceDepo()
    {
        return $this->belongsTo(Depo::class, 'source_depo_id');
    }

    /**
     * Define relationship with the destination Depo.
     */
    public function destinationDepo()
    {
        return $this->belongsTo(Depo::class, 'destination_depo_id');
    }

    /**
     * Define relationship with the User (Superadmin who created it).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define relationship with the primary Depo associated via 'depo_id'.
     * This fixes the RelationNotFoundException.
     */
    public function depo(): BelongsTo // ✅ ADDED THIS RELATIONSHIP
    {
        return $this->belongsTo(Depo::class, 'depo_id');
    }
}
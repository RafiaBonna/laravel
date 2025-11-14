<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;

    // ১. Fillable properties: এই কলামগুলো ফর্ম থেকে ডেটা ইনপুট নেবে
    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'total_amount',
        'user_id', // Super Admin যিনি তৈরি করছেন
        'depo_id', 
        'status', // Pending, Approved, Canceled
        'approved_by', // Depo User ID
        'approved_at',
        'cancellation_reason',
    ];

    // ২. Items (ইনভয়েসে একাধিক আইটেম থাকে)
    public function items()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }

    // ৩. Depo (কার কাছে বিক্রি হলো)
    public function depo()
    {
        return $this->belongsTo(Depo::class); // Depo মডেল আপনার থাকতে হবে
    }

    // ৪. Creator (কে তৈরি করল - Super Admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ৫. Approver (কে অনুমোদন করল - Depo-এর ইউজার)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceItem extends Model
{
    use HasFactory;

    // ১. Fillable properties
    protected $fillable = [
        'sales_invoice_id',
        'product_id',
        'product_stock_id', 
        'quantity',
        'unit_price',
        'sub_total',
    ];

    // ২. Invoice (কোন ইনভয়েসের অংশ)
    public function invoice()
    {
        return $this->belongsTo(SalesInvoice::class);
    }

    // ৩. Product (কোন পণ্য বিক্রি হলো)
    public function product()
    {
        return $this->belongsTo(Product::class); // Product মডেল আপনার থাকতে হবে
    }

    // ৪. Stock (কোন স্টক/ব্যাচ থেকে বিক্রি হলো)
    public function stock()
    {
        // ধরে নিলাম আপনার ProductStock নামে একটি মডেল আছে
        return $this->belongsTo(ProductStock::class, 'product_stock_id'); 
    }
}
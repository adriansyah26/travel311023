<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'customer_id', 'product', 'item', 'description', 'quantity', 'amount', 'markup', 'total', 'status',
    ];

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();

        if ($lastInvoice) {
            $lastInvoiceNumber = intval($lastInvoice->invoice_number);
            $newInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            $newInvoiceNumber = 1;
        }
        $romawi = [
            1 => '/I', '/II', '/III', '/IV', '/V', '/VI', '/VII', '/VIII', '/IX', '/X', '/XI', '/XII'
        ];

        return str_pad($newInvoiceNumber, 2, '0', STR_PAD_LEFT) . $romawi[now()->format('n')] . '/KSP/' . now()->format('Y');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->invoice_number = self::generateInvoiceNumber();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

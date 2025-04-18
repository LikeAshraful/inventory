<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'paid_amount',
        'due_amount',
        'previous_due_amount',
        'payment_date',
        'discount',
        'note',
        'created_by',
    ];

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function payment_details()
    {
        return $this->hasMany(PaymentDetail::class, 'payment_id');
    }
}

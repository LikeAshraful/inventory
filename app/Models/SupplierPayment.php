<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SupplierPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'supplier_id',
        'paid_amount',
        'due_amount',
        'previous_due_amount',
        'payment_date',
        'discount',
        'note',
        'created_by',
    ];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function customerPayment_details()
    {
        return $this->hasMany(CustomerPaymentDetail::class, 'customer_payment_id');
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}

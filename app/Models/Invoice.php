<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id', 'id');
    }

    public function invoice_details()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }

    public function sale_returns()
    {
        return $this->hasMany(SaleReturn::class, 'invoice_id', 'id');
    }

    public function payment_details()
	{
		return $this->hasManyThrough(
			PaymentDetail::class,
			Payment::class,
			'invoice_id',      // Foreign key on the payments table
			'payment_id',      // Foreign key on the payment_details table
			'id',              // Local key on the invoices table
			'id'               // Local key on the payments table
		);
	}

    public function customer()
	{
		return $this->belongsTo(Customer::class, 'customer_id', 'id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id');
	}


}

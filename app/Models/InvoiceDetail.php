<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
	
	public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
	
	public function sale_returns()
    {
        return $this->belongsTo(SaleReturn::class, 'sale_return_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
	
	public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
	
	public function getDiscountAttribute()
	{
		$flatDiscount = $this->invoice->flat_discount;
		$percentageDiscount = $this->invoice->percentage_discount;
		$totalAmount = $this->invoice->total_amount;

		return $flatDiscount > 0 
			   ? $flatDiscount 
			   : ($totalAmount * $percentageDiscount / 100);
	}

}

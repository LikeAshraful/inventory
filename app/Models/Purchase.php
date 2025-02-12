<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
	protected $guarded = [];
	
	public function details(){
        return $this->hasMany(PurchaseDetail::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
	
	public function purchaseDetails()
	{
		return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
	}


}

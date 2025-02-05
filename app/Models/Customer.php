<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }

	public function invoice()
	{
		return $this->hasMany(Invoice::class, 'customer_id');
	}


}


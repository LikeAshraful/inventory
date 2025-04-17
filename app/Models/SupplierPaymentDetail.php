<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPaymentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_payment_id',
        'paid_amount',
        'transaction_type',
    ];
}

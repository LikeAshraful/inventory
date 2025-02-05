<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('name','supplier_id','unit_id','category_id','product_code','buying_date','expire_date','buying_price','retail_sale','wholesale','product_image')->get();
    }
}
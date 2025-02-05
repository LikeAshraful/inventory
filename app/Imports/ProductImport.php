<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
        'name' => $row[0],
        'supplier_id' => $row[1],
        'unit_id' => $row[2],
        'category_id' => $row[3],
        'product_code' => $row[4],
        'buying_date' => $row[5],
        'expire_date' => $row[6],
        'buying_price' => $row[7],
        'retail_sale' => $row[8],
        'wholesale' => $row[9],
        'product_image' => $row[10], 
        ]);
    }
}
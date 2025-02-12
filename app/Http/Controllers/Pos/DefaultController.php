<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class DefaultController extends Controller {
    public function getProductDetails(Request $request) {
        $product = Product::where('id', $request->product_id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'product_id'   => $request->product_id,
            'name'         => $product->name,
            'product_code' => $product->product_code,
            'buying_price' => $product->buying_price,
            'retail_sale'  => $product->retail_sale,
            'wholesale'    => $product->wholesale,
        ]);
    }

    public function getCustomerDetails($customerId) {
        $customer = Customer::find($customerId);

        if (!$customer) {
            return response()->json([
                'previous_due_amount' => 0,
                'error'               => 'Customer not found',
            ], 200);
        }

        return response()->json([
            'previous_due_amount' => $customer->previous_due_amount,
            'customer_id'         => $customer->id,
            'name'                => $customer->name,
            'mobile_no'           => $customer->mobile_no,
        ]);
    }

// start of multiple customer fetch area

// public function getCustomerDetails(Request $request)

//{

// $customer_ids = $request->get('customer_ids');

// Ensure $customer_ids is an array

// if (!is_array($customer_ids)) {

//    $customer_ids = [$customer_ids];

//}

//if (empty($customer_ids)) {

//    return response()->json(['error' => 'No customers selected'], 400);

// }

// $customers = Customer::whereIn('id', $customer_ids)->get();

//if ($customers->isEmpty()) {

//    return response()->json(['error' => 'No customers found'], 404);

// }

// $response = $customers->map(function ($customer) {

// $total_due_amount = Payment::where('customer_id', $customer->id)->sum('due_amount');

// return [

//  'customer_id' => $customer->id,

//  'name' => $customer->name,

//  'previous_due_amount' => $total_due_amount,

//];

// });

//return response()->json(['customers' => $response]);

// }

    // end of multiple customer fetch area

    public function GetStock(Request $request) {
        $product_id = $request->product_id;
        $stock      = Product::where('id', $product_id)->first()->quantity;
        return response()->json($stock);

    }

    // End Mehtod

}

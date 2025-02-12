<?php

namespace App\Http\Controllers\Pos;

use DB;
use Auth;
use App\Models\Unit;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;

use App\Models\SaleReturn;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\PaymentDetail;
use App\Models\PurchaseDetail;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function PurchaseAll(){

        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.purchase.purchase_all',compact('allData'));

    } // End Method 
	
	public function PurchaseAdd(){
    $supplier = Supplier::all();
    $unit = Unit::all();
    $product = Product::all(); // Load all products
    return view('backend.purchase.purchase_add',compact('supplier','unit','product'));
	
	} // End Method
	

	public function PurchaseStore(Request $request)
	{
		DB::transaction(function() use($request) {
			// Create a new purchase entry
			$purchase = new Purchase();
			$purchase->date = $request->date;
			$purchase->purchase_no = $request->purchase_no;
			$purchase->supplier_id = $request->supplier_id;
			$purchase->transaction_type = $request->transaction_type;
			$purchase->discount_amount = $request->discount_amount ?? 0;
			$purchase->shipping = $request->shipping ?? 0;
			$purchase->estimated_amount = $request->estimated_amount;
			$purchase->paid_amount = $request->paid_amount ?? 0;
			$purchase->due_amount = $request->due_amount ?? 0;
			$purchase->status = '0'; // Assuming status '0' indicates incomplete or pending
			$purchase->created_by = Auth::user()->id;
			$purchase->save();

			// Insert purchase details and update product quantities
			foreach ($request->product_id as $key => $product_id) {
				// Retrieve the current product quantity
				$product = Product::findOrFail($product_id);
				
				// Update the product quantity
				$new_quantity = $product->quantity + $request->buying_qty[$key];
				$product->quantity = $new_quantity;
				$product->save();

				// Create a new purchase detail entry
				$purchaseDetail = new PurchaseDetail();
				$purchaseDetail->purchase_id = $purchase->id;
				$purchaseDetail->product_id = $product_id;
				$purchaseDetail->buying_qty = $request->buying_qty[$key];
				$purchaseDetail->expire_date = $request->expire_date[$key];
				$purchaseDetail->buying_price = $request->buying_price[$key];
				$purchaseDetail->retail_sale = $request->retail_sale[$key];
				$purchaseDetail->total_amount = $request->buying_qty[$key] * $request->buying_price[$key];
				$purchaseDetail->save();
			}
		});

		$notification = array(
			'message' => 'Purchase Added Successfully and Product Quantities Updated',
			'alert-type' => 'success'
		);

		return redirect()->route('purchase.all')->with($notification);
	} // End Method
	

	public function PurchaseEdit($id) {
        $purchase = Purchase::with('details')->findOrFail($id);
        $supplier = Supplier::all();
        $product = Product::all();
        return view('backend.purchase.purchase_edit', compact('purchase', 'supplier', 'product'));
    }

    public function PurchaseUpdate(Request $request, $id) {
        DB::transaction(function() use($request, $id) {
            $purchase = Purchase::findOrFail($id);
            $purchase->date = $request->date;
            $purchase->purchase_no = $request->purchase_no;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->transaction_type = $request->transaction_type;
            $purchase->discount_amount = $request->discount_amount ?? 0;
            $purchase->shipping = $request->shipping ?? 0;
            $purchase->estimated_amount = $request->estimated_amount;
            $purchase->paid_amount = $request->paid_amount ?? 0;
            $purchase->due_amount = $request->due_amount ?? 0;
            $purchase->status = '0';
            $purchase->updated_by = Auth::user()->id;
            $purchase->save();

            PurchaseDetail::where('purchase_id', $id)->delete();

            foreach ($request->product_id as $key => $product_id) {
                $purchaseDetail = new PurchaseDetail();
                $purchaseDetail->purchase_id = $purchase->id;
                $purchaseDetail->product_id = $product_id;
                $purchaseDetail->buying_qty = $request->buying_qty[$key];
                $purchaseDetail->expire_date = $request->expire_date[$key];
                $purchaseDetail->buying_price = $request->buying_price[$key];
                $purchaseDetail->retail_sale = $request->retail_sale[$key];
                $purchaseDetail->total_amount = $request->buying_qty[$key] * $request->buying_price[$key];
                $purchaseDetail->save();
            }
        });

        $notification = array(
            'message' => 'Purchase Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('purchase.all')->with($notification);
    }// End Method

	
	 public function PurchaseDelete($id){

	 	Purchase::findOrFail($id)->delete();

	 		$notification = array(
		'message' => 'Purchase Iteam Deleted Successfully', 
			'alert-type' => 'success'
	 	);
	 	return redirect()->back()->with($notification); 

	 } // End Method
	 
	 
	public function PrintPurchaseInvoice($id)
	{
		// Retrieve the purchase with supplier and details
		$purchase = Purchase::with('supplier', 'purchaseDetails.product')
			->findOrFail($id);

		// Check if the purchase exists
		if (!$purchase) {
			$notification = array(
				'message' => 'Purchase not found',
				'alert-type' => 'error'
			);
			return redirect()->route('purchase.all')->with($notification);
		}

		// Pass data to a view for generating the PDF or displaying the invoice
		return view('backend.pdf.print_purchase_invoice_pdf', compact('purchase'));
	}


 
	
	



 
	
	

}

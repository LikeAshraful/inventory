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
			// Retrieve the supplier
			$supplier = Supplier::findOrFail($request->supplier_id);

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

			// Add the due amount to the supplier's balance
			$supplier->balance += $purchase->due_amount;
			$supplier->save();

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
        $supplier = Supplier::findOrFail($purchase->supplier_id);

        // Revert the previous due amount
        $supplier->balance -= $purchase->due_amount;

        // Revert the old product quantities
        foreach ($purchase->details as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $product->quantity -= $detail->buying_qty; // Subtract old quantity
            $product->save();
        }

        // Update the purchase
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

        // Add the new due amount
        $supplier->balance += $purchase->due_amount;
        $supplier->save();

        // Delete old purchase details
        PurchaseDetail::where('purchase_id', $id)->delete();

        // Insert new purchase details and update product quantities
        foreach ($request->product_id as $key => $product_id) {
            $product = Product::findOrFail($product_id);

            // Add the new quantity
            $product->quantity += $request->buying_qty[$key];
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
			'message' => 'Purchase Updated Successfully',
			'alert-type' => 'success'
		);
		return redirect()->route('purchase.all')->with($notification);
	} // End Method

	public function PurchaseDelete($id) {
		DB::transaction(function() use($id) {
			$purchase = Purchase::findOrFail($id);
			$supplier = Supplier::findOrFail($purchase->supplier_id);

			// Revert the due amount
			$supplier->balance -= $purchase->due_amount;
			$supplier->save();
			
			// Revert the product quantities
        foreach ($purchase->details as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $product->quantity -= $detail->buying_qty; // Subtract the quantity
            $product->save();
        }

			// Delete the purchase
			$purchase->delete();
		});

		$notification = array(
			'message' => 'Purchase Item Deleted Successfully',
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
	}// End Method

	public function PurchaseInvoiceReport(){
		
        return view('backend.purchase.purchase_invoice_report');
    } // End Method
	
	public function PurchaseReportPdf(Request $request){

        $sdate = date('Y-m-d',strtotime($request->start_date));
        $edate = date('Y-m-d',strtotime($request->end_date));
       
		$allData = Purchase::with('purchaseDetails')->whereBetween('date', [$sdate,$edate])->get();
		
	// Calculate total_amount for each purchase
    foreach ($allData as $purchase) {
        $purchase->total_amount = $purchase->purchaseDetails->sum('total_amount');
    }

        $start_date = date('Y-m-d',strtotime($request->start_date));
        $end_date = date('Y-m-d',strtotime($request->end_date));
        return view('backend.pdf.purchase_report_pdf',compact('allData','start_date','end_date'));
    } // End Method	
	
	public function PurchaseProductReport(){
		
        return view('backend.purchase.purchase_product_report');
    } // End Method
	
	public function PurchaseProductPdf(Request $request)
	{
		$sdate = date('Y-m-d', strtotime($request->start_date));
		$edate = date('Y-m-d', strtotime($request->end_date));

		// Fetch purchases with their details
		$allData = Purchase::with(['purchaseDetails.product']) // Access product through purchaseDetails
							->whereBetween('date', [$sdate, $edate])
							->get();

		$start_date = date('Y-m-d', strtotime($request->start_date));
		$end_date = date('Y-m-d', strtotime($request->end_date));

		return view('backend.pdf.purchase_product_pdf', compact('allData', 'start_date', 'end_date'));
	}

}

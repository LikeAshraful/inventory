<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Auth;
use Illuminate\Support\Carbon;

class SupplierController extends Controller
{
    public function SupplierAll(){
		
		$suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all',compact('suppliers'));

    } // End Method
	
	public function SupplierAdd(){
     return view('backend.supplier.supplier_add');
    } // End Method
	
	public function SupplierStore(Request $request){

        Supplier::insert([
            'shopname' => $request->shopname,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'balance' => $request->balance,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Supplier Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);

    } // End Method
	
		public function SupplierEdit($id){

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit',compact('supplier'));

    } // End Method 

    public function SupplierUpdate(Request $request){

        $supplier_id = $request->id;

        Supplier::findOrFail($supplier_id)->update([
            'shopname' => $request->shopname,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'balance' => $request->balance,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Supplier Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);

    } // End Method
	
	public function SupplierDelete($id){

		Supplier::findOrFail($id)->delete();

		$notification = array(
            'message' => 'Supplier Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method
	
	public function SupplierInvoiceReport()
	{
		// Fetch all suppliers for the dropdown
		$suppliers = Supplier::all();
		return view('backend.supplier.supplier_invoice_report', compact('suppliers'));
	}
	
	public function SupplierReportPdf(Request $request)
	{
		$request->validate([
		'start_date' => 'required|date',
		'end_date' => 'required|date|after_or_equal:start_date',
		'supplier_id' => 'required|exists:suppliers,id', // Change 'supplier' to 'suppliers'
	]);

		// Format the dates
		$sdate = date('Y-m-d', strtotime($request->start_date));
		$edate = date('Y-m-d', strtotime($request->end_date));
		
		
		$allData = Purchase::with('purchaseDetails')
		->where('supplier_id', $request->supplier_id)
		->whereBetween('date', [$sdate,$edate])
		->get();
		
	// Calculate total_amount for each purchase
    foreach ($allData as $purchase) {
        $purchase->total_amount = $purchase->purchaseDetails->sum('total_amount');
		}
		// Pass data to the view
		$start_date = $sdate;
		$end_date = $edate;
		return view('backend.pdf.supplier_report_pdf', compact('allData', 'start_date', 'end_date'));
	}
	
	public function SupplierProductReport(){
		// Fetch all suppliers for the dropdown
		$suppliers = Supplier::all();
		return view('backend.supplier.supplier_product_report', compact('suppliers'));
    } // End Method
	
	public function SupplierProductPdf(Request $request)
	{
		$request->validate([
		'start_date' => 'required|date',
		'end_date' => 'required|date|after_or_equal:start_date',
		'supplier_id' => 'required|exists:suppliers,id', // Change 'supplier' to 'suppliers'
		]);

		// Format the dates
		$sdate = date('Y-m-d', strtotime($request->start_date));
		$edate = date('Y-m-d', strtotime($request->end_date));
		
		// Fetch the selected customer
		$supplier = Supplier::findOrFail($request->supplier_id);
		
		// Fetch purchases with their details
		$allData = Purchase::with(['purchaseDetails.product']) // Access product through purchaseDetails
							->where('supplier_id', $request->supplier_id)
							->whereBetween('date', [$sdate,$edate])
							->get();
		
		// Calculate total_amount for each purchase
		foreach ($allData as $purchase) {
			$purchase->total_amount = $purchase->purchaseDetails->sum('total_amount');
			}
			// Pass data to the view
			$start_date = $sdate;
			$end_date = $edate;
			return view('backend.pdf.supplier_product_pdf', compact('allData', 'start_date', 'end_date', 'supplier'));
	}
}

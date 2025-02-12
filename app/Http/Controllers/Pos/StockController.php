<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Damage;
use Auth;
use Illuminate\Support\Carbon;

class StockController extends Controller
{
    public function StockReport(){

        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();
        return view('backend.stock.stock_report',compact('allData'));

    } // End Method
	
	public function StockReportPdf(){

        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();
        return view('backend.pdf.stock_report_pdf',compact('allData'));

    } // End Method
	
	public function StockSupplierWise(){
		
        $supppliers = Supplier::all();
        $category = Category::all();
        return view('backend.stock.supplier_product_wise_report',compact('supppliers','category'));
		
    } // End Method
	
	public function SupplierWisePdf(Request $request){

        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->where('supplier_id',$request->supplier_id)->get();
        return view('backend.pdf.supplier_wise_report_pdf',compact('allData'));

    } // End Method
	
	public function ProductWisePdf(Request $request){

        $product = Product::where('category_id',$request->category_id)->where('id',$request->product_id)->first();
        return view('backend.pdf.product_wise_report_pdf',compact('product'));
    } // End Method

	
	
	public function GetCategory(Request $request){

        $supplier_id = $request->supplier_id;
        // dd($supplier_id);
        $allCategory = Product::with(['category'])->select('category_id')->where('supplier_id',$supplier_id)->groupBy('category_id')->get();
        return response()->json($allCategory);
    } // End Mehtod 
	
	public function GetProduct(Request $request){

        $category_id = $request->category_id; 
        $allProduct = Product::where('category_id',$category_id)->get();
        return response()->json($allProduct);
    } // End Mehtod 
	
	public function DamageAll()
	{
		$damages = Damage::with('product')->orderBy('date', 'desc')->get();
		return view('backend.stock.list_damage', compact('damages'));
	}

	
	public function DamageAdd()
    {
        $product = Product::all();
        return view('backend.stock.add_damage', compact('product'));
    }
	
	public function DamageStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_in' => 'nullable|integer|min:0',
            'product_out' => 'nullable|integer|min:0',
            'date' => 'required|date',
        ]);

        $damage = Damage::create([
            'product_id' => $request->product_id,
            'reasons' => $request->reasons,
            'product_in' => $request->product_in,
            'product_out' => $request->product_out,
            'date' => $request->date,
        ]);

        // Update product quantity
        $product = Product::find($request->product_id);
        $product->quantity += $request->product_in;
        $product->quantity -= $request->product_out;
        $product->save();

        $notification = array(
			'message' => 'Damage Added Successfully and Product Quantities Updated',
			'alert-type' => 'success'
		);

		return redirect()->route('damage.all')->with($notification);
	} // End Method
	
	public function editDamage($id)
	{
		$damage = Damage::findOrFail($id);
		$product = Product::all();
		return view('backend.stock.edit_damage', compact('damage', 'product'));
	}
	
	public function updateDamage(Request $request, $id)
	{
			$request->validate([
			'product_id' => 'required|exists:products,id',
			'product_in' => 'nullable|integer',
			'product_out' => 'nullable|integer',
			'date' => 'required|date',
		]);

		$damage = Damage::findOrFail($id);
		$product = Product::findOrFail($damage->product_id);

		// 🔹 Step 1: Reverse old damage entry effect
		if ($damage->product_id == $request->product_id) {
			// **Same product, just updating quantity**
			$product->quantity -= $damage->product_in; // Remove old `product_in`
			$product->quantity += $damage->product_out; // Remove old `product_out`
		} else {
			// **Different product selected, revert old & update new**
			$oldProduct = Product::findOrFail($damage->product_id);
			$oldProduct->quantity -= $damage->product_in;
			$oldProduct->quantity += $damage->product_out;
			$oldProduct->save();
			
			$product = Product::findOrFail($request->product_id);
		}

		// 🔹 Step 2: Update damage entry
		$damage->update([
			'product_id' => $request->product_id,
			'reasons' => $request->reasons,
			'product_in' => $request->product_in ?? 0,  // Handle null values
			'product_out' => $request->product_out ?? 0,
			'date' => $request->date,
		]);

		// 🔹 Step 3: Apply new values to product quantity
		$product->quantity += $request->product_in; // Add new `product_in`
		$product->quantity -= $request->product_out; // Subtract new `product_out`
		$product->save();

		$notification = array(
			'message' => 'Damage Update Successfully and Product Quantities Updated',
			'alert-type' => 'success'
		);

		return redirect()->route('damage.all')->with($notification);
	} // End Method
	
	public function DamageDelete($id)
	{
		$damage = Damage::findOrFail($id);
		$product = Product::find($damage->product_id); // Using `find()` to avoid crash

		if ($product) {
			// 🔹 Step 1: Adjust product quantity before deleting
			$product->quantity -= $damage->product_in; // Remove added stock
			$product->quantity += $damage->product_out; // Restore removed stock
			$product->save();
		}

		// 🔹 Step 2: Delete damage record
		$damage->delete();

		$notification = [
			'message' => 'Damage deleted successfully, and product quantities updated!',
			'alert-type' => 'success'
		];

		return redirect()->route('damage.all')->with($notification);
	} 




}
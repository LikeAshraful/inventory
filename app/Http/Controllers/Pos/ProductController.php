<?php
namespace App\Http\Controllers\Pos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;

class ProductController extends Controller
{
    public function ProductAll(){
        $product = Product::latest()->get();
        return view('backend.product.product_all',compact('product'));
    } // End Method 


    public function ProductAdd(){

        $supplier = Supplier::all();
        $category = Category::all();
        $unit = Unit::all();
        return view('backend.product.product_add',compact('supplier','category','unit'));
    } // End Method
	
	public function ProductStore(Request $request){
    

    // Check if image is uploaded
    if ($request->file('product_image')) {
        $image = $request->file('product_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/product/'.$name_gen);
        $save_url = 'upload/product/'.$name_gen;
    } else {
        // Set default dummy image
        $save_url = 'upload/no_image.jpg';
    }

    Product::insert([
        'name' => $request->name,
        'supplier_id' => $request->supplier_id,
        'unit_id' => $request->unit_id,
        'category_id' => $request->category_id,
        'quantity' => $request->quantity,
        'product_code' => $request->product_code,
        'buying_date' => $request->buying_date,
        'expire_date' => $request->expire_date,
        'buying_price' => $request->buying_price,
        'retail_sale' => $request->retail_sale,
        'wholesale' => $request->wholesale,
        'product_image' => $save_url,
        'created_by' => Auth::user()->id,
        'created_at' => Carbon::now(),
    ]);

    $notification = array(
        'message' => 'Product Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('product.all')->with($notification);
} // End Method

	
	public function ProductEdit($id){

        $supplier = Supplier::all();
        $category = Category::all();
        $unit = Unit::all();
        $product = Product::findOrFail($id);
        return view('backend.product.product_edit',compact('product','supplier','category','unit'));
    } // End Method 
	
	public function ProductUpdate(Request $request){
    $product_id = $request->id;

    if ($request->file('product_image')) {
        // Process the new image upload
        $image = $request->file('product_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/product/'.$name_gen);
        $save_url = 'upload/product/'.$name_gen;
    } else {
        // Retain the existing image
        $product = Product::findOrFail($product_id);
        $save_url = $product->product_image;
    }

    Product::findOrFail($product_id)->update([
        'name' => $request->name,
        'supplier_id' => $request->supplier_id,
        'unit_id' => $request->unit_id,
        'category_id' => $request->category_id,
		'quantity' => $request->quantity,
        'product_code' => $request->product_code,
        'buying_date' => $request->buying_date,
        'expire_date' => $request->expire_date,
        'buying_price' => $request->buying_price,
        'retail_sale' => $request->retail_sale,
        'wholesale' => $request->wholesale,
        'product_image' => $save_url,
        'updated_by' => Auth::user()->id,
        'updated_at' => Carbon::now(),
    ]);

    $notification = array(
        'message' => 'Product Updated Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('product.all')->with($notification);
} // End Method

	
	public function ProductDelete($id){

       Product::findOrFail($id)->delete();
            $notification = array(
            'message' => 'Product Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // End Method 
	
	public function BarcodeProduct($id){

        $product = Product::findOrFail($id);
        return view('backend.product.barcode_product',compact('product'));

    }// End Method 
	
	public function ImportProduct(){

        return view('backend.product.import_product');

    }// End Method 
	
	public function Export(){

        return Excel::download(new ProductExport,'products.xlsx');

    }// End Method 
	
	public function Import(Request $request){

        Excel::import(new ProductImport, $request->file('import_file'));

         $notification = array(
            'message' => 'Product Imported Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
    }// End Method 
	
	
}

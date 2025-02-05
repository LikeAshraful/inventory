<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Auth;
use Illuminate\Support\Carbon;
use Image;

class CustomerController extends Controller
{
    public function CustomerAll(){

        $customers = Customer::latest()->get();
        return view('backend.customer.customer_all',compact('customers'));

    } // End Method
	
	public function CustomerAdd(){
		
		return view('backend.customer.customer_add');
    }    // End Method
	
	
	public function CustomerStore(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:200',
            'email' => 'nullable|email|max:200|unique:customers',
            'mobile_no' => 'required|max:200',
            'address' => 'required|max:400',
            'shopname' => 'required|max:200',
              
        ]);
		
		// Check if an image is uploaded
        if ($request->file('customer_image')) {
            $image = $request->file('customer_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/customer/' . $name_gen);
            $save_url = 'upload/customer/' . $name_gen;
        } else {
            // Use a default image if none is uploaded
            $save_url = 'upload/no_image.jpg';
        }

        Customer::insert([

            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'shopname' => $request->shopname,
            'nid' => $request->nid,
            'note' => $request->note,
            'previous_due_amount' => $request->previous_due_amount,
            'customer_image' => $save_url,
			'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Customer Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);

    } // End Method
	
	
	public function CustomerEdit($id){

       $customer = Customer::findOrFail($id);
       return view('backend.customer.customer_edit',compact('customer'));

    } // End Method


    public function CustomerUpdate(Request $request, $id){

        $validateData = $request->validate([
            'name' => 'required|max:200',
			'email' => 'nullable|email|max:200|unique:customers,email,' . $id,
            'mobile_no' => 'required|max:200',
            'address' => 'required|max:400',
            'shopname' => 'required|max:200',
              
        ]);
		
		$customer = Customer::findOrFail($id);
		
		// Check if an image is uploaded
        if ($request->file('customer_image')) {
            $image = $request->file('customer_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/customer/' . $name_gen);
            $save_url = 'upload/customer/' . $name_gen;
        } else {
            // Use a default image if none is uploaded
            $save_url = 'upload/no_image.jpg';
        }
        
        $customer->update([
            'shopname' => $request->shopname,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'nid' => $request->nid,
            'note' => $request->note,
            'previous_due_amount' => $request->previous_due_amount,
			'customer_image' => $save_url,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

         $notification = array(
            'message' => 'Customer Updated  Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);

        }// End Method
		
		
	public function CustomerDelete($id){

        $customers = Customer::findOrFail($id);
        

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method
}

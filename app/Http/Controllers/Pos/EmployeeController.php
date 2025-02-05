<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Auth;
class EmployeeController extends Controller
{
    public function AllEmployee()
    {
        $employee = Employee::latest()->get();
        return view('backend.employee.all_employee', compact('employee'));
    } // End Method 

    public function AddEmployee()
    {
        return view('backend.employee.add_employee');
    } // End Method

    public function StoreEmployee(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:200',
			'email' => 'nullable|email|max:200|unique:employees',
            'phone' => 'required|max:200',
            'address' => 'required|max:400',
            'salary' => 'required|max:200',
        ]);

        // Check if an image is uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/employee/' . $name_gen);
            $save_url = 'upload/employee/' . $name_gen;
        } else {
            // Use a default image if none is uploaded
            $save_url = 'upload/no_image.jpg';
        }

        Employee::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'vacation' => $request->vacation,
            'image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Employee Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employee')->with($notification);
    } // End Method 
	
	public function EditEmployee($id){

        $employee = Employee::findOrFail($id);
        return view('backend.employee.edit_employee',compact('employee'));

    } // End Method
	
	public function UpdateEmployee(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required|max:200',
            'email' => 'nullable|email|max:200|unique:employees,email,' . $id,
            'phone' => 'required|max:200',
            'address' => 'nullable|max:400',
            'salary' => 'nullable|max:200',
            
        ]);

        $employee = Employee::findOrFail($id);

        // Check if an image is uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/employee/' . $name_gen);
            $save_url = 'upload/employee/' . $name_gen;
        } else {
            // Use existing image if none is uploaded
            $save_url = $employee->image;
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'vacation' => $request->vacation,
            'image' => $save_url,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employee')->with($notification);
    }// End Method
	
	public function DeleteEmployee($id){

        $employee_img = Employee::findOrFail($id);
        $img = $employee_img->image;
        

        Employee::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Employee Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // End Method
}


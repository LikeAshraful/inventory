public function AddCart(Request $request){

        Cart::add([
            'id' => $request->id, 
            'name' => $request->name,  
            'price' => $request->price, 
			'quantity' => $request->quantity,
            'attributes' => ['color' => 'Black'];


         $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
     ]);

        return redirect()->back()->with($notification);


    } // End Method 
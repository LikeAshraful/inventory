Conversation opened. 65 messages. All messages read.

Skip to content
Using Gmail with screen readers
1 of 238
pos
Inbox

Farjana Akter
AttachmentsNov 8, 2024, 10:56 PM
আসসালামু আলাইকুম স্যার। কেমন আছেন। আপনার দুইটা টিউটোরিয়াল আমি কিনেছি এবং আমি একটা পজ সফটওয়্যার ডেভেলপ করেছি।তো আমার এখন যে সমস্যা সেটা হচ্ছে আমার খুচরা বিক্রি
62

easy support
Dec 7, 2024, 3:08 PM (2 days ago)
Hi Farjana I do understand your issue. You didn't tell me this before. I didn't work for this. Ok don't worry i will check and help you to solve this. Thanks. -

easy support
Dec 8, 2024, 11:30 PM (1 hour ago)
to me

HI Farjana
Plz update this code in your invoice controller

public function RetailsaleStore(Request $request)
    {
        // dd($request->all());
       
        DB::beginTransaction();
   
        try {
            // Validate request data
            $request->validate([
                'product_id' => 'required|array',
                'type' => 'required|array',
                'product_code' => 'required|array',
                'product_name' => 'required|array',
                'quantity' => 'required|array',
                'price' => 'required|array',
                'total' => 'required|array',
                'customer_id' => 'required|array',
            ]);


            $customerIds = [];

            // Handle customers
            foreach ($request->customer_id as $customerId) {
                if ($customerId == 0) {
                    // Create a new customer
                    $customer = Customer::create([
                        'shopname' => $request->shopname,
                        'name' => $request->name,
                        'mobile_no' => $request->mobile_no,
                        'previous_due_amount' => $request->due_amount,
                        'email' => $request->email, // If you want to include additional fields
                        'address' => $request->address,
                    ]);
                    $customerIds[] = $customer->id;
                } else {
                    // Update existing customer's previous_due_amount
                    $customer = Customer::find($customerId);
                    if ($customer) {
                        $customer->update([
                            'previous_due_amount' => $request->due_amount,
                        ]);
                        $customerIds[] = $customer->id;
                    }
                }
            }


   
            // Step 1: Create Invoice
            $invoice = Invoice::create([
                'invoice_no' => $request->invoice_no,
                'date' => $request->date,
                'comment' => $request->comment,
                'total_amount' => $request->total_amount,
                'percentage_discount' => $request->percentage_discount,
                'flat_discount' => $request->flat_discount,
                'shipping' => $request->shipping,
                'labour' => $request->labour,
                'payable_amount' => $request->payable_amount,
                'status' => $request->status,
                'previous_due_amount' => $request->due_amount,
            ]);
   
            // Attach customers to the invoice
            $invoice->customer()->attach($customerIds);

            // Step 2: Create Invoice Details and Update Product Quantities
            foreach ($request->product_name as $key => $productName) {
                $productId = $request->product_id[$key] ?? null;
                $quantity = $request->quantity[$key] ?? 0;
                $type = $request->type[$key];

                // Create invoice detail
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $productId,
                    'product_code' => $request->product_code[$key] ?? '',
                    'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                    'type' => $type,
                    'quantity' => $quantity,
                    'price' => $request->price[$key],
                    'total' => $request->total[$key],
                ]);

                // Update product quantity in the products table
                if ($productId) {
                    $product = Product::find($productId);

                    if ($product) {
                        if ($type === 'sale') {
                            $product->decrement('quantity', $quantity);
                        } elseif ($type === 'return') {
                            $product->increment('quantity', $quantity);
                        }
                    }
                }
            }
   
            // Step 3: Create Payment
            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'previous_due_amount' => $request->previous_due_amount,
            ]);
   
            // Step 4: Create Payment Details
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'paid_amount' => $request->paid_amount,
                'transaction_type' => $request->transaction_type,
            ]);
   
            // Step 5: Create Sale Returns (if applicable)
            foreach ($request->type as $key => $type) {
                if ($type === 'return') {
                    SaleReturn::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $request->product_id[$key] ?? null,
                        'product_code' => $request->product_code[$key] ?? '',
                        'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                        'quantity' => $request->quantity[$key] ?? 0,
                        'price' => $request->price[$key] ?? 0.00,
                        'total' => $request->total[$key] ?? 0.00,
                    ]);
                }
            }
   
            DB::commit(); // Commit the transaction
   
    $notification = array(
                'message' => 'Sale and return processed successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('invoice.all')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

Then check and let me know. I will be in touch. Thanks.



---- On Sat, 07 Dec 2024 01:51:09 +0600 Farjana Akter <farjana.cse91@gmail.com> wrote ---

Done, please check.Updated.Ok, I will do it.

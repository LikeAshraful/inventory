<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\SaleReturn;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller {

    public function InvoiceAll() {
        $allData = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        return view('backend.invoice.invoice_all', compact('allData'));

    }

// End Method

    //For Retailsale functionality

    public function RetailsaleAdd() {
        $customer = Customer::all();
        $product  = Product::all();
        $employee = Employee::all();

        $invoice_data = Invoice::orderBy('id', 'desc')->first();

        if ($invoice_data == null) {
            $firstReg   = '0';
            $invoice_no = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $invoice_no   = $invoice_data + 1;
        }

        $date = date('Y-m-d');

        return view('backend.invoice.add_retail_sale', compact('customer', 'product', 'employee', 'invoice_no', 'date'));

    }

// End Method

    public function RetailsaleStore(Request $request) {

        DB::beginTransaction();

        try {
            $request->validate([
                'product_id'   => 'required|array',
                'type'         => 'required|array',
                'product_code' => 'required|array',
                'product_name' => 'required|array',
                'quantity'     => 'required|array',
                'price'        => 'required|array',
                'total'        => 'required|array',
                'customer_id'  => 'required|integer|min:0', // Allow 0 for new customer
            ]);

            if ($request->customer_id == 0) {
                // Create a new customer
                $customer = Customer::create([
                    'shopname'            => $request->shopname,
                    'name'                => $request->name,
                    'mobile_no'           => $request->mobile_no,
                    'previous_due_amount' => $request->due_amount,
                ]);
            } else {
                // Update existing customer
                $customer = Customer::find($request->customer_id);

                if ($customer) {
                    // Add new invoice due to the existing previous_due_amount
                    $newDueAmount = $customer->previous_due_amount + $request->due_amount;

                    $customer->update([
                        'previous_due_amount' => $newDueAmount, // Update with new total
                    ]);
                } else {
                    return response()->json(['error' => 'Customer not found'], 404);
                }

            }

            // Step 1: Create Invoice
            $invoice = Invoice::create([
                'invoice_no'          => $request->invoice_no,
                'sale_type'           => 'retail',
                'date'                => $request->date,
                'comment'             => $request->comment,
                'employee_id'         => $request->employee_id,
                'customer_id'         => $customer->id, // Use the customer ID directly
                'total_amount'        => $request->total_amount,
                'percentage_discount' => $request->percentage_discount,
                'flat_discount'       => $request->flat_discount,
                'shipping'            => $request->shipping,
                'labour'              => $request->labour,
                'payable_amount'      => $request->payable_amount,
                'status'              => $request->status,
                'previous_due_amount' => $customer->previous_due_amount, // Existing due from customer
                'due_amount'          => $request->due_amount, // New due from this invoice
                'created_by'          => Auth::user()->id,
            ]);

// Step 2: Create Invoice Details and Update Product Quantities
            foreach ($request->product_id as $key => $productId) {

                $quantity = $request->quantity[$key] ?? 0;
                $type     = strtolower($request->type[$key] ?? '');

                // Create invoice detail
                InvoiceDetail::create([
                    'invoice_id'   => $invoice->id,
                    'product_id'   => $productId,
                    'product_code' => $request->product_code[$key] ?? '',
                    'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                    'type'         => $type,
                    'quantity'     => $quantity,
                    'price'        => $request->price[$key],
                    'total'        => $request->total[$key],
                ]);

                if ($productId && $quantity > 0) {
                    // Validate productId এবং quantity
                    $product = Product::find($productId);

                    if ($product) {
                        Log::info('Before stock update', [
                            'product_id'      => $productId,
                            'current_stock'   => $product->quantity,
                            'type'            => $type,
                            'quantity_change' => $quantity,
                            'product_name'    => $product->name,
                        ]);

                        if ($type === 'sale') {
                            $product->decrement('quantity', $quantity);
                        } elseif ($type === 'return') {
                            $product->increment('quantity', $quantity);
                        }

                        Log::info('After stock update', [
                            'product_id'    => $productId,
                            'updated_stock' => $product->fresh()->quantity,
                            'product_name'  => $product->name,
                        ]);
                    }

                }

            }

            // Step 3: Create Payment
            $payment = Payment::create([
                'invoice_id'          => $invoice->id,
                'customer_id'         => $customer->id,
                'paid_amount'         => $request->paid_amount,
                'due_amount'          => $request->due_amount,
                'previous_due_amount' => $request->previous_due_amount,
            ]);

            // Step 4: Create Payment Details
            PaymentDetail::create([
                'payment_id'       => $payment->id,
                'paid_amount'      => $request->paid_amount,
                'transaction_type' => $request->transaction_type,
            ]);

// Step 5: Create Sale Returns (if applicable)
            foreach ($request->type as $key => $type) {
                if ($type === 'return') {
                    SaleReturn::create([
                        'invoice_id'   => $invoice->id,
                        'product_id'   => $request->product_id[$key] ?? null,
                        'product_code' => $request->product_code[$key] ?? '',
                        'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                        'quantity'     => $request->quantity[$key] ?? 0,
                        'price'        => $request->price[$key] ?? 0.00,
                        'total'        => $request->total[$key] ?? 0.00,
                    ]);
                }

            }

            DB::commit(); // Commit the transaction

            $notification = [
                'message'    => 'Sale and return processed successfully.',
                'alert-type' => 'success',
            ];
            return redirect()->route('print.invoice', ['id' => $invoice->id])->with($notification);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    // for Edit Invoice
    public function editInvoice($id) {
        try {
            // Fetch the invoice along with related data using eager loading
            $invoice = Invoice::with([
                'invoice_details', // Invoice details
                'customer', // Associated customer
                'payments', // Payments related to this invoice
                'payments.payment_details', // Payment details
                'sale_returns', // Sale returns
                'invoice_details.product', // Product details for each invoice item
            ])->findOrFail($id);

            // Fetch required dropdown data
            $customer = Customer::all(); // All customers for dropdown
            $product  = Product::all(); // All products for dropdown
            $employee = Employee::all();

            if ($invoice->sale_type === 'retail') {
                return view('backend.invoice.retail_invoice_edit', compact(
                    'invoice', 'customer', 'product', 'employee'
                ));
            } elseif ($invoice->sale_type === 'wholesale') {
                return view('backend.invoice.wholesale_invoice_edit', compact(
                    'invoice', 'customer', 'product', 'employee'
                ));
            } else {
                // If the sale_type is invalid, throw an exception
                abort(404, 'Invalid Sale Type');
            }

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error editing invoice: ' . $e->getMessage(), [
                'invoice_id' => $id,
            ]);

            // Return a JSON response with the error
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }

    }

    public function updateRetailSale(Request $request, $invoiceId) {
        DB::beginTransaction();

        try {
            $invoice     = Invoice::findOrFail($invoiceId);
            $originalDue = $invoice->due_amount;
            $customer    = $invoice->customer;

            $request->validate([
                'product_id'   => 'required|array',
                'type'         => 'required|array',
                'product_code' => 'required|array',
                'product_name' => 'required|array',
                'quantity'     => 'required|array',
                'price'        => 'required|array',
                'total'        => 'required|array',
                'customer_id'  => 'required|integer|min:0',
            ]);

            $newDue = $request->due_amount;
            $delta  = $newDue - $originalDue;
            $customer->previous_due_amount += $delta;
            $customer->save();

            // Revert product stock from original details
            $originalDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();

            foreach ($originalDetails as $detail) {
                $product = Product::find($detail->product_id);

                if ($product) {

                    if ($detail->type === 'sale') {
                        $product->increment('quantity', $detail->quantity);
                    } elseif ($detail->type === 'return') {
                        $product->decrement('quantity', $detail->quantity);
                    }

                }

            }

            // Delete old records
            InvoiceDetail::where('invoice_id', $invoice->id)->delete();
            SaleReturn::where('invoice_id', $invoice->id)->delete();

            // Update the invoice
            $invoice->update([
                'invoice_no'          => $request->invoice_no,
                'date'                => $request->date,
                'comment'             => $request->comment,
                'employee_id'         => $request->employee_id,
                'total_amount'        => $request->total_amount,
                'percentage_discount' => $request->percentage_discount,
                'flat_discount'       => $request->flat_discount,
                'shipping'            => $request->shipping,
                'labour'              => $request->labour,
                'payable_amount'      => $request->payable_amount,
                'status'              => $request->status,
                'due_amount'          => $newDue,
                // Include other fields as necessary
            ]);

            foreach ($request->product_id as $key => $productId) {
                $quantity = $request->quantity[$key] ?? 0;
                $type     = strtolower($request->type[$key] ?? '');

                InvoiceDetail::create([
                    'invoice_id'   => $invoice->id,
                    'product_id'   => $productId,
                    'product_code' => $request->product_code[$key] ?? '',
                    'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                    'type'         => $type,
                    'quantity'     => $quantity,
                    'price'        => $request->price[$key],
                    'total'        => $request->total[$key],
                ]);

                if ($productId && $quantity > 0) {
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

            // Update payment and details
            $payment = Payment::where('invoice_id', $invoice->id)->first();

            if ($payment) {
                $payment->update([
                    'paid_amount' => $request->paid_amount,
                    'due_amount'  => $newDue,
                ]);

                $paymentDetail = PaymentDetail::where('payment_id', $payment->id)->first();

                if ($paymentDetail) {
                    $paymentDetail->update([
                        'paid_amount'      => $request->paid_amount,
                        'transaction_type' => $request->transaction_type,
                    ]);
                } else {
                    PaymentDetail::create([
                        'payment_id'       => $payment->id,
                        'paid_amount'      => $request->paid_amount,
                        'transaction_type' => $request->transaction_type,
                    ]);
                }

            }

            foreach ($request->type as $key => $type) {
                if (strtolower($type) === 'return') {
                    SaleReturn::create([
                        'invoice_id'   => $invoice->id,
                        'product_id'   => $request->product_id[$key] ?? null,
                        'product_code' => $request->product_code[$key] ?? '',
                        'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                        'quantity'     => $request->quantity[$key] ?? 0,
                        'price'        => $request->price[$key] ?? 0.00,
                        'total'        => $request->total[$key] ?? 0.00,
                    ]);
                }
            }

            DB::commit();

            $notification = [
                'message'    => 'Sale updated successfully.',
                'alert-type' => 'success',
            ];
            return redirect()->route('print.invoice', ['id' => $invoice->id])->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    //For Wholesale functionality
    public function WholesaleAdd() {
        $customer = Customer::all();
        $product  = Product::all();
        $employee = Employee::all();

        $invoice_data = Invoice::orderBy('id', 'desc')->first();

        if ($invoice_data == null) {
            $firstReg   = '0';
            $invoice_no = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $invoice_no   = $invoice_data + 1;
        }

        $date = date('Y-m-d');

        return view('backend.invoice.add_wholesale', compact('customer', 'product', 'employee', 'invoice_no', 'date'));

    }

    public function WholesaleStore(Request $request) {

        DB::beginTransaction();

        try {
            // Validate request data
            $request->validate([
                'product_id'   => 'required|array',
                'type'         => 'required|array',
                'product_code' => 'required|array',
                'product_name' => 'required|array',
                'quantity'     => 'required|array',
                'price'        => 'required|array',
                'total'        => 'required|array',
                'customer_id'  => 'required|integer|min:0', // Allow 0 for new customer
            ]);

            if ($request->customer_id == 0) {
                // Create a new customer
                $customer = Customer::create([
                    'shopname'            => $request->shopname,
                    'name'                => $request->name,
                    'mobile_no'           => $request->mobile_no,
                    'previous_due_amount' => $request->due_amount, // Due from new customer
                ]);
            } else {
                // Update existing customer
                $customer = Customer::find($request->customer_id);

                if ($customer) {
                    // Add new invoice due to the existing previous_due_amount
                    $newDueAmount = $customer->previous_due_amount + $request->due_amount;

                    $customer->update([
                        'previous_due_amount' => $newDueAmount, // Update with new total
                    ]);
                } else {
                    return response()->json(['error' => 'Customer not found'], 404);
                }

            }

            // Step 1: Create Invoice
            $invoice = Invoice::create([
                'invoice_no'          => $request->invoice_no,
                'sale_type'           => 'wholesale',
                'date'                => $request->date,
                'comment'             => $request->comment,
                'employee_id'         => $request->employee_id,
                'customer_id'         => $customer->id, // Use the customer ID directly
                'total_amount'        => $request->total_amount,
                'percentage_discount' => $request->percentage_discount,
                'flat_discount'       => $request->flat_discount,
                'shipping'            => $request->shipping,
                'labour'              => $request->labour,
                'payable_amount'      => $request->payable_amount,
                'status'              => $request->status,
                'previous_due_amount' => $customer->previous_due_amount, // Existing due from customer
                'due_amount'          => $request->due_amount, // New due from this invoice
                'created_by'          => Auth::user()->id,
            ]);

// Step 2: Create Invoice Details and Update Product Quantities
            foreach ($request->product_id as $key => $productId) {

                $quantity = $request->quantity[$key] ?? 0;
                $type     = strtolower($request->type[$key] ?? '');


                // Create invoice detail
                InvoiceDetail::create([
                    'invoice_id'   => $invoice->id,
                    'product_id'   => $productId,
                    'product_code' => $request->product_code[$key] ?? '',
                    'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                    'type'         => $type,
                    'quantity'     => $quantity,
                    'price'        => $request->price[$key],
                    'total'        => $request->total[$key],
                ]);

// Update product quantity in the products table
                if ($productId && $quantity > 0) {
                    // Validate productId এবং quantity
                    $product = Product::find($productId);

                    if ($product) {
                        Log::info('Before stock update', [
                            'product_id'      => $productId,
                            'current_stock'   => $product->quantity,
                            'type'            => $type,
                            'quantity_change' => $quantity,
                            'product_name'    => $product->name,
                        ]);

                        if ($type === 'sale') {
                            $product->decrement('quantity', $quantity);
                        } elseif ($type === 'return') {
                            $product->increment('quantity', $quantity);
                        }

                        Log::info('After stock update', [
                            'product_id'    => $productId,
                            'updated_stock' => $product->fresh()->quantity,
                            'product_name'  => $product->name,
                        ]);
                    }

                }

            }

            // Step 3: Create Payment
            $payment = Payment::create([
                'invoice_id'          => $invoice->id,
                'customer_id'         => $customer->id,
                'paid_amount'         => $request->paid_amount,
                'due_amount'          => $request->due_amount,
                'previous_due_amount' => $request->previous_due_amount,
            ]);

            // Step 4: Create Payment Details
            PaymentDetail::create([
                'payment_id'       => $payment->id,
                'paid_amount'      => $request->paid_amount,
                'transaction_type' => $request->transaction_type,
            ]);

// Step 5: Create Sale Returns (if applicable)
            foreach ($request->type as $key => $type) {
                if ($type === 'return') {
                    SaleReturn::create([
                        'invoice_id'   => $invoice->id,
                        'product_id'   => $request->product_id[$key] ?? null,
                        'product_code' => $request->product_code[$key] ?? '',
                        'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                        'quantity'     => $request->quantity[$key] ?? 0,
                        'price'        => $request->price[$key] ?? 0.00,
                        'total'        => $request->total[$key] ?? 0.00,
                    ]);
                }

            }

            DB::commit(); // Commit the transaction

            $notification = [
                'message'    => 'Sale and return processed successfully.',
                'alert-type' => 'success',
            ];
            return redirect()->route('print.invoice', ['id' => $invoice->id])->with($notification);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    // public function updateWholesaleSale(Request $request, $id) {
    //     DB::beginTransaction();

    //     try {
    //         // Validate request data
    //         $request->validate([
    //             'product_id'  => 'required|array',
    //             'type'        => 'required|array',
    //             'quantity'    => 'required|array',
    //             'price'       => 'required|array',
    //             'total'       => 'required|array',
    //             'customer_id' => 'required',
    //         ]);

    //         // Fetch the existing invoice
    //         $invoice = Invoice::findOrFail($id);

    //         if ($request->customer_id == 0) {
    //             $customer = Customer::create([
    //                 'shopname'  => $request->shopname,
    //                 'name'      => $request->name,
    //                 'mobile_no' => $request->mobile_no,
    //                 'address'   => $request->address,
    //             ]);
    //         } else {
    //             $customer = Customer::findOrFail($request->customer_id);
    //             $customer->update([
    //                 'shopname'  => $request->shopname ?? $customer->shopname,
    //                 'name'      => $request->name ?? $customer->name,
    //                 'mobile_no' => $request->mobile_no ?? $customer->mobile_no,
    //                 'address'   => $request->address ?? $customer->address,
    //             ]);
    //         }

    //         // Update invoice details
    //         $invoice->update([
    //             'date'                => $request->date,
    //             'sale_type'           => 'wholesale',
    //             'comment'             => $request->comment,
    //             'employee_id'         => $request->employee_id,
    //             'customer_id'         => $customer->id,
    //             'total_amount'        => $request->total_amount,
    //             'percentage_discount' => $request->percentage_discount,
    //             'flat_discount'       => $request->flat_discount,
    //             'shipping'            => $request->shipping,
    //             'labour'              => $request->labour,
    //             'payable_amount'      => $request->payable_amount,
    //             'due_amount'          => $request->due_amount,
    //             'status'              => $request->status,
    //         ]);

    //         // Fetch existing invoice details for stock adjustment
    //         $existingDetails = InvoiceDetail::where('invoice_id', $id)->get()->keyBy('product_id');

    //         foreach ($request->product_id as $key => $productId) {
    //             $newQuantity = $request->quantity[$key];
    //             $newType     = strtolower($request->type[$key]);

    //             $oldDetail = $existingDetails->get($productId);

    //             $oldQuantity = $oldDetail ? $oldDetail->quantity : 0;
    //             $oldType     = $oldDetail ? strtolower($oldDetail->type) : null;

    //             $quantityAdjustment = 0;

    //             if ($oldDetail) {

    //                 if ($oldType === 'sale') {

    //                     if ($newType === 'sale') {
    //                         $quantityAdjustment = $oldQuantity - $newQuantity;
    //                     } elseif ($newType === 'return') {
    //                         $quantityAdjustment = $oldQuantity + $newQuantity;
    //                     }

    //                 } elseif ($oldType === 'return') {

    //                     if ($newType === 'return') {
    //                         $quantityAdjustment = $newQuantity - $oldQuantity;
    //                     } elseif ($newType === 'sale') {
    //                         $quantityAdjustment = -($oldQuantity + $newQuantity);
    //                     }

    //                 }

    //             } else {
    //                 $quantityAdjustment = $newType === 'sale' ? -$newQuantity : $newQuantity;
    //             }

    //             if ($quantityAdjustment !== 0) {
    //                 $product = Product::lockForUpdate()->find($productId);

    //                 if ($product) {

    //                     if ($quantityAdjustment < 0) {
    //                         $decrementValue = abs($quantityAdjustment);

    //                         if ($product->quantity < $decrementValue) {
    //                             throw new \Exception("Insufficient stock for product: {$product->name}");
    //                         }

    //                         $product->decrement('quantity', $decrementValue);
    //                     } else {
    //                         $product->increment('quantity', $quantityAdjustment);
    //                     }

    //                 }

    //             }

    //             // Update or create invoice detail
    //             InvoiceDetail::updateOrCreate(
    //                 ['invoice_id' => $id, 'product_id' => $productId],
    //                 [
    //                     'product_code' => $request->product_code[$key] ?? '',
    //                     'product_name' => $request->product_name[$key] ?? 'Unknown Product',
    //                     'type'         => $newType,
    //                     'quantity'     => $newQuantity,
    //                     'price'        => $request->price[$key],
    //                     'total'        => $request->total[$key],
    //                 ]
    //             );
    //         }

    //         // Update Payment details
    //         $payment = Payment::where('invoice_id', $id)->first();

    //         if ($payment) {
    //             $payment->update([
    //                 'paid_amount'         => $request->paid_amount,
    //                 'due_amount'          => $request->due_amount,
    //                 'previous_due_amount' => $customer->previous_due_amount,
    //             ]);

    //             PaymentDetail::where('payment_id', $payment->id)->delete();
    //             PaymentDetail::create([
    //                 'payment_id'       => $payment->id,
    //                 'paid_amount'      => $request->paid_amount,
    //                 'transaction_type' => is_array($request->transaction_type) ? $request->transaction_type[0] : $request->transaction_type,
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()->route('print.invoice', ['id' => $invoice->id])->with([
    //             'message'    => 'Invoice updated successfully.',
    //             'alert-type' => 'success',
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }

    // }


    public function updateWholesaleSale(Request $request, $invoiceId) {
        DB::beginTransaction();

        try {
            $invoice     = Invoice::findOrFail($invoiceId);
            $originalDue = $invoice->due_amount;
            $customer    = $invoice->customer;

            $request->validate([
                'product_id'   => 'required|array',
                'type'         => 'required|array',
                'product_code' => 'required|array',
                'product_name' => 'required|array',
                'quantity'     => 'required|array',
                'price'        => 'required|array',
                'total'        => 'required|array',
                'customer_id'  => 'required|integer|min:0',
            ]);

            // Fetch the existing invoice
            $invoice = Invoice::findOrFail($id);

            if ($request->customer_id == 0) {
                $customer = Customer::create([
                    'shopname'  => $request->shopname,
                    'name'      => $request->name,
                    'mobile_no' => $request->mobile_no,
                    'address'   => $request->address,
                ]);
            } else {
                $customer = Customer::findOrFail($request->customer_id);
                $customer->update([
                    'shopname'  => $request->shopname ?? $customer->shopname,
                    'name'      => $request->name ?? $customer->name,
                    'mobile_no' => $request->mobile_no ?? $customer->mobile_no,
                    'address'   => $request->address ?? $customer->address,
                ]);
            }

            // Update invoice details
            $invoice->update([
                'date'                => $request->date,
                'sale_type'           => 'wholesale',
                'comment'             => $request->comment,
                'employee_id'         => $request->employee_id,
                'customer_id'         => $customer->id,
                'total_amount'        => $request->total_amount,
                'percentage_discount' => $request->percentage_discount,
                'flat_discount'       => $request->flat_discount,
                'shipping'            => $request->shipping,
                'labour'              => $request->labour,
                'payable_amount'      => $request->payable_amount,
                'due_amount'          => $request->due_amount,
                'status'              => $request->status,
            ]);

            // Fetch existing invoice details for stock adjustment
            $existingDetails = InvoiceDetail::where('invoice_id', $id)->get()->keyBy('product_id');

            foreach ($request->product_id as $key => $productId) {
                $newQuantity = $request->quantity[$key];
                $newType     = strtolower($request->type[$key]);

                $oldDetail = $existingDetails->get($productId);

                $oldQuantity = $oldDetail ? $oldDetail->quantity : 0;
                $oldType     = $oldDetail ? strtolower($oldDetail->type) : null;

                $quantityAdjustment = 0;

                if ($oldDetail) {

                    if ($oldType === 'sale') {

                        if ($newType === 'sale') {
                            $quantityAdjustment = $oldQuantity - $newQuantity;
                        } elseif ($newType === 'return') {
                            $quantityAdjustment = $oldQuantity + $newQuantity;
                        }

                    } elseif ($oldType === 'return') {

                        if ($newType === 'return') {
                            $quantityAdjustment = $newQuantity - $oldQuantity;
                        } elseif ($newType === 'sale') {
                            $quantityAdjustment = -($oldQuantity + $newQuantity);
                        }

                    }

                } else {
                    $quantityAdjustment = $newType === 'sale' ? -$newQuantity : $newQuantity;
                }

                if ($quantityAdjustment !== 0) {
                    $product = Product::lockForUpdate()->find($productId);

                    if ($product) {

                        if ($quantityAdjustment < 0) {
                            $decrementValue = abs($quantityAdjustment);

                            if ($product->quantity < $decrementValue) {
                                throw new \Exception("Insufficient stock for product: {$product->name}");
                            }

                            $product->decrement('quantity', $decrementValue);
                        } else {
                            $product->increment('quantity', $quantityAdjustment);
                        }

                    }

                }

                // Update or create invoice detail
                InvoiceDetail::updateOrCreate(
                    ['invoice_id' => $id, 'product_id' => $productId],
                    [
                        'product_code' => $request->product_code[$key] ?? '',
                        'product_name' => $request->product_name[$key] ?? 'Unknown Product',
                        'type'         => $newType,
                        'quantity'     => $newQuantity,
                        'price'        => $request->price[$key],
                        'total'        => $request->total[$key],
                    ]
                );
            }

            // Update Payment details
            $payment = Payment::where('invoice_id', $id)->first();

            if ($payment) {
                $payment->update([
                    'paid_amount'         => $request->paid_amount,
                    'due_amount'          => $request->due_amount,
                    'previous_due_amount' => $customer->previous_due_amount,
                ]);

                PaymentDetail::where('payment_id', $payment->id)->delete();
                PaymentDetail::create([
                    'payment_id'       => $payment->id,
                    'paid_amount'      => $request->paid_amount,
                    'transaction_type' => is_array($request->transaction_type) ? $request->transaction_type[0] : $request->transaction_type,
                ]);
            }

            DB::commit();

            return redirect()->route('print.invoice', ['id' => $invoice->id])->with([
                'message'    => 'Invoice updated successfully.',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function PrintInvoice($id) {
        $invoice = Invoice::with(['invoice_details', 'employee'])->findOrFail($id);

        // Assuming you have a payment related to this invoice
        $payment = Payment::where('invoice_id', $id)->with('customer')->first();

        $invoiceDetails = InvoiceDetail::with('invoice')->where('invoice_id', $id)->get();

        return view('backend.pdf.invoice_pdf', compact('invoice', 'payment', 'invoiceDetails'));

    }

// End Method

    public function InvoiceDelete($id) {
        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($id);

// Find the invoice

            // Update the customer's previous due amount
            $customer = Customer::find($invoice->customer_id);

            if ($customer) {
                $customer->update([
                    'previous_due_amount' => $customer->previous_due_amount - $invoice->due_amount,
                ]);
            }

            // Delete related data
            InvoiceDetail::where('invoice_id', $invoice->id)->delete();
            $payments = Payment::where('invoice_id', $invoice->id)->get();

            foreach ($payments as $payment) {
                PaymentDetail::where('payment_id', $payment->id)->delete();
            }

            Payment::where('invoice_id', $invoice->id)->delete();

            // Delete the invoice
            $invoice->delete();

            DB::commit();

            // Success notification
            $notification = [
                'message'    => 'Invoice and all related data deleted successfully.',
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }

    }

    // End Method

}

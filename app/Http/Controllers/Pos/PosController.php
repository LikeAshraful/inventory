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



class PosController extends Controller
{
	//For PosSale functionality

    public function PosSale() {
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

        return view('backend.pos.pos_page', compact('customer', 'product', 'employee', 'invoice_no', 'date'));

    } // End Method


	public function PosSaleStore(Request $request) {
        
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

    } // End Method


}

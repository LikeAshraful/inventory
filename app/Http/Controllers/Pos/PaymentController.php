<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Supplier;
use Auth;
use DB;

class PaymentController extends Controller
{
    public function customerPayment()
    {
        $customers = Customer::where('status', 1)
            ->where('previous_due_amount', '>', 0)
            ->orderBy('name')
            ->get(['id', 'name', 'previous_due_amount']);

        return view('backend.payment.customer_payment_add', compact('customers'));
    }

    public function storeCustomerPayment(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'transaction_type' => 'required|string',
            'invoice_id' => 'nullable|exists:invoices,id',
            'flat_discount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $customer = Customer::findOrFail($request->customer_id);
            $amount = $request->amount - ($request->flat_discount ?? 0);

            // Create payment record
            $payment = Payment::create([
                'customer_id' => $customer->id,
                'paid_amount' => $amount,
                'payment_date' => $request->payment_date,
                'discount' => $request->flat_discount ?? 0,
                'created_by' => Auth::id(),
                'note' => $request->note
            ]);

            // Create payment detail
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'paid_amount' => $amount,
                'transaction_type' => $request->transaction_type,
                // 'payment_date' => $request->payment_date
            ]);

            // Update customer's due amount
            $customer->decrement('previous_due_amount', $amount);

            // If payment is for specific invoice
            if ($request->invoice_id) {
                $invoice = Invoice::find($request->invoice_id);
                if ($invoice) {
                    $newDue = max(0, $invoice->due_amount - $amount);
                    $invoice->update(['due_amount' => $newDue]);
                    $payment->update(['invoice_id' => $invoice->id]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully',
                'customer_due' => $customer->fresh()->previous_due_amount,
                'customer_id' => $customer->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Payment failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCustomerInvoices($customerId)
    {
        $invoices = Invoice::where('customer_id', $customerId)
            ->where('due_amount', '>', 0)
            ->get(['id', 'invoice_no', 'due_amount']);

        return response()->json($invoices);
    }

    public function getCustomerDetails($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        return response()->json([
            'due_amount' => $customer->previous_due_amount,
            'mobile_no' => $customer->mobile_no,
            'address' => $customer->address
        ]);
    }

    public function supplierPayment()
    {
        $suppliers = Supplier::where('status', 1)
            ->where('balance', '>', 0)
            ->orderBy('shopname')
            ->get(['id', 'shopname', 'balance']);

        return view('backend.payment.supplier_payment_add', compact('suppliers'));
    }

    public function storeSupplierPayment(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'transaction_type' => 'required|string',
            'note' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $supplier = Supplier::findOrFail($request->supplier_id);
            $amount = $request->amount;

            // Create payment record
            $payment = Payment::create([
                'supplier_id' => $supplier->id,
                'paid_amount' => $amount,
                'payment_date' => $request->payment_date,
                'created_by' => Auth::id(),
                'note' => $request->note
            ]);

            // Create payment detail
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'paid_amount' => $amount,
                'transaction_type' => $request->transaction_type,
                // 'payment_date' => $request->payment_date
            ]);

            // Update supplier's balance
            $supplier->decrement('balance', $amount);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully',
                'supplier_balance' => $supplier->fresh()->balance,
                'supplier_id' => $supplier->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Payment failed: ' . $e->getMessage()
            ], 500);
        }
    }
}

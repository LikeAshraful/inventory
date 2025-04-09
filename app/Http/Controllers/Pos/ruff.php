@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="card-title">Customer Payment Page</h4><br><br>

                        <form id="paymentForm" method="POST" action="{{ route('customer.payment.store') }}">
                            @csrf

                            <div class="row">
                                <!-- Customer Selection -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label for="customer_id" class="form-label">Customer *</label>
                                        <select name="customer_id" id="customer_id" class="form-select select2" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $cus)
                                                <option value="{{ $cus->id }}" 
                                                    data-due="{{ $cus->previous_due_amount }}">
                                                    {{ $cus->name }} ({{ $cus->mobile_no }}) - Due: {{ $cus->previous_due_amount }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Current Due Amount (will update when customer changes) -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label>Current Due Amount</label>
                                        <input type="text" class="form-control" 
                                               id="current_due_amount" value="0.00" readonly>
                                    </div>
                                </div>

                                <!-- Invoice Selection (Optional) -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label>Apply to Invoice (Optional)</label>
                                        <select class="form-control select2" name="invoice_id" id="invoice_select" disabled>
                                            <option value="">Select Customer First</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Payment Amount -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label>Payment Amount *</label>
                                        <input type="number" class="form-control" name="amount" 
                                               id="payment_amount" required min="0.01" step="0.01">
                                    </div>
                                </div>

                                <!-- Discount -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label>Discount (Optional)</label>
                                        <input name="flat_discount" class="form-control" 
                                               type="number" id="discount_amount" min="0" step="0.01" value="0">
                                    </div>
                                </div>

                                <!-- Payment Date -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label>Payment Date *</label>
                                        <input type="date" class="form-control" name="payment_date" 
                                               value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>

                                <!-- Transaction Type -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label>Transaction Type *</label>
                                        <select class="form-select select2" name="transaction_type" required>
                                            <option value="Cash">Cash</option>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Cash Apps">Cash Apps</option>
                                            <option value="DBBL">DBBL</option>
                                            <option value="IBBL">IBBL</option>
                                            <option value="City Bank">City Bank</option>
                                            <option value="Brac Bank">Brac Bank</option>
                                            <option value="Other">Other</option>
                                            <option value="Account Transfer">Account Transfer</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Note -->
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <label>Note (Optional)</label>
                                        <textarea class="form-control" name="note" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-info waves-effect waves-light">
                                            Save Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // When customer changes, update due amount and load their invoices
    $('#customer_id').change(function() {
        var selectedCustomer = $(this).find('option:selected');
        var dueAmount = selectedCustomer.data('due') || 0;
        var customerId = $(this).val();
        
        // Update current due amount display
        $('#current_due_amount').val(dueAmount);
        
        // Set max payment amount
        $('#payment_amount').attr('max', dueAmount);
        
        // Enable/disable invoice select
        if (customerId) {
            // Load invoices for this customer via AJAX
            loadCustomerInvoices(customerId);
            $('#invoice_select').prop('disabled', false);
        } else {
            $('#invoice_select').html('<option value="">Select Customer First</option>');
            $('#invoice_select').prop('disabled', true);
        }
    });
    
    // When invoice is selected, update max payment amount
    $('#invoice_select').change(function() {
        var selectedInvoice = $(this).find('option:selected');
        var invoiceDue = selectedInvoice.data('due');
        
        if (invoiceDue) {
            $('#payment_amount').attr('max', invoiceDue);
        } else {
            // If no invoice selected, use customer's total due
            $('#payment_amount').attr('max', $('#current_due_amount').val());
        }
    });
    
    // Calculate net payment after discount
    $('#discount_amount').on('input', function() {
        var paymentAmount = parseFloat($('#payment_amount').val()) || 0;
        var discount = parseFloat($(this).val()) || 0;
        
        if (discount > paymentAmount) {
            alert('Discount cannot be greater than payment amount');
            $(this).val(paymentAmount);
        }
    });
    
    // Function to load customer invoices via AJAX
    function loadCustomerInvoices(customerId) {
        $.ajax({
            url: '/get-customer-invoices/' + customerId,
            type: 'GET',
            success: function(response) {
                var options = '<option value="">General Payment</option>';
                
                if (response.length > 0) {
                    $.each(response, function(index, invoice) {
                        options += '<option value="' + invoice.id + '" data-due="' + invoice.due_amount + '">' +
                                   'Invoice #' + invoice.invoice_no + ' (Due: ' + invoice.due_amount + ')' +
                                   '</option>';
                    });
                } else {
                    options += '<option value="">No unpaid invoices found</option>';
                }
                
                $('#invoice_select').html(options);
            },
            error: function() {
                $('#invoice_select').html('<option value="">Error loading invoices</option>');
            }
        });
    }
});
</script>

@endsection
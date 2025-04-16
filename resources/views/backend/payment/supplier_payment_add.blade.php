@extends('admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Supplier Payment System</h4>
                            <p class="card-title-desc">Complete payment processing in single page</p>

                            <form id="paymentForm">
                                @csrf
                                <!-- Supplier Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="md-3">
                                            <label for="supplier_id" class="form-label">Supplier Name</label>
                                            <select name="supplier_id" id="supplier_id" class="form-select select2">
                                                <option selected="">Select Supplier</option>
                                                @foreach ($suppliers as $supp)
                                                    <option value="{{ $supp->id }}" data-due="{{ $supp->balance }}">
                                                        {{ $supp->shopname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-1">
                                        <label>Current Due Amount</label>
                                        <input type="text" class="form-control" id="current_due_amount" readonly>
                                    </div>
                                </div>


                                <!-- Payment Details -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Payment Date *</label>
                                        <input type="date" class="form-control" name="payment_date"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Transaction Type *</label>
                                        <select class="form-select select2" name="transaction_type" required>
                                            <option value="Cash">Cash</option>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Discount (Optional)</label>
                                        <input name="flat_discount" class="form-control" type="number" id="discount_amount"
                                            min="0" step="0.01" value="0">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Payment Amount *</label>
                                        <input type="number" class="form-control" name="amount" id="payment_amount"
                                            required min="0.01" step="0.01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Note (Optional)</label>
                                        <textarea class="form-control" name="note" rows="1"></textarea>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save"></i> Save Payment
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
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
            $('.select2').select2({
                width: '100%',
                placeholder: $(this).data('placeholder')
            });


            // When supplier is selected
            $('#supplier_id').change(function() {
                var selectedOption = $(this).find('option:selected');
                var supplier_id = $(this).val();

                if (supplier_id) {
                    // Get data from option attributes
                    var dueAmount = selectedOption.data('due');

                    // Update form fields
                    $('#current_due_amount').val(dueAmount);
                    $('#payment_amount').attr('max', dueAmount).val('');

                    // $('#invoice_select').prop('disabled', false).val(null).trigger('change');
                    // $('#paymentHistorySection').show();
                } else {
                    // Reset form if no supplier selected
                    resetFormFields();
                }

                // Handle form submission
                $('#paymentForm').submit(function(e) {
                    e.preventDefault();

                    if (!$('#supplier_id').val()) {
                        toastr.error('Please select a supplier first');
                        return;
                    }

                    var formData = $(this).serialize();
                    var url = "{{ route('supplier.payment.store') }}";
                    var supplierId = $('#supplier_id').val();

                    $('#submitBtn').prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Processing...');

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);

                                // Update customer due amount in dropdown
                                var option = $('#supplier_id option[value="' +
                                    supplierId + '"]');
                                option.data('due', response.customer_due);
                                option.text(option.text().replace(/Due: [\d.]+/,
                                    'Due: ' + response
                                    .customer_due));

                                // Update current due amount
                                $('#current_due_amount').val(response.customer_due);

                                // Reset form
                                $('#payment_amount, #discount_amount').val('');
                                // loadPaymentHistory(customerId);
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message || 'Payment failed');
                        },
                        complete: function() {
                            $('#submitBtn').prop('disabled', false).html(
                                '<i class="fas fa-save"></i> Save Payment');
                        }
                    });
                });


                // Reset form fields
                function resetFormFields() {
                    $('#current_due_amount').val('');
                    $('#paymentHistorySection').hide();
                }
            });
        });
    </script>



    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endsection

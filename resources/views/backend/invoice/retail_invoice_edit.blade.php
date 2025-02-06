@extends('admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <form action="{{ route('retailsale.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body row">
                                <div class="col-md-9">
                                    <h4 class="card-title">Retail Invoice Edit Page</h4>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="md-3">
                                                <label for="date" class="form-label">Date</label>
                                                <input class="form-control" name="date" type="date" id="date"
                                                    value="{{ $invoice->date }}">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label">Inv No</label>
                                                <input class="form-control example-date-input" name="invoice_no"
                                                    type="text" value="{{ $invoice->invoice_no }}" id="invoice_no"
                                                    readonly style="background-color:#ddd">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="md-3">
                                                <label for="customer_id" class="form-label">Customer Name</label>
                                                <select name="customer_id" id="customer_id" class="form-select select2">
                                                    <option value="">Select Customer</option>
                                                    <option value="0">New Customer</option>
                                                    @foreach ($customer as $cus)
                                                        <option value="{{ $cus->id }}"
                                                            {{ $invoice->customer_id == $cus->id ? 'selected' : '' }}>
                                                            {{ $cus->name }} - {{ $cus->mobile_no }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <!-- Hidden fields for new customer details -->
                                        <div id="new_customer_details" style="display: none;">
                                            <div class="col-md-3">
                                                <label for="shopname" class="form-label">Shop Name</label>
                                                <input type="text" name="shopname" id="shopname" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="name" class="form-label">Customer Name</label>
                                                <input type="text" name="name" id="name" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="mobile_no" class="form-label">Mobile Number</label>
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="md-3">
                                                <label for="product_id" class="form-label">Product Name</label>
                                                <select name="product_name" id="product_id" class="form-select select2">
                                                    <option selected="">Open this select menu</option>
                                                    @foreach ($product as $prod)
                                                        <option value="{{ $prod->id }}">{{ $prod->name }} -
                                                            {{ $prod->product_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="md-3">
                                                <label for="current_stock_qty" class="form-label">Stock(Crnt)</label>

                                                <input class="form-control example-date-input" name="current_stock_qty"
                                                    type="text" id="current_stock_qty" readonly
                                                    style="background-color:#ddd">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="md-3">
                                                <label for="invoice_qty" class="form-label">Inv(Qty)</label>

                                                <input class="form-control example-date-input" name="invoice_qty"
                                                    type="number" id="invoice_qty" value="{{ $invoice->quantity ?? 0 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-1" style="margin-top:30px;">
                                            <div class="md-3">
                                                <label for="addMoreButton" class="form-label"></label>
                                                <i class="btn btn-secondary btn-rounded waves-effect waves-light addeventmore"
                                                    id="addMoreButton">Add</i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <table class="table-sm table-bordered" width="100%"
                                                style="border-color: #ddd;">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Product code</th>
                                                        <th>Product name</th>
                                                        <th>Qty</th>
                                                        <th>Retail price</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="addRow" class="addRow">
                                                    @foreach ($invoice->invoice_details as $detail)
                                                        <tr>
                                                            <input type="hidden" name="product_id[]"
                                                                value="{{ $detail->product_id }}">
                                                            <td>
                                                                <select name="type[]"
                                                                    class="form-select transaction-type">
                                                                    <option value="sale"
                                                                        {{ $detail->type == 'sale' ? 'selected' : '' }}>
                                                                        Sale</option>
                                                                    <option value="return"
                                                                        {{ $detail->type == 'return' ? 'selected' : '' }}>
                                                                        Return</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="product_code[]"
                                                                    class="form-control"
                                                                    value="{{ $detail->product->product_code }}" readonly>
                                                            </td>
                                                            <td><input type="text" name="product_name[]"
                                                                    class="form-control"
                                                                    value="{{ $detail->product->name }}" readonly></td>
                                                            <td><input type="number" name="quantity[]"
                                                                    class="form-control qty" min="1"
                                                                    value="{{ $detail->quantity }}"></td>
                                                            <td><input type="number" name="price[]"
                                                                    class="form-control price" min="0"
                                                                    value="{{ $detail->price }}"></td>
                                                            <td><input type="number" name="total[]"
                                                                    class="form-control total"
                                                                    value="{{ $detail->total }}" readonly></td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm remove">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon1">Comment</span>
                                                        <input type="text" class="form-control" name="comment"
                                                            id="comment" aria-label="Comment"
                                                            aria-describedby="basic-addon1"
                                                            value="{{ $invoice->comment }}">
                                                    </div>
                                                </div>
                                                @php
                                                    $loggedInUserId = Auth::id(); // Get the logged-in user ID
                                                    $loggedInUserName = Auth::user()->name; // Get the logged-in user name
                                                @endphp
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon1">Sales Man</span>
                                                        <select class="form-select" name="employee_id" id="employee_id"
                                                            aria-label="Salesman">
                                                            <option value="" selected>Select Sales Man</option>
                                                            @foreach ($employee as $employees)
                                                                <option value="{{ $employees->id }}"
                                                                    {{ old('employee_id') == $employees->id || $employees->id == $loggedInUserId ? 'selected' : '' }}>
                                                                    {{ $employees->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon1">Status</span>
                                                        <select class="form-select" name="status"
                                                            id="floatingSelectGrid"
                                                            aria-label="Floating label select example">
                                                            <option value="0">Complete</option>
                                                            <option value="1">Draft</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12" style="background-color: #f3f7f9; padding:20px;">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">Total</span>
                                            <input type="text" class="form-control" name="total_amount"
                                                id="total_amount" value="{{ $invoice->total_amount ?? '' }}"
                                                aria-label="Total" aria-describedby="basic-addon1" readonly
                                                style="background-color: #ddd;">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Return</span>
                                            <input type="text" class="form-control return" name="return_amount"
                                                id="return_amount" value="{{ $invoice->return_amount ?? '' }}"
                                                aria-label="Return" aria-describedby="basic-addon1" readonly
                                                style="background-color: #ddd;">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Discount</span>
                                            <input type="text" class="form-control" name="percentage_discount"
                                                id="percentage_discount"
                                                value="{{ $invoice->percentage_discount ?? '' }}" placeholder="%"
                                                aria-describedby="basic-addon1">
                                            <input type="text" class="form-control" name="flat_discount"
                                                id="flat_discount" value="{{ $invoice->flat_discount ?? '' }}"
                                                placeholder="Flat Discount">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Shipping</span>
                                            <input type="text" class="form-control" name="shipping" id="shipping"
                                                value="{{ $invoice->shipping ?? '' }}" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Labour</span>
                                            <input type="text" class="form-control" name="labour" id="labour"
                                                value="{{ $invoice->labour ?? '' }}" aria-describedby="basic-addon1">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Payable Amount</span>
                                            <input type="text" class="form-control" name="payable_amount"
                                                id="payable_amount" value="{{ $invoice->payable_amount ?? '' }}"
                                                aria-describedby="basic-addon1">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Paid Amount</span>
                                            <input type="text" class="form-control" name="paid_amount"
                                                id="paid_amount"
                                                value="{{ $invoice->payments->sum('paid_amount') ?? '' }}"
                                                aria-describedby="basic-addon1">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Due Amount</span>
                                            <input type="text" class="form-control" name="due_amount" id="due_amount"
                                                value="{{ $invoice->payments->sum('due_amount') ?? '' }}"
                                                aria-describedby="basic-addon1" readonly style="background-color: #ddd;">
                                        </div>
                                        <div class="input-group mt-3">
                                            <span class="input-group-text" id="basic-addon1">Previous Due</span>
                                            <input type="text" class="form-control" name="previous_due_amount"
                                                id="previous_due_amount"
                                                value="{{ $invoice->payments->sum('previous_due_amount') ?? '' }}"
                                                readonly style="background-color: #ddd;">
                                        </div>

                                        @foreach ($invoice->payment_details as $paymentDetail)
                                            <div class="input-group mt-3">
                                                <span class="input-group-text" id="basic-addon1">Transaction</span>
                                                <select class="form-select" name="transaction_type[]">
                                                    <option value="Cash"
                                                        {{ $paymentDetail->transaction_type == 'Cash' ? 'selected' : '' }}>
                                                        Cash</option>
                                                    <option value="Bkash"
                                                        {{ $paymentDetail->transaction_type == 'Bkash' ? 'selected' : '' }}>
                                                        Bkash</option>
                                                    <option value="Cash Apps"
                                                        {{ $paymentDetail->transaction_type == 'Cash Apps' ? 'selected' : '' }}>
                                                        Cash Apps</option>
                                                    <option value="DBBL"
                                                        {{ $paymentDetail->transaction_type == 'DBBL' ? 'selected' : '' }}>
                                                        DBBL</option>
                                                    <option value="Nagad"
                                                        {{ $paymentDetail->transaction_type == 'Nagad' ? 'selected' : '' }}>
                                                        Nagad</option>
                                                    <option value="Card"
                                                        {{ $paymentDetail->transaction_type == 'Card' ? 'selected' : '' }}>
                                                        Card</option>
                                                    <option value="Bank Transfer"
                                                        {{ $paymentDetail->transaction_type == 'Bank Transfer' ? 'selected' : '' }}>
                                                        Bank Transfer</option>
                                                </select>
                                            </div>
                                        @endforeach

                                        <div class="mt-3">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="submit" class="btn btn-info" id="storeButton"> Update
                                                    Invoice</button>
                                                <button type="button" class="btn btn-rounded btn-danger"
                                                    onclick="location.reload();">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>

    <script id="document-template" type="text/x-handlebars-template">
      <tr>
          <input type="hidden" name="product_id[]" value="@{{product_id}}">
          <td>
              <select name="type[]" class="form-select transaction-type">
                  <option value="sale" selected>Sale</option>
                  <option value="return">Return</option>
              </select>
          </td>
          <td><input type="text" name="product_code[]" class="form-control" value="@{{product_code}}" readonly></td>
          <td><input type="text" name="product_name[]" class="form-control" value="@{{product_name}}" readonly></td>
          <td><input type="number" name="quantity[]" class="form-control qty" min="1" value="1"></td>
          <td><input type="number" name="price[]" class="form-control price" min="0" value="@{{retail_sale}}"></td>
          <td><input type="number" name="total[]" class="form-control total" value="@{{retail_sale}}" readonly></td>
          <td><button type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
      </tr>
   </script>

    <!-- // for customer previous_due_amount show -->
    <script type="text/javascript">
        $(document).ready(function() {

            $('#customer_id').change(function() {
                const customerId = $(this).val();

                if (customerId == '0') {
                    // New Customer selected
                    $('.new_customer').show(); // Ensure the form is visible
                    $('#previous_due_amount').val(0); // Reset previous due for new customer
                } else {
                    $('.new_customer').hide(); // Hide the new customer form

                    if (customerId) {
                        $.ajax({
                            url: `/get-customer-details/${customerId}`, // Corrected URL
                            method: 'GET',
                            success: function(response) {
                                if (response.error) {
                                    alert(response.error);
                                    $('#previous_due_amount').val(
                                        0); // Default to 0 in case of error
                                } else {
                                    $('#previous_due_amount').val(response
                                        .previous_due_amount || 0); // Display due amount
                                }
                            },
                            error: function() {
                                alert('Failed to fetch customer details. Please try again.');
                                $('#previous_due_amount').val(0); // Default to 0 on AJAX error
                            }
                        });
                    }
                }
            });



            $(document).ready(function() {
                //start of multiple products fetch area
                $(document).on("click", ".addeventmore", function() {
                    var product_id = $('#product_id').val();
                    var invoice_qty = $('#invoice_qty').val();
                    var selected_product_name = $('#product_id option:selected').text()
                        .split('-')[0].trim();

                    if (product_id == '') {
                        alert('Please select a product first.');
                        return;
                    }

                    if (!invoice_qty || invoice_qty <= 0) {
                        invoice_qty = 1;
                    }

                    // Check if product already exists in the table
                    var existingRow = null;
                    $('#addRow tr').each(function() {
                        if ($(this).find('input[name="product_id[]"]').val() ==
                            product_id) {
                            existingRow = $(this);
                            return false; // Break the loop
                        }
                    });

                    if (existingRow) {
                        // Update existing row
                        existingRow.find('.qty').val(invoice_qty);
                        var price = parseFloat(existingRow.find('.price').val()) || 0;
                        var type = existingRow.find('.transaction-type').val();

                        // Update total based on type
                        if (type == 'return') {
                            existingRow.find('.total').val(-(invoice_qty * price));
                        } else {
                            existingRow.find('.total').val(invoice_qty * price);
                        }
                    } else {
                        // Add new row
                        $.ajax({
                            url: "{{ route('get-product-details') }}",
                            type: "GET",
                            data: {
                                product_id: product_id
                            },
                            success: function(productDetails) {
                                var data = {
                                    product_id: product_id,
                                    product_code: productDetails
                                        .product_code,
                                    product_name: selected_product_name,
                                    retail_sale: productDetails
                                        .retail_sale,
                                };

                                // Generate and append product row
                                var source = $("#document-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(data);
                                $("#addRow").append(html);

                                // Update the quantity in the new row
                                var newRow = $('#addRow tr:last');
                                newRow.find('.qty').val(invoice_qty);
                                var price = parseFloat(newRow.find('.price')
                                    .val()) || 0;
                                newRow.find('.total').val(invoice_qty *
                                    price);

                                calculateTotal(); // Recalculate totals after adding new row
                            },
                            error: function() {
                                $.notify(
                                    "Failed to fetch product details", {
                                        globalPosition: 'top right',
                                        className: 'error'
                                    });
                            }
                        });
                    }

                    // Reset product selection and quantity
                    $('#product_id').val('').trigger('change');
                    $('#invoice_qty').val('');
                    $('#current_stock_qty').val('');

                    // Recalculate totals
                    calculateTotal();
                });
            });
            



            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

            $(document).on('input', '.qty, .price, .transaction-type', function() {
                var row = $(this).closest('tr');
                var qty = parseFloat(row.find('.qty').val()) || 0;
                var price = parseFloat(row.find('.price').val()) || 0;
                var type = row.find('.transaction-type').val();

                if (type == 'return') {
                    row.find('.total').val(-qty * price); // Return amount as negative
                } else {
                    row.find('.total').val(qty * price); // Sale amount as positive
                }
                calculateTotal();
            });

            function calculateTotal() {
                var totalAmount = 0;
                var returnAmount = 0;

                // Loop through each row and calculate totals
                $('.total').each(function() {
                    var row = $(this).closest('tr');
                    var type = row.find('.transaction-type').val(); // Get the type (sale or return)

                    if (type === 'return') {
                        returnAmount += parseFloat($(this).val()) || 0; // Sum of return amounts (positive)
                    } else {
                        totalAmount += parseFloat($(this).val()) || 0; // Sum of sales amounts
                    }
                });

                // Convert returnAmount to positive if it’s negative
                returnAmount = Math.abs(returnAmount);

                var percentageDiscount = parseFloat($('#percentage_discount').val()) || 0;
                var flatDiscount = parseFloat($('#flat_discount').val()) || 0;
                var discount = flatDiscount > 0 ? flatDiscount : (totalAmount * percentageDiscount / 100);

                var shipping = parseFloat($('#shipping').val()) || 0;
                var labour = parseFloat($('#labour').val()) || 0;
                var previousDue = parseFloat($('#previous_due_amount').val()) || 0;
                var paidAmount = parseFloat($('#paid_amount').val()) || 0;

                // Correctly calculate payableAmount with returnAmount subtracted
                var payableAmount = totalAmount - returnAmount - discount + shipping + labour;
                var dueAmount = payableAmount - paidAmount;

                // Set the values in the fields
                $('#total_amount').val(totalAmount.toFixed(2)); // Show total amount
                $('#return_amount').val(returnAmount.toFixed(2)); // Show return amount
                $('#payable_amount').val(payableAmount.toFixed(2)); // Show payable amount
                $('#due_amount').val(dueAmount.toFixed(2)); // Show due amount
            }

        $(document).on('input', '#percentage_discount, #flat_discount, #shipping, #labour, #paid_amount',
            function() {
                calculateTotal();
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            // Function to get current stock for a product
            function getCurrentStock(product_id, callback) {
                $.ajax({
                    url: "{{ route('check-product-stock') }}",
                    type: "GET",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        callback(data);
                    }
                });
            }

            // Function to find existing quantity in the table for a product
            function findExistingQuantity(product_id) {
                let existingQty = 0;
                $('#addRow tr').each(function() {
                    const rowProductId = $(this).find('input[name="product_id[]"]').val();
                    if (rowProductId === product_id) {
                        existingQty = parseFloat($(this).find('.qty').val()) || 0;
                    }
                });
                return existingQty;
            }

            // Handle product selection change
            $(document).on('change', '#product_id', function() {
                const product_id = $(this).val();
                if (!product_id) return;

                // Clear invoice quantity field
                $('#invoice_qty').val('');

                // Get current stock and existing quantity
                getCurrentStock(product_id, function(stock) {
                    const existingQty = findExistingQuantity(product_id);

                    // Update current stock display
                    $('#current_stock_qty').val(stock);

                    // If product exists in table, show its quantity in invoice_qty
                    if (existingQty > 0) {
                        $('#invoice_qty').val(existingQty);
                    }
                });
            });

            // Handle quantity changes
            $(document).on('input', '#invoice_qty', function() {
                const product_id = $('#product_id').val();
                if (!product_id) return;

                const newQty = parseFloat($(this).val()) || 0;
                const existingQty = findExistingQuantity(product_id);

                // Get fresh stock data and update display
                getCurrentStock(product_id, function(originalStock) {
                    let adjustedStock;
                    if (existingQty > 0) {
                        // Adjust stock based on difference between new and existing quantity
                        adjustedStock = parseFloat(originalStock) + existingQty - newQty;
                    } else {
                        // Simple subtraction for new entries
                        adjustedStock = parseFloat(originalStock) - newQty;
                    }
                    $('#current_stock_qty').val(adjustedStock.toFixed(2));
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#employee_id').change(function() {
                // No action needed, value will be set automatically
            });

            // Check before form submission if the employee_id is empty
            $('form').submit(function() {
                if ($('#employee_id').val() === '') {
                    $('#employee_id').val("{{ $loggedInUserId }}"); // Set to logged-in user ID
                }
            });
        });
    </script>
@endsection

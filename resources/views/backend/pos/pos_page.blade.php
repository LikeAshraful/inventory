@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">POS</a></li>

                        </ol>
                    </div>
                    <h4 class="page-title">POS</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-8 col-xl-8">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="card mt-2">
                            <form method="POST" action="{{ route('possale.store') }}" id="productForm">
                                @csrf

                                <div class="card-body row">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="md-3">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input class="form-control" name="date" type="date" id="date"
                                                        value="{{ $date }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="md-3">
                                                    <label for="example-text-input" class="form-label">Inv No</label>
                                                    <input class="form-control example-date-input" name="invoice_no"
                                                        type="text" value="{{ $invoice_no }}" id="invoice_no" readonly
                                                        style="background-color:#ddd">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="md-3">
                                                    <label for="customer_id" class="form-label">Customer Name</label>
                                                    <select name="customer_id" id="customer_id"
                                                        class="form-select select2">
                                                        <option value="">Select Customer </option>
                                                        <option value="0">New Customer </option>
                                                        @foreach($customer as $cus)
                                                                                            <option value="{{ $cus->id }}">{{ $cus->name }} -
                                                            {{ $cus->mobile_no }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row new_customer mt-3"
                                                style="display: none; background-color:#ddd">
                                                <div class="col-md-4 mb-3">
                                                    <label for="shopname" class="form-label">Shop Name</label>
                                                    <input type="text" name="shopname" id="shopname"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" name="name" id="name" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="mobile_no" class="form-label">Mobile No</label>
                                                    <input type="text" name="mobile_no" id="mobile_no"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="md-3">
                                                    <label for="product_id" class="form-label">Product Name</label>
                                                    <select name="product_name" id="product_id"
                                                        class="form-select select2">
                                                        <option selected="">Open this select menu</option>
                                                        @foreach($product as $prod)
                                                                            <option value="{{ $prod->id }}">{{ $prod->name }} -
                                                            {{ $prod->product_code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="md-3">
                                                    <label for="example-text-input"
                                                        class="form-label">Stock(Pic/Kg)</label>
                                                    <input class="form-control example-date-input"
                                                        name="current_stock_qty" type="text" id="current_stock_qty"
                                                        readonly style="background-color:#ddd">
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="margin-top:30px;">
                                                <div class="md-3">
                                                    <label for="addMoreButton" class="form-label"></label>
                                                    <i class="btn btn-secondary btn-rounded waves-effect waves-light addeventmore"
                                                        id="addMoreButton"> Add More</i>
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
                                                    <tbody id="addRow" class="addRow"></tbody>
                                                </table>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-text"
                                                                id="basic-addon1">Comment</span>
                                                            <input type="text" class="form-control" name="comment"
                                                                id="comment" aria-label="Comment"
                                                                aria-describedby="basic-addon1">
                                                        </div>
                                                    </div>
                                                    @php
                                                        $loggedInUserId = Auth::id();  // Get the logged-in user ID
                                                        $loggedInUserName = Auth::user()->name;  // Get the logged-in user name
                                                     @endphp
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon1">Sales
                                                                Man</span>
                                                            <select class="form-select" name="employee_id"
                                                                id="employee_id" aria-label="Salesman">
                                                                <option value="" selected>Select Sales Man</option>
                                                                @foreach($employee as $employees)
                                                                                      <option value="{{ $employees->id }}" {{ (old('employee_id') == $employees->id || $employees->id == $loggedInUserId) ? 'selected' : '' }}>
                                                                        {{ $employees->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 ">
                                                        <div class="input-group">
                                                            <span class="input-group-text"
                                                                id="basic-addon1">Status</span>
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












                                    <!-- Signup modal content -->
                                    <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-body">


                                                    <div class="col-md-12">
                                                        <div class="col-md-12"
                                                            style="background-color: #f3f7f9; padding:20px;">
                                                            <div class="input-group">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Total</span>
                                                                <input type="text" class="form-control"
                                                                    name="total_amount" id="total_amount"
                                                                    aria-label="Total" aria-describedby="basic-addon1"
                                                                    readonly style="background-color: #ddd;">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Return</span>
                                                                <input type="text" class="form-control return"
                                                                    name="return_amount" id="return_amount"
                                                                    aria-label="Return" aria-describedby="basic-addon1"
                                                                    readonly style="background-color: #ddd;">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Discount</span>
                                                                <input type="text" class="form-control"
                                                                    name="percentage_discount" id="percentage_discount"
                                                                    placeholder="%" aria-describedby="basic-addon1">
                                                                <input type="text" class="form-control"
                                                                    name="flat_discount" id="flat_discount"
                                                                    placeholder="Flat Discount">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Shipping</span>
                                                                <input type="text" class="form-control" name="shipping"
                                                                    id="shipping" aria-describedby="basic-addon1">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Labour</span>
                                                                <input type="text" class="form-control" name="labour"
                                                                    id="labour" aria-describedby="basic-addon1">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text" id="basic-addon1">Payable
                                                                    Amount</span>
                                                                <input type="text" class="form-control"
                                                                    name="payable_amount" id="payable_amount"
                                                                    aria-describedby="basic-addon1">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text" id="basic-addon1">Paid
                                                                    Amount</span>
                                                                <input type="text" class="form-control"
                                                                    name="paid_amount" id="paid_amount"
                                                                    aria-describedby="basic-addon1">
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text" id="basic-addon1">Due
                                                                    Amount</span>
                                                                <input type="text" class="form-control"
                                                                    name="due_amount" id="due_amount"
                                                                    aria-describedby="basic-addon1" readonly
                                                                    style="background-color: #ddd;">
                                                            </div>

                                                            <!-- // for custoemr previous_due_amount show -->
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Previous Due</span>
                                                                <input type="text" class="form-control"
                                                                    name="previous_due_amount" id="previous_due_amount"
                                                                    readonly style="background-color: #ddd;" value="0">
                                                            </div>






                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text"
                                                                    id="basic-addon1">Transaction</span>
                                                                <select class="form-select" name="transaction_type">
                                                                    <option value="Cash">Cash</option>
                                                                    <option value="Bkash">Bkash</option>
                                                                    <option value="Cash Apps">Cash Apps</option>
                                                                    <option value="DBBL">DBBL</option>
                                                                    <option value="Nagad">Nagad</option>
                                                                    <option value="Card">Card</option>
                                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                                </select>
                                                            </div>
                                                            <div class="mt-3">
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="submit"
                                                                        class="btn btn-info btn-rounded waves-effect waves-light">Save
                                                                        Changes</button>
                                                                    <button type="button"
                                                                        class="btn btn-rounded btn-danger"
                                                                        onclick="location.reload();">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->









                                </div>
                            </form>
                            <div class="mt-3" style="padding:20px;">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#signup-modal">Payment</button>
                                    <button type="button" class="btn btn-rounded btn-danger"
                                        onclick="location.reload();">Cancel</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col-->

            <div class="col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <!-- end timeline content-->
                        <div class="tab-pane" id="settings">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $key => $item)
                                                                <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td> <img src="{{ asset($item->product_image) }}"
                                                    style="width:50px; height: 40px;"> </td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm add-product-btn"
                                                    data-product-id="{{ $item->id }}">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end settings content-->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->
</div> <!-- content -->





<script id="document-template" type="text/x-handlebars-template">
    <tr>
		<input type="text" name="product_id[]" value="@{{product_id}}">
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

<!-- // for custoemr previous_due_amount show -->


<script type="text/javascript">
    $(document).ready(function () {

        $('#customer_id').change(function () {
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
                        success: function (response) {
                            if (response.error) {
                                alert(response.error);
                                $('#previous_due_amount').val(0); // Default to 0 in case of error
                            } else {
                                $('#previous_due_amount').val(response.previous_due_amount || 0); // Display due amount
                            }
                        },
                        error: function () {
                            alert('Failed to fetch customer details. Please try again.');
                            $('#previous_due_amount').val(0); // Default to 0 on AJAX error
                        }
                    });
                }
            }
        });







        //start of multiple products fetch area
        $(document).on("click", ".addeventmore", function () {
            var product_id = $('#product_id').val();

            if (product_id == '') {
                alert('Please select a product first.');
                return;
            }

            $.ajax({
                url: "{{ route('get-product-details') }}",
                type: "GET",
                data: { product_id: product_id },
                success: function (productDetails) {
                    var data = {
                        product_id: productDetails.product_id,
                        product_code: productDetails.product_code,
                        product_name: $('#product_id option:selected').text(),
                        retail_sale: productDetails.retail_sale,
                    };

                    // Append a hidden input for product_id
                    var hiddenInput = `<input type="hidden" name="product_id[]" value="${data.product_id}" />`;
                    $('#productForm').append(hiddenInput);

                    // Generate and append product row
                    var source = $("#document-template").html();
                    var template = Handlebars.compile(source);
                    var html = template(data);
                    $("#addRow").append(html);

                    calculateTotal();
                },
                error: function () {
                    $.notify("Failed to fetch product details", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                }
            });
        });
        //end of multiple products fetch area




        $(document).on('click', '.remove', function () {
            $(this).closest('tr').remove();
            calculateTotal();
        });

        $(document).on('input', '.qty, .price, .transaction-type', function () {
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
            $('.total').each(function () {
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
            $('#total_amount').val(totalAmount.toFixed(2));  // Show total amount
            $('#return_amount').val(returnAmount.toFixed(2)); // Show return amount
            $('#payable_amount').val(payableAmount.toFixed(2));  // Show payable amount
            $('#due_amount').val(dueAmount.toFixed(2));      // Show due amount
        }



        $(document).on('input', '#percentage_discount, #flat_discount, #shipping, #labour, #paid_amount', function () {
            calculateTotal();
        });



    });


</script>

<script type="text/javascript">
    $(function () {
        $(document).on('change', '#product_id', function () {
            var product_id = $(this).val();
            $.ajax({
                url: "{{ route('check-product-stock') }}",
                type: "GET",
                data: { product_id: product_id },
                success: function (data) {
                    $('#current_stock_qty').val(data);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#employee_id').change(function () {
            // No action needed, value will be set automatically
        });

        // Check before form submission if the employee_id is empty
        $('form').submit(function () {
            if ($('#employee_id').val() === '') {
                $('#employee_id').val("{{ $loggedInUserId }}");  // Set to logged-in user ID
            }
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function () {
        // Direct Product List theke Add korar Functionality
        $(document).on('click', '.add-product-btn', function () {
            var productId = $(this).data('product-id'); // Product ID fetch kora
            addProductToTable(productId); // Product table e add korar function call
        });

        // Remove Product from Table
        $(document).on('click', '.remove', function () {
            $(this).closest('tr').remove(); // Row remove kora
            calculateTotal(); // Total amount update kora
        });

        // Fetch Product Details and Append to Table
        function addProductToTable(productId) {
            $.ajax({
                url: "{{ route('get-product-details') }}", // Route for fetching product details
                type: "GET",
                data: { product_id: productId },
                success: function (productDetails) {
                    // Product details table e append korbo
                    appendProductToTable(productDetails);
                },
                error: function () {
                    alert('Failed to fetch product details. Please try again.');
                }
            });
        }

        // Append Product to Table
        function appendProductToTable(productDetails) {
            var row = `
                <tr>
                    <td><input type="hidden" name="product_id[]" value="${productDetails.product_id}">${productDetails.product_id}</td>
                    <td>${productDetails.product_code}</td>
                    <td>${productDetails.name}</td>
                    <td><input type="number" name="quantity[]" class="form-control qty" min="1" value="1"></td>
                    <td><input type="number" name="price[]" class="form-control price" min="0" value="${productDetails.retail_sale}"></td>
                    <td><input type="number" name="total[]" class="form-control total" value="${productDetails.retail_sale}" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
                </tr>
            `;
            $('#addRow').append(row); // Table e row add kora
            calculateTotal(); // Total amount update kora
        }

        // Calculate Total Amount
        function calculateTotal() {
            var totalAmount = 0;
            $('.total').each(function () {
                var qty = parseFloat($(this).closest('tr').find('.qty').val()) || 0;
                var price = parseFloat($(this).closest('tr').find('.price').val()) || 0;
                totalAmount += qty * price;
            });
            $('#total_amount').val(totalAmount.toFixed(2)); // Total amount update kora
        }
    });
</script>

@endsection
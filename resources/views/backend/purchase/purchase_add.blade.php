@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <form method="POST" action="{{ route('purchase.store') }}">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Purchase Entry Page</h4><br><br>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="md-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input class="form-control" name="date" type="date" id="date">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-3">
                                        <label for="purchase_no" class="form-label">Purchase No</label>
                                        <input class="form-control" name="purchase_no" type="text" id="purchase_no">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-3">
                                        <label for="supplier_id" class="form-label">Supplier Name</label>
                                        <select name="supplier_id" id="supplier_id" class="form-select select2">
                                            <option selected="">Open this select menu</option>
                                            @foreach($supplier as $supp)
                                                <option value="{{ $supp->id }}">{{ $supp->shopname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-3">
                                        <label for="transaction_type" class="form-label">Transaction</label>
                                        <select class="form-select select2" name="transaction_type">
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

                                <div class="col-md-3">
                                    <div class="md-3">
                                        <label for="product_id" class="form-label">Product Name</label>
                                        <select name="product_id" id="product_id" class="form-select select2">
                                            <option selected="">Open this select menu</option>
                                            @foreach($product as $prod)
												<option value="{{ $prod->id }}">{{ $prod->name }} - {{ $prod->product_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                
                            </div> <!-- end row -->

                        </div>

                        <div class="card-body">
                            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        
                                        <th>Product Name</th>
                                        <th>Qty</th>
                                        <th>Expiry Date</th>
                                        <th>Buying Price</th>
                                        <th>Retail Price</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addRow" class="addRow">
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="7">Subtotal</td>
                                        <td><input type="text" name="subtotal" id="subtotal" class="form-control estimated_amount" readonly style="background-color: #ddd;"></td>
                                    </tr>
									<tr>
                                        <td colspan="7">Discount</td>
                                        <td><input type="text" name="discount_amount" id="discount_amount" class="form-control estimated_amount" placeholder="Discount Amount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Shipping</td>
                                        <td><input type="text" name="shipping" id="shipping" class="form-control estimated_amount" placeholder="Shipping Charge"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Payable</td>
                                        <td><input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control estimated_amount" readonly style="background-color: #ddd;"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Paid</td>
                                        <td><input type="text" name="paid_amount" id="paid_amount" class="form-control estimated_amount" placeholder="Paid Amount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Due</td>
                                        <td><input type="text" name="due_amount" id="due_amount" class="form-control estimated_amount" placeholder="Due Amount"></td>
                                    </tr>
                                </tbody>
                            </table><br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="storeButton"> Purchase Store</button>
								<button type="button" class="btn btn-rounded btn-danger" onclick="location.reload();">Cancel</button>
                            </div>
                    </form>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script id="document-template" type="text/x-handlebars-template">
<tr class="delete_add_more_item" id="delete_add_more_item">
    <input type="hidden" name="date" value="@{{date}}">
    <input type="hidden" name="purchase_no" value="@{{purchase_no}}">
    <input type="hidden" name="product_id[]" value="@{{product_id}}">

    <td>@{{ product_code }}</td>
    
    <td>@{{ product_name }}</td>
    <td><input type="number" min="1" class="form-control buying_qty text-right" name="buying_qty[]" value=""></td>
    <td><input type="date" class="form-control" name="expire_date[]" value=""></td>
    <td><input type="number" class="form-control buying_price" name="buying_price[]" value="@{{buying_price}}"></td>
    <td><input type="number" class="form-control retail_sale" name="retail_sale[]" value="@{{retail_sale}}"></td>
    <td><input type="number" class="form-control total_amount text-right" name="total_amount[]" value="0" readonly></td>
    <td><i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i></td>
</tr>
</script>

<script type="text/javascript">
$(document).ready(function(){
    var today = new Date().toISOString().split('T')[0];
    $('#date').val(today);

    function generatePurchaseNo() {
        return 'PN' + Date.now();
    }

    // Automatically add product to the table when selected
    $(document).on("change", "#product_id", function(){
        var date = $('#date').val();
        var purchase_no = $('#purchase_no').val();
        var product_id = $('#product_id').val();
        var product_name = $('#product_id option:selected').text();

        if(date === ''){
            $.notify("Date is Required", {globalPosition: 'top right', className: 'error'});
            return false;
        }

        if(purchase_no === ''){
            purchase_no = generatePurchaseNo();
            $('#purchase_no').val(purchase_no);
        }

        if(product_id === ''){
            $.notify("Product Field is Required", {globalPosition: 'top right', className: 'error'});
            return false;
        }

        $.ajax({
            url: "{{ route('get-product-details') }}",
            type: "GET",
            data: {product_id: product_id},
            success: function(productDetails) {
                var data = {
                    date: date,
                    purchase_no: purchase_no,
                    product_id: product_id,
                    product_name: product_name,
                    product_code: productDetails.product_code,
                    expire_date: '',
                    buying_price: productDetails.buying_price,
                    retail_sale: productDetails.retail_sale
                };

                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var html = template(data);
                $("#addRow").append(html);
                calculateTotal();
            }
        });
    });

    $(document).on("click", ".removeeventmore", function(event){
        $(this).closest(".delete_add_more_item").remove();
        calculateTotal();
    });

    $(document).on('keyup click', '.buying_price, .buying_qty, .retail_sale, #discount_amount, #shipping, #paid_amount', function(){
        calculateTotal();
    });

    function calculateTotal() {
        var sum = 0; // For subtotal of all products
        $('.buying_price').each(function() {
            var qty = $(this).closest('tr').find('.buying_qty').val();
            var total = $(this).val() * qty;
            $(this).closest('tr').find('.total_amount').val(total);
            sum += total; // Accumulate the product's total into the subtotal
        });

        // Display the subtotal in the respective field
        $('#subtotal').val(sum.toFixed(2));

        // Retrieve and calculate other fields
        var discount_amount = parseFloat($('#discount_amount').val()) || 0;
        var shipping = parseFloat($('#shipping').val()) || 0;
        var total_amount = sum - discount_amount + shipping; // Final total
        $('#estimated_amount').val(total_amount.toFixed(2));

        var paid_amount = parseFloat($('#paid_amount').val()) || 0;
        var due_amount = total_amount - paid_amount; // Calculate due
        $('#due_amount').val(due_amount.toFixed(2));
    }
});
</script>
@endsection

@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card mt-2">
               <form method="POST" action="{{ route('wholesale.store') }}" id="productForm">
                  @csrf
                  <div class="card-body row">
                     <div class="col-md-9">
                        <h4 class="card-title">Wholesale Entry Page</h4>
                        <br><br>
                        <div class="row">
                           <div class="col-md-2">
                              <div class="md-3">
                                 <label for="date" class="form-label">Date</label>
                                 <input class="form-control" name="date" type="date" id="date" value="{{ $date }}">
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="md-3">
                                 <label for="example-text-input" class="form-label">Inv No</label>
                                 <input class="form-control example-date-input" name="invoice_no" type="text" value="{{ $invoice_no }}"  id="invoice_no" readonly style="background-color:#ddd" >
                              </div>
                           </div>
							<div class="col-md-3">
                                        <div class="md-3">
                                            <label for="customer_id" class="form-label">Customer Name</label>
                                            <select name="customer_id" id="customer_id" class="form-select select2">
                                                <option value="">Select Customer </option>
                                                <option value="0">New Customer </option>
                                                @foreach($customer as $cus)
                                                    <option value="{{ $cus->id }}">{{ $cus->name }} - {{ $cus->mobile_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                            </div>
							

                           <div class="row new_customer mt-3" style="display: none; background-color:#ddd">
                              <div class="col-md-4 mb-3">
                                 <label for="shopname" class="form-label">Shop Name</label>
                                 <input type="text" name="shopname" id="shopname" class="form-control">
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label for="name" class="form-label">Name</label>
                                 <input type="text" name="name" id="name" class="form-control">
                              </div>
                              <div class="col-md-4 mb-3">
                                 <label for="mobile_no" class="form-label">Mobile No</label>
                                 <input type="text" name="mobile_no" id="mobile_no" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="md-3">
                                 <label for="product_id" class="form-label">Product Name</label>
                                 <select name="product_name" id="product_id" class="form-select select2">
                                    <option selected="">Open this select menu</option>
                                    @foreach($product as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->name }} - {{ $prod->product_code }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="md-3">
                                 <label for="example-text-input" class="form-label">Stock(Pic/Kg)</label>
                                 <input class="form-control example-date-input" name="current_stock_qty" type="text"  id="current_stock_qty" readonly style="background-color:#ddd" >
                              </div>
                           </div>
                           
                        </div>
                        <!-- end row -->
                        <div class="row mt-3">
                           <div class="col-md-12">
                              <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">
                                 <thead>
                                    <tr>
                                       <th>Type</th>
                                       <th>Product code</th>
                                       <th>Product name</th>
                                       <th>Qty</th>
                                       <th>Wholesale price</th>
                                       <th>Total</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody id="addRow" class="addRow"></tbody>
                              </table>
                              <div class="row mt-3">
                                 <div class="col-md-4">
                                    <div class="input-group">
                                       <span class="input-group-text" id="basic-addon1">Comment</span>
                                       <input type="text" class="form-control" name="comment" id="comment" aria-label="Comment" aria-describedby="basic-addon1">
                                    </div>
                                 </div>
                                 @php
                                 $loggedInUserId = Auth::id();  // Get the logged-in user ID
                                 $loggedInUserName = Auth::user()->name;  // Get the logged-in user name
                                 @endphp
                                 <div class="col-md-4">
                                    <div class="input-group">
                                       <span class="input-group-text" id="basic-addon1">Sales Man</span>
                                       <select class="form-select" name="employee_id" id="employee_id" aria-label="Salesman">
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
                                       <span class="input-group-text" id="basic-addon1">Status</span>
                                       <select class="form-select" name="status" id="floatingSelectGrid" aria-label="Floating label select example">
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
                              <input type="text" class="form-control" name="total_amount" id="total_amount" aria-label="Total" aria-describedby="basic-addon1" readonly style="background-color: #ddd;">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Return</span>
                              <input type="text" class="form-control return" name="return_amount" id="return_amount" aria-label="Return" aria-describedby="basic-addon1" readonly style="background-color: #ddd;">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Discount</span>
                              <input type="text" class="form-control" name="percentage_discount" id="percentage_discount" placeholder="%" aria-describedby="basic-addon1">
                              <input type="text" class="form-control" name="flat_discount" id="flat_discount" placeholder="Flat Discount">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Shipping</span>
                              <input type="text" class="form-control" name="shipping" id="shipping" aria-describedby="basic-addon1">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Labour</span>
                              <input type="text" class="form-control" name="labour" id="labour" aria-describedby="basic-addon1">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Payable Amount</span>
                              <input type="text" class="form-control" name="payable_amount" id="payable_amount" aria-describedby="basic-addon1">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Paid Amount</span>
                              <input type="text" class="form-control" name="paid_amount" id="paid_amount" aria-describedby="basic-addon1">
                           </div>
                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Due Amount</span>
                              <input type="text" class="form-control" name="due_amount" id="due_amount" aria-describedby="basic-addon1" readonly style="background-color: #ddd;">
                           </div>

                           <!-- // for custoemr previous_due_amount show -->
                        <div class="input-group mt-3">
                           <span class="input-group-text" id="basic-addon1">Previous Due</span>
                           <input type="text" class="form-control" name="previous_due_amount" id="previous_due_amount" 
                                 readonly style="background-color: #ddd;" value="0">
                        </div>






                           <div class="input-group mt-3">
                              <span class="input-group-text" id="basic-addon1">Transaction</span>
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
                                 <button type="submit" class="btn btn-info btn-rounded waves-effect waves-light">Save Changes</button>
                                 <button type="button" class="btn btn-rounded btn-danger" onclick="location.reload();">Cancel</button>
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
        <input type="hidden" name="product_id[]" value="@{{product_id}}" />
        <td>
            <select name="type[]" class="form-select transaction-type">
                <option value="sale" selected>Sale</option>
                <option value="return">Return</option>
            </select>
        </td>
        <td><input type="text" name="product_code[]" class="form-control" value="@{{product_code}}" readonly></td>
        <td><input type="text" name="product_name[]" class="form-control" value="@{{product_name}}" readonly></td>
        <td><input type="number" name="quantity[]" class="form-control qty" min="1" value="1"></td>
        <td><input type="number" name="price[]" class="form-control price" min="0" value="@{{wholesale}}"></td>
        <td><input type="number" name="total[]" class="form-control total" value="@{{wholesale}}" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
    </tr>
</script>




 <!-- // for custoemr previous_due_amount show -->


<script type="text/javascript">
    $(document).ready(function() {
        
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


    // Automatically add product to the table when selected
 $(document).on("change", "#product_id", function() {
    var product_id = $('#product_id').val();

    if (product_id == '') {
        alert('Please select a product first.');
        return;
    }

    $.ajax({
        url: "{{ route('get-product-details') }}",
        type: "GET",
        data: { product_id: product_id },
        success: function(productDetails) {
            var data = {
                product_id: productDetails.product_id,
                product_code: productDetails.product_code,
                product_name: $('#product_id option:selected').text(),
                wholesale: productDetails.wholesale,
            };

            // Generate and append product row
            var source = $("#document-template").html();
            var template = Handlebars.compile(source);
            var html = template(data);
            $("#addRow").append(html);

            calculateTotal();
        },
        error: function() {
            alert('Failed to fetch product details.');
        }
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

		// Calculate percentage discount first
		var discountFromPercentage = (totalAmount * percentageDiscount / 100);

		// Apply flat discount after percentage discount
		var totalDiscount = discountFromPercentage + flatDiscount;

		var shipping = parseFloat($('#shipping').val()) || 0;
		var labour = parseFloat($('#labour').val()) || 0;
		var previousDue = parseFloat($('#previous_due_amount').val()) || 0;
		var paidAmount = parseFloat($('#paid_amount').val()) || 0;

		// Correctly calculate payableAmount with returnAmount subtracted
		var payableAmount = totalAmount - returnAmount - totalDiscount + shipping + labour;
		var dueAmount = payableAmount - paidAmount;

		// Set the values in the fields
		$('#total_amount').val(totalAmount.toFixed(2));  // Show total amount
		$('#return_amount').val(returnAmount.toFixed(2)); // Show return amount
		$('#payable_amount').val(payableAmount.toFixed(2));  // Show payable amount
		$('#due_amount').val(dueAmount.toFixed(2));      // Show due amount
	}



        $(document).on('input', '#percentage_discount, #flat_discount, #shipping, #labour, #paid_amount', function(){
            calculateTotal();
        });



    });


</script>

<script type="text/javascript">
    $(function(){
        $(document).on('change','#product_id',function(){
            var product_id = $(this).val();
            $.ajax({
                url:"{{ route('check-product-stock') }}",
                type: "GET",
                data:{product_id:product_id},
                success:function(data){                   
                    $('#current_stock_qty').val(data);
                }
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
            $('#employee_id').val("{{ $loggedInUserId }}");  // Set to logged-in user ID
        }
    });
});

</script>


@endsection

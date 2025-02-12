@extends('admin_dashboard')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <div class="page-content">
                    <div class="container-fluid">

                        
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
				<h4 class="mb-sm-0">Supplier and Product Wise Report </h4>
 
    <div class="row">
        <div class="col-md-12 text-center mt-3">
            <strong> Supplier Wise Report </strong>
            <input type="radio" name="supplier_product_wise" value="supplier_wise" class="search_value"> &nbsp;&nbsp;


            <strong> Product Wise Report </strong>
            <input type="radio" name="supplier_product_wise" value="product_wise" class="search_value">


        </div>        
    </div> <!-- // end row  -->
 </div>
 <div class="card-body">
<!--  /// Supplier Wise  -->
    <div class="show_supplier" style="display:none">
        <form method="GET" action="{{ route('supplier.wise.pdf') }}" id="myForm" target="_blank" >
			
		<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					
					<label for="supplier_id" class="form-label">Supplier Name:</label>
					<select name="supplier_id" class="form-select select2" style="width: 80% !important;">

					<option selected="">Select Supplier</option>
					@foreach($supppliers as $supp)
					<option value="{{ $supp->id }}">{{ $supp->name }}</option>
				   @endforeach
					</select>
					<button type="submit" class="btn btn-primary ">Search</button>
				</div>
				
				<div class="col-md-2"></div>
			
			
		</div>
            
            
        </form>
		

        
    </div>
<!--  /// End Supplier Wise  -->

<!--  /// Product Wise  -->
 <div class="show_product" style="display:none; ">
        <form method="GET" action="{{ route('product.wise.pdf') }}" id="myForm" target="_blank" >

            <div class="row">

               <div class="col-md-5">
					
						<label for="example-text-input" class="form-label">Category Name: </label>
						<select name="category_id" id="category_id" class="form-select select2" style="width: 80% !important;">
						<option selected="">Open this select menu</option>
						  @foreach($category as $cat)
						<option value="{{ $cat->id }}">{{ $cat->name }}</option>
					   @endforeach
						</select>
					
				</div>


				<div class="col-md-5">
					
						<label for="example-text-input" class="form-label">Product Name: </label>
						<select name="product_id" id="product_id" class="form-select select2" style="width: 80% !important;">
						<option selected="">Open this select menu</option>
					   
						</select>
					
				</div>

                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                
            </div>
            
        </form>
        
    </div>
<!--  /// End Product Wise  -->




                    
        
                                    
                                </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        
                     
                        
                    </div> <!-- container-fluid -->
                </div>

<script type="text/javascript">
    $(function(){
        $(document).on('change','#category_id',function(){
            var category_id = $(this).val();
            $.ajax({
                url:"{{ route('get-product') }}",
                type: "GET",
                data:{category_id:category_id},
                success:function(data){
                    var html = '<option value="">Select Category</option>';
                    $.each(data,function(key,v){
                        html += '<option value=" '+v.id+' "> '+v.name+'</option>';
                    });
                    $('#product_id').html(html);
                }
            })
        });
    });

</script>


<script type="text/javascript">
    $(document).on('change','.search_value', function(){
        var search_value = $(this).val();
        if (search_value == 'supplier_wise') {
            $('.show_supplier').show();
        }else{
            $('.show_supplier').hide();
        }
    }); 

</script>


<script type="text/javascript">
    $(document).on('change','.search_value', function(){
        var search_value = $(this).val();
        if (search_value == 'product_wise') {
            $('.show_product').show();
        }else{
            $('.show_product').hide();
        }
    }); 

</script>



 <script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                supplier_id: {
                    required : true,
                }, 
                  
            },
            messages :{
                supplier_id: {
                    required : 'Please Select Supplier ',
                },
                
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
 

@endsection
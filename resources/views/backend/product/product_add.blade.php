@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card mt-3">
					<div class="card-body">

						<h4 class="card-title">Product Entry Page </h4><br><br>

						<form method="post" action="{{ route('product.store') }}" id="myForm" enctype="multipart/form-data">
							@csrf

							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
										<div class="col-sm-10">
											<input name="name" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label class="col-sm-2 col-form-label">Supplier Name </label>
										<div class="col-sm-10">
											<select name="supplier_id" class="form-select" aria-label="Default select example">
												<option selected="">Open this select menu</option>
												@foreach($supplier as $supp)
												<option value="{{ $supp->id }}">{{ $supp->name }}</option>
											   @endforeach
											</select>
										</div>
									</div>
								</div>
								<!-- end row --> 
								
								<div class="col-md-6">
									<div class="row">
										<label class="col-sm-2 col-form-label">Unit Name </label>
										<div class="col-sm-10">
											<select name="unit_id" class="form-select" aria-label="Default select example">
												<option selected="">Open this select menu</option>
												@foreach($unit as $uni)
												<option value="{{ $uni->id }}">{{ $uni->name }}</option>
											   @endforeach
											</select>
										</div>
									</div>
								</div>
								<!-- end row --> 
								
								<div class="col-md-6">
									<div class="row">
										<label class="col-sm-2 col-form-label">Category Name </label>
										<div class="col-sm-10">
											<select name="category_id" class="form-select" aria-label="Default select example">
												<option selected="">Open this select menu</option>
												@foreach($category as $cat)
												<option value="{{ $cat->id }}">{{ $cat->name }}</option>
											   @endforeach
											</select>
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Product Code</label>
										<div class="col-sm-10">
											<input name="product_code" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								
								<!-- end row -->
								
								<div class="col-md-6 mb-3">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Buying Date</label>
										<div class="col-sm-10">
											<input name="buying_date" class="form-control" type="date"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6 mb-3">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Expire Date</label>
										<div class="col-sm-10">
											<input name="expire_date" class="form-control" type="date"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Buying Price</label>
										<div class="col-sm-10">
											<input name="buying_price" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row mb-3">
										<label for="example-text-input" class="col-sm-2 col-form-label">Retail Sale</label>
										<div class="col-sm-10">
											<input name="retail_sale" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Wholesale</label>
										<div class="col-sm-10">
											<input name="wholesale" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Quantity</label>
										<div class="col-sm-10">
											<input name="quantity" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Product Image </label>
										<div class="col-sm-10">
										<input name="product_image" class="form-control" type="file"  id="image">
										</div>
									</div>
									

									<div class="row">
										<label for="example-fileinput" class="form-label col-sm-2"> </label>
										<img id="showImage" src="{{  url('upload/no_image.jpg') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
									</div>
								</div>
								<!-- end row -->

								<div class="text-end">
									<input type="submit" class="btn btn-info waves-effect waves-light" value="Save">
								</div>
							</div>	
						</form>
	
					</div>
				</div> <!-- end col -->
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
				buying_price: {
                    required : true,
                }, 
                 supplier_id: {
                    required : true,
                },
                 unit_id: {
                    required : true,
                },
                 category_id: {
                    required : true,
                },
            },
            messages :{
                name: {
                    required : 'Please Enter Your Product Name',
                },
				buying_price: {
                    required : 'Please Enter Your Buying Price',
                },
                supplier_id: {
                    required : 'Please Select One Supplier',
                },
                unit_id: {
                    required : 'Please Select One Unit',
                },
                category_id: {
                    required : 'Please Select One Category',
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

<script type="text/javascript">
	
	$(document).ready(function(){
		$('#image').change(function(e){
			var reader = new FileReader();
			reader.onload =  function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});
</script>



@endsection 
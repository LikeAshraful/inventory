@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card mt-3">
					<div class="card-body">

						<h4 class="card-title">Customer Entry Page </h4><br><br>

						<form method="post" action="{{ route('customer.store') }}" id="myForm" enctype="multipart/form-data">
							@csrf

							<div class="row">
								<div class="col-md-6">
									<div class="row ">
										<label for="example-text-input" class="col-sm-2 col-form-label">Customer Shop Name</label>
										<div class="col-sm-10">
											<input name="shopname" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row ">
										<label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
										<div class="col-sm-10">
											<input name="name" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->

								<div class="col-md-6">
									<div class="row mb-3">
										<label for="example-text-input" class="col-sm-2 col-form-label">Email </label>
										<div class="col-sm-10">
											<input name="email" class="form-control" type="email">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row mb-3">
										<label for="example-text-input" class="col-sm-2 col-form-label">Phone</label>
										<div class="col-sm-10">
											<input name="mobile_no" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row mb-3">
										<label for="example-text-input" class="col-sm-2 col-form-label">NID</label>
										<div class="col-sm-10">
											<input name="nid" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								

								<div class="col-md-6">
									<div class="row mb-3">
										<label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
										<div class="col-sm-10">
											<input name="address" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row ">
										<label for="example-text-input" class="col-sm-2 col-form-label">Opening Balance</label>
										<div class="col-sm-10">
											<input name="previous_due_amount" class="form-control" type="text"  >
										</div>
									</div>
								</div>
								<!-- end row -->
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Customer Image </label>
										<div class="form-group col-sm-10">
										<input name="customer_image" class="form-control" type="file"  id="image">
										</div>
									</div>
									

									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">  </label>
										<div class="col-sm-10">
											<img id="showImage" class="rounded avatar-lg" src="{{  url('upload/no_image.jpg') }}" alt="Card image cap">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row mb-3">
										<label for="example-textarea" class="col-sm-2 col-form-label">Note</label>
										<div class="col-sm-10">
											<textarea class="form-control" name="note" id="example-textarea" rows="5"></textarea>
										</div>
									</div>
								</div>
								
								
								<!-- end row -->
								
								
								
								<div class="text-end">
									<input type="submit" class="btn btn-info waves-effect waves-light" value="Save">
								</div>
							</div>
						</form>

					</div>
				</div>
			</div> <!-- end col -->
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                shopname: {
                    required : true,
                },
				name: {
                    required : true,
                }, 
                 mobile_no: {
                    required : true,
                },
                 address: {
                    required : true,
                },
            },
            messages :{
                shopname: {
                    required : 'Please Enter Your Shop Name',
                },
				name: {
                    required : 'Please Enter Your Name',
                },
                mobile_no: {
                    required : 'Please Enter Your Mobile Number',
                },
                address: {
                    required : 'Please Enter Your Address',
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
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection 
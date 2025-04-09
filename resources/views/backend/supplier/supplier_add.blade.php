@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card mt-3">
					<div class="card-body">

						<h4 class="card-title">Supplier Entry Page </h4><br><br>

						<form method="post" action="{{ route('supplier.store') }}" id="myForm">
							@csrf

							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<label for="shopname" class="col-sm-2 col-form-label">Supplier Shop Name</label>
										<div class="col-sm-10">
											<input name="shopname" id="shopname" class="form-control" type="text"    >
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row">
										<label for="name" class="col-sm-2 col-form-label">Name</label>
										<div class="col-sm-10">
											<input name="name" id="name" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->

								<div class="col-md-6">
									<div class="row mb-3">
										<label for="email" class="col-sm-2 col-form-label">Email </label>
										<div class="col-sm-10">
											<input name="email" id="email" class="form-control" type="email">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row mb-3">
										<label for="mobile_no" class="col-sm-2 col-form-label">Phone</label>
										<div class="col-sm-10">
											<input name="mobile_no" id="mobile_no" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->

								<div class="col-md-6">
									<div class="row mb-3">
										<label for="address" class="col-sm-2 col-form-label">Address</label>
										<div class="col-sm-10">
											<input name="address" id="address" class="form-control" type="text">
										</div>
									</div>
								</div>
								<!-- end row -->
								
								<div class="col-md-6">
									<div class="row mb-3">
										<label for="balance" class="col-sm-2 col-form-label">Opening Balance</label>
										<div class="col-sm-10">
											<input name="balance" id="balance" class="form-control" type="text"  >
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

@endsection 
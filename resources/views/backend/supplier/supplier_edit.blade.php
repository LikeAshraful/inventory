@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">

						<h4 class="card-title">Supplier Edit Page </h4><br><br>

						<form method="post" action="{{ route('supplier.update') }}" id="myForm">
							@csrf
							
							<input type="hidden" name="id" value="{{ $supplier->id }}">
							
							<div class="row mb-3">
								<label for="example-text-input" class="col-sm-2 col-form-label">Supplier Shop Name</label>
								<div class="col-sm-10">
									<input name="shopname" class="form-control" type="text"  value="{{ $supplier->shopname }}">
								</div>
							</div>
							<!-- end row -->
							
							<div class="row mb-3">
								<label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
								<div class="col-sm-10">
									<input name="name" class="form-control" value="{{ $supplier->name }}" type="text">
								</div>
							</div>
							<!-- end row -->


							<div class="row mb-3">
								<label for="example-text-input" class="col-sm-2 col-form-label">Email </label>
								<div class="col-sm-10">
									<input name="email" class="form-control" type="email" value="{{ $supplier->email }}">
								</div>
							</div>
							<!-- end row -->
							
							<div class="row mb-3">
								<label for="example-text-input" class="col-sm-2 col-form-label">Phone</label>
								<div class="col-sm-10">
									<input name="mobile_no" class="form-control" type="text" value="{{ $supplier->mobile_no }}">
								</div>
							</div>
							<!-- end row -->


							<div class="row mb-3">
								<label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
								<div class="col-sm-10">
									<input name="address" class="form-control" type="text" value="{{ $supplier->address }}">
								</div>
							</div>
							<!-- end row -->
							
							<div class="row mb-3">
								<label for="example-text-input" class="col-sm-2 col-form-label">Opening Balance</label>
								<div class="col-sm-10">
									<input name="balance" class="form-control" type="text" value="{{ $supplier->balance }}" >
								</div>
							</div>
							<!-- end row -->
							
							<div class="text-end">
								<input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
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
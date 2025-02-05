@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card mt-3">
					<div class="card-body">

						<h4 class="card-title">Category Edit Page </h4><br><br>

						 <form method="post" action="{{ route('category.update') }}" id="myForm" >
							@csrf

							<input type="hidden" name="id" value="{{ $category->id }}">
							
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
										<div class="col-sm-10">
											<input name="name" class="form-control" type="text"  value="{{ $category->name }}"  >
										</div>
									</div>
								</div>
								<!-- end row --> 

								<div class="text-end">
									<input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
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
                 
            },
            messages :{
                name: {
                    required : 'Please Enter Your Name',
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
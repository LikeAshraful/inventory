@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-xl-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="card-title">Edit Employee</h4><br><br>

                        <div class="tab-pane" id="settings">
                            <form method="post" action="{{ route('employee.update', $employee->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <!-- Other form fields -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Employee Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $employee->name }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Employee Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Employee Phone</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $employee->phone }}">
                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Employee Address</label>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $employee->address }}">
                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="experience" class="form-label">Employee Experience</label>
                                            <select name="experience" class="form-select" id="example-select">
                                                <option value="">Select Year</option>
                                                <option value="1 Year" {{ $employee->experience == '1 Year' ? 'selected' : '' }}>1 Year</option>
                                                <option value="2 Year" {{ $employee->experience == '2 Year' ? 'selected' : '' }}>2 Year</option>
                                                <option value="3 Year" {{ $employee->experience == '3 Year' ? 'selected' : '' }}>3 Year</option>
                                                <option value="4 Year" {{ $employee->experience == '4 Year' ? 'selected' : '' }}>4 Year</option>
                                                <option value="5 Year" {{ $employee->experience == '5 Year' ? 'selected' : '' }}>5 Year</option>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="col-md-6">
										<div class="mb-3">
											<label for="firstname" class="form-label">Employee Salary    </label>
											<input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ $employee->salary }}"   >
												@error('salary')
												<span class="text-danger"> {{ $message }} </span>
												@enderror
										</div>
									</div>

									<div class="col-md-6">
										<div class="mb-3">
											<label for="firstname" class="form-label">Employee Vacation    </label>
											<input type="text" name="vacation" class="form-control"  value="{{ $employee->vacation }}"   >
												
										</div>
									</div>									

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="example-fileinput" class="form-label">Employee Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>

									<div class="col-md-6"></div>
                                    
									<div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="example-fileinput" class="form-label"></label>
                                            <img id="showImage" src="{{  asset($employee->image) }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                        </div>
                                    </div>
<!-- end col -->
                                                    </div> <!-- end row -->
													
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end settings content-->
                                    </div>
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->

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

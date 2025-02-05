@extends('admin_dashboard')
@section('admin')

 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">                       
		<div class="row">
			<div class="col-12">
				<div class="card mt-3">
					<div class="card-body">
						<div style="padding-bottom:40px;">
						<a href="{{ route('add.employee') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"> Add Employee </a> 
						<h4 class="header-title">All Employee</h4>
						</div>
						<table id="basic-datatable" class="table dt-responsive nowrap w-100">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Image</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Salary</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
							@foreach($employee as $key=> $item)
							<tr>
								<td>{{ $key+1 }}</td>
								<td> <img src="{{ asset($item->image) }}" style="width:50px; height: 40px;"> </td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->email }}</td>
								<td>{{ $item->phone }}</td>
								<td>{{ $item->salary }}</td>
								<td>
							<a href="{{ route('edit.employee',$item->id) }}" class="btn btn-blue rounded-pill waves-effect waves-light">Edit</a>
							<a href="{{ route('delete.employee',$item->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light">Delete</a>

								</td>
							</tr>
							@endforeach
							</tbody>
						</table>

					</div> <!-- end card body-->
				</div> <!-- end card -->
			</div><!-- end col-->
		</div>
		<!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->


@endsection 
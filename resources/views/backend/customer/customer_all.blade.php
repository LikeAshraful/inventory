@extends('admin_dashboard')
@section('admin')


				<div class="page-content">
                    <div class="container-fluid">

						<div class="row">
							<div class="col-12">
								<div class="card mt-3">
									<div class="card-body">

										<a href="{{ route('customer.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Customer </a> <br>  <br>               

										<h4 class="card-title page-title">Customer All Data </h4>

										<table id="basic-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
											<thead>
												<tr>
													<th>Sl</th>
													<th>Shop Name</th>
													<th>Name</th>
													<th>Email</th>
													<th>Phone</th>
													<th>Address</th>
													<th>Balance</th>
													<th>Action</th>
												</tr>	
											</thead>


											<tbody>

											@foreach($customers as $key => $item)
											<tr>
												<td> {{ $key+1}} </td>
												<td> {{ $item->shopname }} </td> 
												<td> {{ $item->name }} </td> 
												<td> {{ $item->email }} </td>
												<td> {{ $item->mobile_no }} </td> 												
												<td> {{ $item->address }} </td> 
												<td> {{ $item->previous_due_amount }} </td> 
												<td>
													<a href=" {{ route('customer.edit',$item->id) }} " class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>
													<a href=" {{ route('customer.delete',$item->id) }} " class="btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>
												</td>
											</tr>
											@endforeach

											</tbody>
										</table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>


@endsection
@extends('admin_dashboard')
@section('admin')


				<div class="page-content">
                    <div class="container-fluid">

						<div class="row">
							<div class="col-12">
								<div class="card mt-3">
									<div class="card-body">
										<a href="{{ route('damage.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Damaged/Lost Product</a> <br>  <br>
										<h4 class="card-title page-title">Damaged/Lost All Data </h4>
											<table id="basic-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<thead>
													<tr>
														<th>Product Code</th>
														<th>Product Name</th>
														<th>Product In</th>
														<th>Product Out</th>
														<th>Reason</th>
														<th>Date</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>
													@foreach($damages as $damage)
													<tr>
														<td>{{ $damage->product->product_code }}</td>
														<td>{{ $damage->product->name }}</td>
														<td>{{ $damage->product_in }}</td>
														<td>{{ $damage->product_out }}</td>
														<td>{{ $damage->reasons }}</td>
														<td>{{ $damage->date }}</td>
														<td>
															
															<a href=" {{ route('damage.edit', $damage->id) }} " class="btn btn-info sm" title="Edit Data"><i class="fa fa-pencil" aria-hidden="true"></i></a>
															<a href="{{ route('damage.delete', $damage->id) }}" class="btn btn-danger sm" title="Delete Data" id="delete"><i class="fas fa-trash-alt"></i></a>
															
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


@endsection

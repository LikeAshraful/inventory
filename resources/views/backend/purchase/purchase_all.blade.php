@extends('admin_dashboard')
@section('admin')


				<div class="page-content">
                    <div class="container-fluid">

						<div class="row">
							<div class="col-12">
								<div class="card mt-3">
									<div class="card-body">

										

										<a href="{{ route('purchase.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Purhase </a> <br>  <br>               
										
										<h4 class="card-title page-title">Purhase All Data </h4>

										<table id="basic-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
											<thead>
												<tr>
													<th>Sl</th>
													<th>Purhase No</th> 
													<th>Date </th>
													<th>Supplier</th>
													<th>Phone</th> 
													<th>Total</th> 
													<th>Paid</th>
													<th>Due</th>
													<th>Action</th>

											</thead>

											<tbody>

												@foreach($allData as $key => $item)
													<tr>
														<td>{{ $key+1 }}</td>
														<td>{{ $item->purchase_no }}</td>
														<td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
														<td>{{ optional($item->supplier)->shopname }}</td>
														<td>{{ optional($item->supplier)->mobile_no }}</td>
														<td>{{ $item->estimated_amount }}</td>
														<td>{{ $item->paid_amount }}</td>
														<td>{{ $item->due_amount }}</td>
														
														<td>
															<a href="{{ route('purchase.delete', $item->id) }}" class="btn btn-danger sm" title="Delete Data" id="delete"><i class="fas fa-trash-alt"></i></a>
															
															<a href=" {{ route('purchase.edit',$item->id) }} " class="btn btn-info sm" title="Edit Data"><i class="fa fa-pencil" aria-hidden="true"></i></a>
														
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
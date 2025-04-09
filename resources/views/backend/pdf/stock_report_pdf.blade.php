@extends('admin_dashboard')
@section('admin')

					<div class="page-content">
						<div class="container-fluid">
							<div class="row">
								<div class="col-12">
									<div class="card mt-2">
										<div class="card-body">
											<!-- Logo & title -->
											<div class="clearfix" style="padding-left: 20px;padding-right: 20px;">
												<div class="d-flex justify-content-between align-items-center">
													<div class="auth-logo">
														<div class="logo logo-dark">
															<span class="logo-lg">
																<img src="{{ asset('backend/assets/images/logo.png') }}" alt="" height="100">
															</span>
														</div>
														<div class="logo logo-light">
															<span class="logo-lg">
																<img src="{{ asset('backend/assets/images/logo.png') }}" alt="" height="22">
															</span>
														</div>
													</div>

													<div class="text-center">
														<h2 class="m-0 d-print-none">Al-faruk sleeping bag</h2>
														<h4 class="font-size-16">
															<strong>Stock Report</strong>
														</h4>
													</div>

													<div class="text-center"></div>
												</div>
											</div>

											<div class="row" style="padding-left: 20px;padding-right: 20px;">
												<hr style="border: 1px solid #000;">
												<div class="col-md-12"></div>
											</div>
											<div class="row">
												<div class="col-12">
													<div>
														<div class="">
															<div class="table-responsive">
																<table class="table">
																		<thead style="background-color:#000;color:#fff">
																		<tr>
																			<th>Sl</th>
																			<th>Category</th> 
																			<th>Product Name</th>  
																			<th>Barcode</th>  
																			<th>Buying Price</th>
																			<th>Selling Price</th>  
																			<th>Stock </th>

																		</thead>

																		<tbody>

																			@foreach($allData as $key => $item)
																		<tr>
																			<td> {{ $key+1}} </td>
																			<td> {{ $item['category']['name'] }} </td> 
																			<td> {{ $item->name }} </td> 
																			<td> {{ $item->product_code }} </td> 
																			<td>{{ $item->buying_price }}</td>
																			<td>{{ $item->retail_sale }}</td>
																			<td> {{ $item->quantity }} </td> 
																		</tr>
																		@endforeach

																		</tbody>
																</table>
															</div>

															@php
															$date = new DateTime('now', new DateTimeZone('Asia/Dhaka')); 
															@endphp         
															<i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>   

															<div class="d-print-none">
																<div class="float-end">
																	<a href="{{ route('stock.report') }}" class="btn btn-secondary waves-effect">Go Back</a>
																	<a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
																	<a href="#" class="btn btn-primary waves-effect waves-light">Download</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div> <!-- end row -->
										</div>
									</div>
								</div> <!-- end col -->
							</div> <!-- end row -->
						</div> <!-- container-fluid -->
					</div>


@endsection
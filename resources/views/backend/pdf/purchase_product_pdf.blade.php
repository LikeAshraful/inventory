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
															<img src="{{asset('backend/assets/images/logo.png')}}" alt="" height="100">
														</span>
													</div>

													<div class="logo logo-light">
														<span class="logo-lg">
															<img src="{{asset('backend/assets/images/logo.png')}}" alt="" height="22">
														</span>
													</div>
												</div>

												<div class="text-center">
													<h2 class="m-0 d-print-none">Al-faruk sleeping bag</h2>
													<h4 class="font-size-16">
													<strong>Purchase Product Report 
														<span class="btn btn-info"> {{ date('d-m-Y',strtotime($start_date)) }} </span> -
														<span class="btn btn-success"> {{ date('d-m-Y',strtotime($end_date)) }} </span>
													</strong>
													</h4>
												</div>

												<div class="text-center">
													
												</div>
											</div>

                                        </div>
										
										<div class="row" style="padding-left: 20px;padding-right: 20px;">
											<hr style="border: 1px solid #000; ">
												<div class="col-md-12"></div>
												<!-- end col -->
                                        </div>
                                        <!-- end row -->

										<div class="row">
											<div class="col-12">
												<div>
													
														<div class="">
															<div class="table-responsive">
																<table class="table">
																	<thead style="background-color:#000;color:#fff">
																	<tr>
																		<td><strong>Sl </strong></td>
																		<td class="text-center"><strong>Invoice No  </strong></td>
																		<td class="text-center"><strong>Date</strong></td>
																		<td class="text-center"><strong>Barcode</strong></td>
																		<td class="text-center"><strong>product Name </strong></td>
																		<td class="text-center"><strong>Quantity</strong></td>
																		<td class="text-center"><strong>Buying Price</strong></td>
																		<td class="text-center"><strong>Total</strong></td>
																	</tr>
																	</thead>
																	<tbody>
																		@php
																			$total_sum = 0; // Initialize total sum for invoice amounts
																		@endphp

																		@foreach($allData as $key => $purchase)
																			@foreach($purchase->purchaseDetails as $detail)
																				@php
																					$total_sum += $detail->total_amount; // Add to the total invoice sum
																				@endphp

																				<tr>
																					<td class="text-center">{{ $key + 1 }}</td>
																					<td class="text-center">#{{ $purchase->purchase_no }}</td>
																					<td class="text-center">{{ date('d-m-Y', strtotime($purchase->date)) }}</td>
																					<td class="text-center">{{ $detail->product->product_code }}</td> <!-- Access product through detail -->
																					<td class="text-center">{{ $detail->product->name }}</td> <!-- Access product through detail -->
																					<td class="text-center">{{ $detail->buying_qty }}</td>
																					<td class="text-center">{{ $detail->buying_price }}</td>
																					<td class="text-center">{{ $detail->total_amount }}</td>
																				</tr>
																			@endforeach
																		@endforeach

																	<!-- Display the grand totals -->
																	<tr>
																		
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line text-center">
																			<strong>Total:</strong>
																		</td>
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_sum }}</h4></td>
																	</tr>
																	</tbody>
																</table>
															</div>

															<div class="mt-4 mb-1">
																<div class="text-end d-print-none">
																	<a href="{{ route('purchase.add') }}" class="btn btn-secondary waves-effect">Go Back</a>
																	<a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print</a>
																	<a href="#" class="btn btn-info waves-effect waves-light">Download</a>
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
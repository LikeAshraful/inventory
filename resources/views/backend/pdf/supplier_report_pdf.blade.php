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
													<strong>Supplier Invoice Report 
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
																		<td class="text-center"><strong>Supplier Name </strong></td>
																		<td class="text-center"><strong>Phone</strong></td>
																		<td class="text-center"><strong>Total</strong></td>
																		<td class="text-center"><strong>Commission</strong></td>
																		<td class="text-center"><strong>Shipping</strong></td>
																		<td class="text-center"><strong>Payable</strong></td>
																		<td class="text-center"><strong>paid</strong></td>
																		<td class="text-center"><strong>Due</strong></td>
																	</tr>
																	</thead>
																	<tbody>
																		@php
																			$total_sum = 0; // Initialize total sum for invoice amounts
																			
																			$total_discount_amount = 0; // Initialize total sum for percentage discount
																			
																			$total_shipping = 0; // Initialize total sum for shipping
																			
																			$total_estimated_amount = 0; // Initialize total sum for payable amount
																			$total_paid_amount = 0; // Initialize total sum for paid amount
																			$total_due_amount = 0; // Initialize total sum for due amount
																		@endphp

																		@foreach($allData as $key => $item)
																			@php
																				
																				$total_sum += $item->total_amount; // Add to the total invoice sum

																				// Accumulate other fields
																				$total_discount_amount += $item->discount_amount;
																				$total_shipping += $item->shipping;
																				
																				$total_estimated_amount += $item->estimated_amount;
																				$total_paid_amount += $item->paid_amount;
																				$total_due_amount += $item->due_amount;
																			@endphp

																	<tr>
																		<td class="text-center">{{ $key+1 }}</td>
																		<td class="text-center">#{{ $item->purchase_no }}</td>
																		<td class="text-center">{{ date('d-m-Y',strtotime($item->date)) }}</td>
																		<td class="text-center">{{ $item['Supplier']['name'] }}</td>
																		<td class="text-center">{{ $item['Supplier']['mobile_no'] }}</td>
																		<td class="text-center">{{ $item->total_amount }}</td>
																		
																		<td class="text-center">{{ $item->discount_amount }}</td>
																		
																		<td class="text-center">{{ $item->shipping }}</td>
																		
																		<td class="text-center">{{ $item->estimated_amount }}</td>
																		<td class="text-center">{{ $item->paid_amount }}</td>
																		<td class="text-center">{{ $item->due_amount }}</td>
																	</tr>
																		@endforeach

																	<!-- Display the grand totals -->
																	<tr>
																		
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line"></td>
																		<td class="no-line text-center">
																			<strong>Total:</strong>
																		</td>
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_sum }}</h4></td>
																		
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_discount_amount }}</h4></td>
																		
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_shipping }}</h4></td>
																		
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_estimated_amount }}</h4></td>
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_paid_amount }}</h4></td>
																		<td class="no-line text-center"><h4 class="m-0">{{ $total_due_amount }}</h4></td>
																	</tr>
																	</tbody>
																</table>
															</div>

															<div class="mt-4 mb-1">
																<div class="text-end d-print-none">
																	<a href="{{ route('supplier.invoice.report') }}" class="btn btn-secondary waves-effect">Go Back</a>
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
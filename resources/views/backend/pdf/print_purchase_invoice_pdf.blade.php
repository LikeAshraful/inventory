@extends('admin_dashboard')
@section('admin')

            <div class="page-content">
                
                    <!-- Start Content-->
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
															<img src="{{asset('backend/assets/images/logo.png')}}" alt="" height="40">
														</span>
													</div>

													<div class="logo logo-light">
														<span class="logo-lg">
															<img src="{{asset('backend/assets/images/logo.png')}}" alt="" height="22">
														</span>
													</div>
												</div>

												<div class="text-center">
													<h4 class="m-0 d-print-none">Al-faruk sleeping bag</h4>
												</div>

												<div>
													<h4 class="m-0 d-print-none"></h4>
												</div>
											</div>

                                        </div>
            
                                        <div class="row" style="padding-left: 20px;padding-right: 20px;">
											<hr style="border: 1px solid #000; ">
												<div class="col-md-4"></div>
												<!-- end col -->
												
												<div class="col-md-3">
													<div class=" text-center"style="font-size:20px;text-transform: uppercase;">
														
														<p><b>Purchase Invoice</b></p>
														
													</div>
				
												</div>
												<!-- end col -->
												
												<div class="col-md-5"></div>
												<!-- end col -->
											   
                                        </div>
                                        <!-- end row -->
            
                                        <div class="row"style="padding-left: 20px;padding-right: 20px;">
                                            
											

											<div class="col-sm-4">
												<div>Invoice#:&nbsp;&nbsp;&nbsp;&nbsp;  {{ $purchase->purchase_no }}</div>
												<div>Date:&nbsp;&nbsp;&nbsp;&nbsp;  {{ date('d-m-Y',strtotime($purchase->date)) }}</div>
												<div>Supplier: {{ $purchase['supplier']['shopname'] }}</div>
											</div> <!-- end col -->


                                        </div> 
                                        <!-- end row -->
            
                                        <div class="row"style="padding-left: 20px;padding-right: 20px;">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table mt-4 table-centered">
                                                        <thead style="background-color:#000;color:#fff">
                                                        <tr>
															<th>SN</th>
                                                            <th style="width: 10%">Product code</th>
                                                            <th>Product name</th>
                                                            <th style="width: 10%">Qty</th>
                                                            <th style="width: 10%">Buying Price</th>
                                                            <th style="width: 10%" class="text-end">Total</th>
                                                        </tr>
														</thead>
                                                        <tbody>
														
                                                                @foreach ($purchase->purchaseDetails as $key => $detail)
																	<tr>
																		<td>{{ $key + 1 }}</td> <!-- Serial number -->
																		<td>{{ $detail->product->product_code }}</td> <!-- Product code -->
																		<td>{{ $detail->product->name }}</td> <!-- Product name -->
																		<td>{{ $detail->buying_qty }}</td> <!-- Quantity -->
																		<td>{{ number_format($detail->buying_price, 2) }}</td> <!-- Buying price -->
																		<td class="text-end">{{ number_format($detail->total_amount, 2) }}</td> <!-- Total -->
																	</tr>
																@endforeach
                                                         
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end table-responsive -->
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->
            
                                        <div class="row"style="padding-left: 20px;padding-right: 20px;">
                                            
											
											<div class="col-sm-12">
                                                <div class="float-end">
													<p><b>Sub Total:</b> <span class="float-end">{{ number_format($purchase->purchaseDetails->sum('total_amount'), 2) }}</span></p>
													<p><b>Discount:</b> <span class="float-end">&nbsp;&nbsp;&nbsp; {{ number_format($purchase->discount_amount, 2) }}</span></p>
													<p><b>Shipping:</b> <span class="float-end">&nbsp;&nbsp;&nbsp; {{ number_format($purchase->shipping, 2) }}</span></p>
													<p><b>Payable:</b> <span class="float-end">&nbsp;&nbsp;&nbsp; {{ number_format($purchase->estimated_amount, 2) }}</span></p>
													<p><b>Paid:</b> <span class="float-end">&nbsp;&nbsp;&nbsp; {{ number_format($purchase->paid_amount, 2) }}</span></p>
													<p><b>Due:</b> <span class="float-end">&nbsp;&nbsp;&nbsp; {{ number_format($purchase->due_amount, 2) }}</span></p>
												</div>

                                                <div class="clearfix"></div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->
										
										
                                        
            
                                        <div class="mt-4 mb-1">
                                            <div class="text-end d-print-none">
												<a href="{{ route('purchase.all') }}" class="btn btn-secondary waves-effect">Go Back</a>
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print</a>
                                                <a href="#" class="btn btn-info waves-effect waves-light">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row --> 
                        
                    </div> <!-- container -->

            </div>


@endsection
@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

				<div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
						<div class="row mt-3">
							<div class="col-lg-8 col-xl-12">
								<div class="card">
									<div class="card-body">
										<a class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;" href="{{ route('product.all') }}">Back </a>
										<!-- end timeline content-->
											<div class="tab-pane" id="settings">
												<h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Bar Code Product</h5>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group mb-3">
																<label for="firstname" class="form-label">Product Code</label>
																 <h3>{{ $product->product_code }}</h3>

															</div>
														</div>

	@php
	$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
	@endphp

														<div class="col-md-6">
															<div class="form-group mb-3">
																<label for="firstname" class="form-label">Product BarCode    </label>
																<h3> {!! $generator->getBarcode($product->product_code,$generator::TYPE_CODE_128)  !!} </h3>
															</div>
														</div>




													</div> <!-- end row --> 
											</div>
											<!-- end settings content-->
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->
                    </div> <!-- container -->
                </div> <!-- content -->







@endsection
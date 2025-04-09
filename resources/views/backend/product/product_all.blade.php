@extends('admin_dashboard')
@section('admin')


				<div class="page-content">
                    <div class="container-fluid">

						<div class="row">
							<div class="col-12">
								<div class="card mt-3">
									<div class="card-body">

										<a href="{{ route('import.product') }}" class="btn btn-info btn-rounded waves-effect waves-light" style="float:right; margin-left:10px;">Import </a>  
									   
									   <a href="{{ route('export') }}" class="btn btn-danger btn-rounded waves-effect waves-light" style="float:right; margin-left:10px;">Export </a>  
									   

										<a href="{{ route('product.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Add Product </a> <br>  <br>               
										
										<h4 class="card-title page-title">Product All Data </h4>

										<table id="basic-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
											<thead>
												<tr>
													<th>Sl</th>
													<th>Image</th>
													<th>Name</th>
													<th>Category</th>
													<th>Code</th>
													<th>Buying Price</th>
													<th>Selling Price</th>
													<th>Quantity</th>
													<th>Action</th>
												</tr>	
											</thead>


											<tbody>

											@foreach($product as $key => $item)
											<tr>
												<td> {{ $key+1}} </td>
												<td> <img src="{{ asset($item->product_image) }}" style="width:50px; height: 40px;"> </td>
												<td> {{ $item->name }} </td> 
												 <td> {{ $item['category']['name'] ?? 'N/A' }} </td>
												<td>{{ $item->product_code }}</td>
												<td>{{ $item->buying_price }}</td>
												<td>{{ $item->retail_sale }}</td>
												<td>{{ $item->quantity }}</td>
												
												<td>
													<a href=" {{ route('product.edit',$item->id) }} " class="btn btn-info sm" title="Edit Data"><i class="fa fa-pencil" aria-hidden="true"></i></a>
													<a href="{{ route('barcode.product',$item->id) }}" class="btn btn-info waves-effect waves-light"><i class="fa fa-barcode" aria-hidden="true"></i></a>
													<a href=" {{ route('product.delete',$item->id) }} " class="btn btn-danger sm" title="Delete Data" id="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
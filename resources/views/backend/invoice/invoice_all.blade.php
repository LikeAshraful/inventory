@extends('admin_dashboard')
@section('admin')


				<div class="page-content">
                    <div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card mt-3">
									<div class="card-body">
										<a href="{{ route('retailsale.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"> Add Inovice </a> <br>  <br>               
										<h4 class="card-title">Inovice All Data </h4>
											<table id="basic-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<thead>
													<tr>
														<th>Sl</th> 
														<th>Invoice No </th>
														<th>Date </th>
														<th>Customer Name</th>
														<th>Mobile</th>  
														<th>Sale Type</th>  
														<th>Payable</th>  
														<th>Paid</th>  
														<th>Due</th>  
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
												@foreach($allData as $key => $item)
													<tr>
														<td> {{ $key+1}} </td>
														<td> {{ $item->invoice_no }} </td> 
														<td> {{ date('d-m-Y',strtotime($item->date))  }} </td> 
														<!-- Customer Name -->
														<td>
															@if($item->customer) 
																{{ $item->customer->name ?? 'N/A' }}
															@else
																N/A
															@endif
														</td>

														<td>
															@if($item->customer)
																{{ $item->customer->mobile_no ?? 'N/A' }}
															@else
																N/A
															@endif
														</td>

														<td>  {{ $item->sale_type }} </td> 
														<td>  {{ $item->total_amount }} </td> 
														
														<!-- Display the total paid amount for the invoice -->
														<td>
															@php
																$totalPaid = $item->payments->sum('paid_amount'); // Sum of all paid_amounts for this invoice
															@endphp
															{{ $totalPaid }}
														</td> 
														<td>  {{ $item->due_amount }} </td> 
														
														<td>  
														<a href=" {{ route('invoice.edit',$item->id) }} " class="btn btn-info sm" title="Edit Data"><i class="fa fa-pencil" aria-hidden="true"></i></a>
														
														<a href="{{ route('print.invoice',$item->id) }}" class="btn btn-danger sm" title="Print Invoice" >  <i class="fa fa-print"></i> </a>
														<a href="{{ route('invoice.delete',$item->id) }}" class="btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a> 
														
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
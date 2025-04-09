@extends('admin_dashboard')
@section('admin')


	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card mt-3">
						<div class="card-body">
							<a href="{{ route('stock.report.pdf') }}" target="_blank" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">Stock Report Print</a> <br>  <br>    
							<h4 class="card-title">Stock Report </h4>
							<table id="basic-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
								<thead>
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
									 <td> {{ $item['category']['name'] ?? 'N/A' }} </td> 
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
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
		</div>	
	</div>	
					
					

@endsection					
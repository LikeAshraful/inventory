@extends('admin_dashboard')
@section('admin')


					<div class="page-content">
						<div class="container-fluid">
							
							<div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">

    <a href="{{ route('stock.report.pdf') }}" target="_blank" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i class="fa fa-print"> Stock Report Print </i></a> <br>  <br>    
                    <h4 class="card-title">Stock Report </h4>


                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Supplier Name </th>
                            <th>Unit</th>
                            <th>Category</th> 
                            <th>Product Name</th>  
                            <th>Stock </th>

                        </thead>


                        <tbody>

                        	@foreach($allData as $key => $item)
                        <tr>
                            <td> {{ $key+1}} </td> 
                            <td> {{ $item['supplier']['name'] }} </td> 
                            <td> {{ $item['unit']['name'] }} </td> 
                            <td> {{ $item['category']['name'] }} </td> 
                             <td> {{ $item->name }} </td> 
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
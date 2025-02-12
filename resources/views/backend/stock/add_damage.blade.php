@extends('admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <form method="POST" action="{{ route('damage.store') }}">
                        @csrf
                        <div class="card-body">
						<a href="{{ route('damage.all') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;">List Damaged/Lost Product</a> <br>  <br>
                            <h4 class="card-title">Add Damaged/Lost Product</h4><br><br>
							<div class="row">
								<div class="col-md-6">
                                    <div class="md-3">
                                        <label for="product_id" class="form-label">Product Name</label>
                                        <select name="product_id" id="product_id" class="form-select select2">
                                            <option selected="">Open this select menu</option>
                                            @foreach($product as $prod)
                                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3 mb-3">
                                        <label for="reasons" class="form-label">Reason</label>
                                        <input class="form-control" name="reasons" type="text" id="reasons">
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3">
                                        <label for="product_in">Product In (Restored)</label>
										<input type="number" name="product_in" class="form-control" value="0">
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3 mb-3">
                                        <label for="product_out">Product Out (Lost)</label>
										<input type="number" name="product_out" class="form-control" value="0">
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3">
                                        <label for="date">Date</label>
										<input type="date" name="date" class="form-control" required>
                                    </div>
                                </div>
								
							</div>		
						</div>
							<div class="form-group  p-3">
                                <button type="submit" class="btn btn-info" id="storeButton"> Save</button>
								<button type="button" class="btn btn-rounded btn-danger" onclick="location.reload();">Cancel</button>
                            </div>
					</form>	
				</div>							
			</div>							
		</div>							
	</div>							
</div>							

@endsection

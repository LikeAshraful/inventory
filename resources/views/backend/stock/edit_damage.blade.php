@extends('admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <form action="{{ route('damage.update', $damage->id) }}" method="POST">
						@csrf
						@method('PUT')
                        <div class="card-body">
                            <h2>Edit Damaged/Lost Product</h2>
							<div class="row">
								<div class="col-md-6">
                                    <div class="md-3">
                                        <label for="product_id" class="form-label">Product Name</label>
                                        <select name="product_id" id="product_id" class="form-select select2">
                                            <option selected="">Open this select menu</option>
                                            @foreach($product as $prod)
                                                <option value="{{ $prod->id }}" {{ $damage->product_id == $prod->id ? 'selected' : '' }}>
													{{ $prod->name }} ({{ $prod->product_code }})
												</option>
                                            @endforeach
											
                                        </select>
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3 mb-3">
                                        <label for="reasons" class="form-label">Reason</label>
                                        <input type="text" name="reasons" class="form-control" value="{{ $damage->reasons }}">
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3">
                                        <label for="product_in">Product In (Restored)</label>
										<input type="number" name="product_in" class="form-control" value="{{ $damage->product_in }}">
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3 mb-3">
                                        <label for="product_out">Product Out (Lost)</label>
										<input type="number" name="product_out" class="form-control" value="{{ $damage->product_out }}">
                                    </div>
                                </div>
								
								<div class="col-md-6">
                                    <div class="md-3">
                                        <label for="date">Date</label>
										<input type="date" name="date" class="form-control" value="{{ $damage->date }}" required>
                                    </div>
                                </div>
								
							</div>		
						</div>
							<div class="form-group  p-3">
                                <button type="submit" class="btn btn-info" id="storeButton"> Update</button>
								<button type="button" class="btn btn-rounded btn-danger" onclick="location.reload();">Cancel</button>
                            </div>
					</form>	
				</div>							
			</div>							
		</div>							
	</div>							
</div>							

@endsection















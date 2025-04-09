@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="card-title">Supplier Product Report</h4><br><br>

                        <form method="GET" action="{{ route('supplier.product.pdf') }}" target="_blank" id="myForm">
                            <div class="row">
                                <!-- Supplier Selection Dropdown -->
                                <div class="col-md-4">
                                    <div class="md-3 form-group">
                                        <label for="supplier_id" class="form-label">Supplier</label>
                                        <select class="form-select select2" name="supplier_id" id="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-md-3">
                                    <div class="md-3 form-group">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input class="form-control example-date-input" name="start_date" type="date" id="start_date" placeholder="YY-MM-DD" required>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-md-3">
                                    <div class="md-3 form-group">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input class="form-control example-date-input" name="end_date" type="date" id="end_date" placeholder="YY-MM-DD" required>
                                    </div>
                                </div>
								<div class="col-md-2">
                                    <div class="md-3" style="margin-top:29px;"><button type="submit" class="btn btn-info">Search</button></div>
                                </div>
                            </div> <!-- // end row  --> 

                           
                        </form>
                    </div> <!-- End card-body -->
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                customer_id: {
                    required: true,
                },
                start_date: {
                    required: true,
                }, 
                end_date: {
                    required: true,
                },
            },
            messages: {
                customer_id: {
                    required: 'Please Select a Customer',
                },
                start_date: {
                    required: 'Please Select Start Date',
                },
                end_date: {
                    required: 'Please Select End Date',
                },
            },
            errorElement: 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
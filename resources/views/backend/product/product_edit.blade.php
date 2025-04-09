@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="card-title">Product Update Page</h4><br><br>

                        <!-- Form for updating product -->
                        <form method="post" action="{{ route('product.update') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="row">
                                <!-- Product Name -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="name" class="col-sm-2 col-form-label">Product Name</label>
                                        <div class="col-sm-10">
                                            <input name="name" class="form-control" type="text" value="{{ $product->name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Supplier Name -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Supplier Name</label>
                                        <div class="col-sm-10">
                                            <select name="supplier_id" class="form-select" aria-label="Default select example">
                                                <option value="">Select Supplier</option>
                                                @foreach($supplier as $supp)
                                                    <option value="{{ $supp->id }}" {{ $supp->id == $product->supplier_id ? 'selected' : '' }}>{{ $supp->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Unit Name -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Unit Name</label>
                                        <div class="col-sm-10">
                                            <select name="unit_id" class="form-select" aria-label="Default select example">
                                                <option value="">Select Unit</option>
                                                @foreach($unit as $uni)
                                                    <option value="{{ $uni->id }}" {{ $uni->id == $product->unit_id ? 'selected' : '' }}>{{ $uni->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Category Name -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Category Name</label>
                                        <div class="col-sm-10">
                                            <select name="category_id" class="form-select" aria-label="Default select example" required>
                                                <option value="">Select Category</option>
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Product Code -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="product_code" class="col-sm-2 col-form-label">Product Code</label>
                                        <div class="col-sm-10">
                                            <input name="product_code" class="form-control" type="text" value="{{ $product->product_code }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Buying Date -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="buying_date" class="col-sm-2 col-form-label">Buying Date</label>
                                        <div class="col-sm-10">
                                            <input name="buying_date" class="form-control" type="date" value="{{ $product->buying_date }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Expire Date -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="expire_date" class="col-sm-2 col-form-label">Expire Date</label>
                                        <div class="col-sm-10">
                                            <input name="expire_date" class="form-control" type="date" value="{{ $product->expire_date }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Buying Price -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="buying_price" class="col-sm-2 col-form-label">Buying Price</label>
                                        <div class="col-sm-10">
                                            <input name="buying_price" class="form-control" type="number" value="{{ $product->buying_price }}" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Retail Sale -->
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label for="retail_sale" class="col-sm-2 col-form-label">Retail Sale</label>
                                        <div class="col-sm-10">
                                            <input name="retail_sale" class="form-control" type="number" value="{{ $product->retail_sale }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Wholesale -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="wholesale" class="col-sm-2 col-form-label">Wholesale</label>
                                        <div class="col-sm-10">
                                            <input name="wholesale" class="form-control" type="number" value="{{ $product->wholesale }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Quantity -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                                        <div class="col-sm-10">
                                            <input name="quantity" class="form-control" type="number" value="{{ $product->quantity }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Product Image -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="product_image" class="col-sm-2 col-form-label">Product Image</label>
                                        <div class="col-sm-10">
                                            <input name="product_image" class="form-control" type="file" id="image">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="example-fileinput" class="form-label col-sm-2"></label>
                                        <img id="showImage" src="{{ asset($product->product_image) }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Product">
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
</div>

<!-- Form Validation Script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#myForm').validate({
            rules: {
                name: {
                    required: true,
                },
                
                category_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Please Enter Product Name',
                },
                
                category_id: {
                    required: 'Please Select a Category',
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

<!-- Image Preview Script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#image').change(function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection
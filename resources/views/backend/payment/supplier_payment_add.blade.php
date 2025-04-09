@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Payment System</h4>
                        <p class="card-title-desc">Complete payment processing in single page</p>

                        <form id="paymentForm">
                            @csrf
                            
                            <!-- Customer Selection -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="md-3">
                                        <label for="supplier_id" class="form-label">Supplier Name</label>
                                        <select name="supplier_id" id="supplier_id" class="form-select select2">
                                            <option selected="">Open this select menu</option>
                                            @foreach($supplier as $supp)
                                                <option value="{{ $supp->id }}">{{ $supp->shopname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-1">
                                    <label>Current Due Amount</label>
                                    <input type="text" class="form-control" id="current_due_amount" readonly>
                                </div>
                            </div>


                            <!-- Payment Details -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Payment Date *</label>
                                    <input type="date" class="form-control" name="payment_date" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                                </div>
								<div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Transaction Type *</label>
                                    <select class="form-select select2" name="transaction_type" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Bkash">Bkash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>

                            
							<div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Discount (Optional)</label>
                                    <input name="flat_discount" class="form-control" 
                                           type="number" id="discount_amount" min="0" step="0.01" value="0">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Payment Amount *</label>
                                    <input type="number" class="form-control" name="amount" 
                                           id="payment_amount" required min="0.01" step="0.01">
                                </div>
                                </div>
							<div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Note (Optional)</label>
                                    <textarea class="form-control" name="note" rows="1"></textarea>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save"></i> Save Payment
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </form>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
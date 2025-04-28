@extends('admin_dashboard')
@section('admin')

    <div class="page-content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2" style="box-shadow: none;">
                        <div class="card-body">
                            <!-- Logo & title -->
                            <div class="clearfix" style="padding: 0 20px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="auth-logo">
                                        <div class="logo">
                                            <span class="logo-lg">
                                                <img src="{{asset('backend/assets/images/logo.png')}}" alt="" height="100">
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <h2 class="mb-1">Al-faruk sleeping bag</h2>
                                        <h3>Sales Invoice</h3>
                                    </div>

                                    <div></div>
                                </div>
                            </div>

                            <div class="row" style="padding: 0 20px;">
                                <hr style="border: 1px solid #000;">
                                <div class="col-md-12"></div>
                            </div>

                            <div class="row"style="padding-left: 20px;padding-right: 20px;">
                                
                                <div class="col-sm-8">
                                    <div>Customer ID: &nbsp;{{ $invoice->customer_id }}</div>
                                    <div>Customer Name: &nbsp;{{ $invoice['customer']['name'] }}</div>
                                    <div>Customer Address: &nbsp;{{ $invoice['customer']['address'] }}</div>
                                    <div>Customer Mobile: &nbsp;{{ $invoice['customer']['mobile_no'] }}</div>
                                </div> <!-- end col -->

                                <div class="col-sm-4">
                                    <div>Invoice#:&nbsp;&nbsp;&nbsp;&nbsp; {{ $invoice->invoice_no }}</div>
                                    <div>Date:&nbsp;&nbsp;&nbsp;&nbsp; {{ date('d-m-Y',strtotime($invoice->date)) }}</div>
                                    <div>User: {{ $invoice['employee']['name'] }}</div>
                                </div> <!-- end col -->


                            </div> 
                            <!-- end row -->

                            <div class="row"style="padding-left: 20px;padding-right: 20px;">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-3 mb-3">
                                            <thead style="background-color:#000;color:#fff">
                                            <tr>
                                                <th>SN</th>
                                                <th style="width: 10%">Type</th>
                                                <th>Description</th>
                                                <th style="width: 10%">Qty</th>
                                                <th style="width: 10%">Price</th>
                                                <th style="width: 10%" class="text-end">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($invoice['invoice_details'] as $key => $details)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $details->type }}</td>
                                                <td>{{ $details->product_name }}</td>
                                                <td>{{ $details->quantity }}</td>
                                                <td>{{ $details->price }}</td>
                                                <td class="text-center">{{ $details->total }}</td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row" style="padding: 0 20px;">
                                <div class="col-sm-4">
                                    <div>
                                        <p class="mb-2"><b>Due In This Bill:</b> <span class="float-end">{{ $payment->due_amount }}</span></p>
                                        <p class="mb-2"><b>Previous Dues:</b> <span class="float-end">{{ $payment->previous_due_amount }}</span></p>
                                        <p class="mb-2"><b>Balance:</b> <span class="float-end">{{ $payment['customer']['previous_due_amount'] }}</span></p>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="float-start">
                                    @php
                                        $totalQuantity = $invoiceDetails->sum('quantity');
                                    @endphp
                                        <p><b> Total qty:</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $totalQuantity }}</span></p>
                                        
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                                
                                <div class="col-sm-4">
                                    <div class="float-end">
                                        <p><b>Total:</b> <span class="float-end">{{ $invoice->total_amount }}</span></p>
                                        <p><b>Discount:</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $details->discount }}</span></p>
                                        <p><b>Shipping:</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $invoice->shipping }}</span></p>
                                        <p><b>Labour:</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $invoice->labour }}</span></p>
                                        <p><b>Payable:</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $invoice->payable_amount }}</span></p>
                                        <p><b>Paid:</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{ $payment->paid_amount }}</span></p>
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                            
                            <div class="row mt-3"style="padding-left: 20px;padding-right: 20px;">
                                <div class="col-sm-3">
                                    <div class="clearfix ">
                                        <hr style="border: 1px solid #000; ">  
                                        <h6 class="text-muted text-center">Customer signature</h6>
                                    </div>
                                </div> <!-- end col -->
                                
                                <div class="col-sm-6"></div> <!-- end col -->
                                
                                <div class="col-sm-3">
                                    <div class="clearfix ">
                                        <hr style="border: 1px solid #000; "> 
                                        <h6 class="text-muted text-center">Authorized signature</h6>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row mt-3"style="padding-left: 20px;padding-right: 20px;">
                                <div class="col-md-12 text-center">
                                    <p><b>All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct</b></p>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="mt-4 mb-1">
                                <div class="text-end d-print-none">
                                    <a href="{{ route('retailsale.add') }}" class="btn btn-secondary waves-effect" style="box-shadow: none;">Go Back</a>
                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect" style="box-shadow: none;"><i class="mdi mdi-printer me-1"></i> Print</a>
                                    <a href="#" class="btn btn-info waves-effect" style="box-shadow: none;">Download</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row --> 
            
        </div> <!-- container -->

    </div>


@endsection
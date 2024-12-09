@extends('masteradmin.layouts.app')
    <title>Profityo | View Invoice</title>
    @if(isset($access['view_invoices']) && $access['view_invoices'] == 1)
    @section('content')
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="m-0">{{ __('Invoice Detail') }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Invoice') }}</li>
                            <li class="breadcrumb-item active">#{{ $invoices->sale_inv_id }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-auto">
                        <ol class="breadcrumb float-sm-right">
                            <a href="#" data-toggle="modal" data-target="#deleteestimate-{{ $invoices->sale_inv_id }}"><button class="add_btn_br"><i
                                        class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
                            <!-- <a href="#"><button class="add_btn_br" onclick="printPage()"><i
                                        class="fas fa-solid fa-print mr-2"></i>Print</button></a> -->
                            <a target="_blank" href="{{ route('business.invoices.sendviews', [ $invoices->sale_inv_id, $user_id,'print' => 'true']) }}">
                                <button class="add_btn_br">
                                    <i class="fas fa-solid fa-print mr-2"></i>Print
                                </button>
                            </a>
                            <a href="{{ route('business.invoices.sendviews', [ $invoices->sale_inv_id, $user_id, 'download' => 'true']) }}"><button class="add_btn_br"><i class="fas fa-solid fa-file-pdf mr-2"></i>Export As
                                    Pdf</button></a>
                            </a>
                            <a href="{{ route('business.recurring_invoices.recurringinvoiceStore', $invoices->sale_inv_id) }}"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Make Recurring</button></a>
                            <a href="{{ route('business.invoices.duplicate', $invoices->sale_inv_id) }}"><button class="add_btn_br"><i
                                        class="fas fa-regular fa-copy mr-2"></i>Duplicate</button></a>
                            <a href="{{ route('business.invoices.edit', $invoices->sale_inv_id) }}"><button class="add_btn_br"><i
                                        class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
                            <a href="{{ route('business.invoices.create') }}"><button class="add_btn">Create Another Invoice</button></a>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content px-10">
            <div class="container-fluid">
                <!-- card -->
                <div class="card" id="card-header">
                    <div class="card-body">
                        <div class="row">
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <form id="estimateForm" method="POST" action="{{ route('business.invoices.statusStore', $invoices->sale_inv_id) }}">
                                    @csrf
                                    <select id="sale_status" class="form-control form-select" name="sale_status" style="width: 100%;">
                                        <option > Select Status</option>
                                        <option value="Draft" {{ $invoices->sale_status === 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Approve" {{ $invoices->sale_status === 'Approve' ? 'selected' : '' }}>Approve</option>
                                        <option value="Convert to invoice" {{ $invoices->sale_status === 'Convert to invoice' ? 'selected' : '' }}>Convert to invoice</option>
                                        <option value="Sent" {{ $invoices->sale_status === 'Sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="Cancel" {{ $invoices->sale_status === 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                        <option value="Mark as sent" {{ $invoices->sale_status === 'Mark as sent' ? 'selected' : '' }}>Mark as sent</option>
                                    </select>
                                    </form>
                                </div>
                            </div> -->
                            <!-- /.col -->
                            <div class="col-md-3">
                                <div class="form-group dropdown" id="customerInfo">
                                    <label>Customer</label>
                                    <a data-toggle="dropdown" href="#">
                                        <p class="company_business_name"><b>{{ $invoices->customer->sale_cus_first_name }} {{ $invoices->customer->sale_cus_last_name }}</b></p>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg pad-1">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <span class="company_business_name"><b>{{ $invoices->customer->sale_cus_first_name }} {{ $invoices->customer->sale_cus_last_name }}</b></span>
                                        <p class="company_details_text">{{ $invoices->customer->sale_cus_business_name }}</p>
                                        <p class="company_details_text">{{ $invoices->customer->sale_cus_email }}</p>
                                        <p class="company_details_text">Tel: {{ $invoices->customer->sale_cus_phone }}</p>
                                        <button class="add_btn_br px-15" data-toggle="modal"
                                            data-target="#editcustor_modal">Edit Details</button>
                                        <a href="View-customer-profile.html"><button class="add_btn_br px-15">View
                                                Profile</button></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <label>Amount Due</label>
                                        <p class="company_business_name">{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $invoices->sale_inv_final_amount }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="hrdivider"></div>
                                    </div>
                                    <div class="col-auto">
                                        <label>Due On</label>
                                        <p class="company_business_name">{{ \Carbon\Carbon::parse($invoices->sale_inv_valid_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row justify-content-between pad-3 align-items-center">
                            <div class="col-md-3">
                                <div class="view_es_box">
                                    <img src="{{url('public/dist/img/note.svg')}}" class="detaises_icon">
                                    <p class="view_es_title">Create Invoice</p>
                                    <p class="view_es_create">
                                        Created On: 
                                    @php
                                        $date = $invoices->created_at; 
                                        $carbonDate = \Carbon\Carbon::parse($date);
                                        $carbonDate->setTimezone('Asia/Kolkata');
                                        $formattedDate = $carbonDate->format('Y-m-d \a\t h:i A');

                                        $offsetMinutes = $carbonDate->offsetMinutes; 
                                        $offsetHours = intdiv($offsetMinutes, 60); 
                                        $offsetMinutes = abs($offsetMinutes % 60); 

                                        $formattedOffset = sprintf('GMT%+d:%02d', $offsetHours, $offsetMinutes);
                                        @endphp
                                        {{ $formattedDate }}
                                         <!-- {{ $formattedOffset }} -->
                                </p>
                                    <a href="{{ route('business.invoices.edit', $invoices->sale_inv_id) }}"><button class="viewdetails_btn"><i
                                                class="fas fa-solid fa-pen-to-square mr-2"></i>Edit Invoice</button></a>
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <img src="{{url('public/dist/img/right_arrow.svg')}}" class="detaisesarrow_icon">
                            </div>
                            <div class="col-md-3">
                                <div class="view_es_box">
                                    <img src="{{url('public/dist/img/send.svg')}}" class="detaises_icon">
                                    <p class="view_es_title">Send</p>
                                    <p class="view_es_create">Last sent: Never</p>
                                    @if($invoices->sale_status === 'Sent')
                                        <a href="#">
                                            <button class="viewdetails_btn_br">Mark As Sent</button>
                                        </a>
                                    @else
                                      
                                        <a href="javascript:void(0);" onclick="sendEstimate('{{ route('business.invoices.send', [$invoices->sale_inv_id, $user_id]) }}')">
                                            <button class="viewdetails_btn">
                                                <i class="fas fa-regular fa-paper-plane mr-2"></i>Send Invoice
                                            </button>
                                        </a>

                                        
                                    @endif

                                   
                                   
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <img src="{{url('public/dist/img/right_arrow.svg')}}" class="detaisesarrow_icon">
                            </div>
                            <div class="col-md-3">
                                <div class="view_es_box">
                                    <img src="{{url('public/dist/img/payment.svg')}}" class="detaises_icon">
                                    <p class="view_es_title">Manage payments</p>
                                    <p class="view_es_create">Amount Due: $75.00 — <span class="invoice_underline" data-toggle="modal" data-target="#recordpaymentpopup">Record a Payment</span> Manually</p>
                                    <a href="#"><button class="viewdetails_btn"><i class="fas fa-solid fa-file-invoice mr-2"></i>Charge a Credit Card</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.card -->
                <!-- card -->
                <div class="card">
                    <div class="card-header" id="estimate-tab">
                        <h3 class="card-title">Invoice</h3>
                        <h3 class="card-title float-sm-right">#{{ $invoices->sale_inv_id }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body2">
                        <div class="row justify-content-between pad-3">
                            <div class="col-md-3 ">
                                <!-- <img src="{{url('public/dist/img/logo.png')}}" alt="Profityo Logo" class="estimate_logo_img"> -->
                                @if($businessDetails && $businessDetails->bus_image)
                                <img src="{{ url(env('IMAGE_URL') . 'storage/app/masteradmin/business_profile/' . $businessDetails->bus_image) }}"
                                class="elevation-2 img-box" target="_blank">
                                @endif
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <p class="estimate_view_title text-right">Invoice</p>
                                <p class="company_details_text text-right">Summary</p>
                                <p class="company_business_name text-right">{{ $businessDetails->bus_company_name }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->bus_address1 }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->bus_address2 }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->country->name ?? '' }}</p>
                                <p class="company_details_text text-right">{{ $businessDetails->state->name ?? '' }},
                                {{  $businessDetails->city_name }} {{ $businessDetails->zipcode }}</p>
                                <p class="company_details_text text-right">Phone: {{  $businessDetails->bus_phone }}</p>
                                <p class="company_details_text text-right">Mobile: {{  $businessDetails->bus_mobile }}</p>
                                <p class="company_details_text text-right">{{  $businessDetails->bus_website }}</p>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="dropdown-divider"></div>
                        <div class="row justify-content-between pad-2">
                            <div class="col-auto px-10" id="sale_customer">
                                <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_cus_first_name }} {{ $invoices->customer->sale_cus_last_name }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_cus_business_name }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_cus_phone }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_cus_email }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_bill_address1 }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_bill_address2 }}</p>
                                <p class="company_details_text"> {{ $invoices->customer->state->name }}, {{ $invoices->customer->sale_bill_city_name }} {{ $invoices->customer->sale_bill_zipcode }}</p>
                                <p class="company_details_text">{{ $invoices->customer->bill_country->name }}</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto px-10" id="ship_customer">
                                <p class="company_business_name" style="text-decoration: underline;">Shipped To</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_ship_shipto }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_ship_phone }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_cus_email }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_ship_address1 }}</p>
                                <p class="company_details_text">{{ $invoices->customer->sale_ship_address2 }}</p>
                                <p class="company_details_text">{{ $invoices->customer->ship_state->name }}, {{ $invoices->customer->sale_ship_city_name }} {{ $invoices->customer->sale_ship_zipcode }}</p>
                                <p class="company_details_text">{{ $invoices->customer->country->name }}</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto px-10">
                                <table class="table estimate_detail_table">
                                    <tr>
                                        <td><strong>Invoice Number:</strong></td>
                                        <td>{{ $invoices->sale_inv_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>P.O./S.O. Number:</strong></td>
                                        <td>{{ $invoices->sale_inv_customer_ref }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Invoice Date:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($invoices->sale_inv_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Due:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($invoices->sale_inv_valid_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grand Total ({{ $currencys->find($invoices->sale_currency_id)->currency }}):</strong></td>
                                        <td><strong>{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $invoices->sale_inv_final_amount }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row px-10">
                            <div class="col-md-12 table-responsive ">
                                <table class="table table-hover text-nowrap dashboard_table item_table">
                                    <thead>
                                        <tr>
                                            <th>Items</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Tax</th>
                                            <!-- <th class="text-center">Description</th> -->
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    @foreach($invoicesItems as $item)
                                    <tbody>
                                        <tr>
                                            <td>{{ $item->invoices_product->sale_product_name ?? 'No Product Name' }}</td>
                                            <td class="text-center">{{ $item->sale_inv_item_qty }}</td>
                                            <td class="text-center">{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $item->sale_inv_item_price }}</td>
                                            <!-- <td class="text-center">5%</td> -->
                                            <td class="text-center">{{ $item->item_tax->tax_name ?? 'No Tax Name' }} {{ $item->item_tax->tax_rate ?? 'No Tax Name' }}%</td>
                                            <!-- <td class="text-center">{{ $item->sale_estim_item_desc ?? 'No Tax Name' }}</td> -->
                                            <td class="text-right">{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $item->sale_inv_item_qty * $item->sale_inv_item_price ?? '0'}} </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4 subtotal_box">
                                <div class="table-responsive">
                                    <table class="table total_table">
                                        <tr>
                                            <td style="width:50%">Sub Total :</td>
                                            <td>{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $invoices->sale_inv_sub_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount:</td>
                                            <td>{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $invoices->sale_inv_discount_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax :</td>
                                            <td>{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $invoices->sale_inv_tax_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total:</strong></td>
                                            <td><strong>{{ $currencys->find($invoices->sale_currency_id)->currency_symbol }}{{ $invoices->sale_inv_final_amount }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($invoices->sale_inv_notes))
                    <div class="col-md-12">
                            <p class="estimate_view_title ">Notes / Terms</p>
                            <p>{{ $invoices->sale_inv_notes ?? '' }}</p>
                    </div>
                    @endif
                    <div class="col-md-12">
                        <p class="estimate_view_title ">Footer</p>
                        <p>{{ $invoices->sale_inv_footer_note ?? '' }}</p>
                    </div>
                </div>
                <!-- /.card -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    <div class="modal fade" id="editcustor_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="editCustomerForm">
                    @csrf
                    @method('PUT')
                <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
                    <ul class="nav nav-pills p-2 tab_box">
                    <li class="nav-item"><a class="nav-link active" href="#editcontact" data-toggle="tab">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#editbilling" data-toggle="tab">Billing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#editshipping" data-toggle="tab">Shipping</a></li>
                    <li class="nav-item"><a class="nav-link" href="#editmore" data-toggle="tab">More</a></li>
                    </ul>
                </div><!-- /.card-header -->

                <div class="tab-content">
                    <div class="tab-pane active" id="editcontact">
                
                    <input type="hidden" name="sale_cus_id" value="{{ $invoices->sale_cus_id }}">
                        <div class="row pxy-15 px-10">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="customer">Customer <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer" name="sale_cus_business_name" placeholder="Business Or Person" required value="{{ $invoices->customer->sale_cus_business_name }}">
                            <span class="error-message" id="error_sale_cus_business_name" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_email">Email</label>
                            <input type="email" class="form-control" name="sale_cus_email" id="customer_email" placeholder="Enter Email" value="{{ $invoices->customer->sale_cus_email }}">
                            <span class="error-message" id="error_sale_cus_email" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_phonenumber">Phone</label>
                            <input type="Number" name="sale_cus_phone" class="form-control" id="customer_phonenumber" placeholder="Enter Phone Number" value="{{ $invoices->customer->sale_cus_phone }}">
                            <span class="error-message" id="error_sale_cus_phone" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_firstname">First Name</label>
                            <input type="text"  class="form-control" name="sale_cus_first_name" id="customer_firstname" placeholder="First Name" value="{{ $invoices->customer->sale_cus_first_name }}">
                            <span class="error-message" id="error_sale_cus_first_name" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_lastname">Last Name</label>
                            <input type="text" name="sale_cus_last_name" class="form-control" id="customer_lastname" placeholder="Last Name" value="{{ $invoices->customer->sale_cus_last_name }}">
                            <span class="error-message" id="error_sale_cus_last_name" style="color: red;"></span>
                            </div>
                        </div>
                        </div>
                    
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="editbilling">
                    
                        <div class="row pxy-15 px-10">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Currency <span class="text-danger">*</span></label>
                            <select name="sale_bill_currency_id" class="form-control select2" style="width: 100%;" required>
                                <option default>Select a Currency...</option>
                                @foreach($currencys as $cur)
                                    <option value="{{ $cur->id }}" @if($cur->id == $invoices->customer->sale_bill_currency_id) selected @endif>
                                        {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error_sale_bill_currency_id" style="color: red;"></span>
                            </div>
                        </div>
                        </div>
                        <div class="modal_sub_title">Billing Address</div>
                        <div class="row pxy-15 px-10">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress1">Address Line 1</label>
                            <input type="text" class="form-control" id="company-businessaddress1" name="sale_bill_address1" value="{{ $invoices->customer->sale_bill_address1 }}" placeholder="Enter a Location">
                            <span class="error-message" id="error_sale_bill_address1" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress2">Address Line 2</label>
                            <input type="text" class="form-control" id="company-businessaddress2" name="sale_bill_address2" value="{{ $invoices->customer->sale_bill_address2 }}" placeholder="Enter a Location">
                            <span class="error-message" id="error_sale_bill_address2" style="color: red;"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesscity">City</label>
                            <input type="text" class="form-control" id="bill_city"  id="company-businesscity" name="sale_bill_city_name" value="{{ $invoices->customer->sale_bill_city_name }}" placeholder="Enter A City">
                            <span class="error-message" id="error_sale_bill_city_name" style="color: red;"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesszipcode">Postal/ZIP Code</label>
                            <input type="text" class="form-control" name="sale_bill_zipcode" id="company-businesszipcode" placeholder="Enter a Zip Code" value="{{ $invoices->customer->sale_bill_zipcode }}">
                            <span class="error-message" id="error_sale_bill_zipcode" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Country</label>
                            <select class="form-control select2" id="bill_country" name="sale_bill_country_id" style="width: 100%;">
                                <option default>Select a Country...</option>
                                @foreach($countries as $con)
                                    <option value="{{ $con->id }}" @if($con->id == $invoices->customer->sale_bill_country_id) selected @endif>
                                        {{ $con->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error_sale_bill_country_id" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Province/State</label>
                            <select class="form-control select2" id="bill_state" name="sale_bill_state_id" style="width: 100%;">
                                @foreach($customer_states as $state)
                                    <option value="{{ $state->id }}" @if($state->id == $invoices->customer->sale_bill_state_id) selected @endif>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error_sale_bill_state_id" style="color: red;"></span>
                            </div>
                        </div>
                        </div>
                    
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="editshipping">
                
                        <div class="modal_sub_title px-15">Shipping Address</div>
                        <div class="row pxy-15 px-10">
                        <!-- <div id="errorMessages" style="display:none; color: red;"></div> -->

                        <div class="col-md-12">
                            <div class="icheck-primary">
                            <input type="radio" id="shippingaddress" name="shipping" name="sale_same_address" value="on" @if($invoices->customer->sale_same_address == 'on') checked @endif>
                            <label for="shippingaddress">Same As Billing Address</label>
                            <span class="error-message" id="error_sale_same_address" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer">Ship to Contact <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sale_ship_shipto" id="customer" placeholder="Business Or Person" required value="{{ $invoices->customer->sale_ship_shipto }}">
                            <span class="error-message" id="error_sale_ship_shipto" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_phonenumber">Phone</label>
                            <input type="Number" class="form-control" name="sale_ship_phone" id="customer_phonenumber" placeholder="Enter Phone Number" value="{{ $invoices->customer->sale_ship_phone }}">
                            <span class="error-message" id="error_sale_ship_phone" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress1">Address Line 1</label>
                            <input type="text" class="form-control" name="sale_ship_address1" id="company-businessaddress1" placeholder="Enter a Location" value="{{ $invoices->customer->sale_ship_address1 }}">
                            <span class="error-message" id="error_sale_ship_address1" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress2">Address Line 2</label>
                            <input type="text" class="form-control" id="company-businessaddress2" placeholder="Enter a Location" name="sale_ship_address2" value="{{ $invoices->customer->sale_ship_address2 }}">
                            <span class="error-message" id="error_sale_ship_address2" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesscity">City</label>
                            <input type="text" class="form-control" name="sale_ship_city_name" id="company-businesscity"  placeholder="Enter A City" value="{{ $invoices->customer->sale_ship_city_name }}">
                            <span class="error-message" id="error_sale_ship_city_name" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesszipcode">Postal/ZIP Code</label>
                            <input type="text" class="form-control" id="company-businesszipcode" placeholder="Enter a Zip Code" name="sale_ship_zipcode" value="{{ $invoices->customer->sale_ship_zipcode }}">
                            <span class="error-message" id="error_sale_ship_zipcode" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Country</label>
                            <select class="form-control select2" id="ship_country" name="sale_ship_country_id" style="width: 100%;">
                                <option default>Select a Country...</option>
                                @foreach($currencys as $cont)
                                    <option value="{{ $cont->id }}" @if($cont->id == $invoices->customer->sale_ship_country_id) selected @endif>
                                        {{ $cont->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error_sale_ship_country_id" style="color: red;"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Province/State</label>
                            <select class="form-control select2 @error('sale_ship_state_id') is-invalid @enderror" id="ship_state" name="sale_ship_state_id" style="width: 100%;">
                                <option default>Select a State...</option>
                                @foreach($ship_state as $statest)
                                    <option value="{{ $statest->id }}" @if($statest->id == $invoices->customer->sale_ship_state_id) selected @endif>
                                        {{ $statest->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error_sale_ship_state_id" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="deliveryinstructions">Delivery instructions</label>
                            <input type="text" class="form-control" name="sale_ship_delivery_desc" id="deliveryinstructions" placeholder="" value="{{ $invoices->customer->sale_ship_delivery_desc }}">
                            <span class="error-message" id="error_sale_ship_delivery_desc" style="color: red;"></span>
                            </div>
                        </div>
                        </div>
                
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="editmore">
                
                        <div class="row pxy-15 px-10">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customeraccountnumber">Account Number</label>
                            <input type="Number" class="form-control" name="sale_cus_account_number" id="customeraccountnumber" placeholder="" value="{{ $invoices->customer->sale_cus_account_number }}">
                            <span class="error-message" id="error_sale_cus_account_number" style="color: red;"></span>
                            </div>
                        </div>
                                            
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customerwebsite">Website</label>
                            <input type="text" class="form-control" name="sale_cus_website"  id="customerwebsite" placeholder="" value="{{ $invoices->customer->sale_cus_website }}">
                            <span class="error-message" id="error_sale_cus_website" style="color: red;"></span>
                            </div>
                        </div>
                        
                        </div>
                    
                    </div>
                    <!-- /.tab-pane -->
                </div>

                <!-- /.tab-content -->
                </div>
                <div class="modal-footer">
                    <a type="button" class="add_btn_br" data-dismiss="modal">Cancel</a>
                    <button type="submit" class="add_btn">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteestimate-{{ $invoices->sale_inv_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="delete-form-{{ $invoices->sale_inv_id }}" data-id="{{ $invoices->sale_inv_id }}">
                @csrf
                @method('DELETE')
                <div class="modal-body pad-1 text-center">
                    <i class="fas fa-solid fa-trash delete_icon"></i>
                    <p class="company_business_name px-10"><b>Delete Invoice</b></p>
                    <p class="company_details_text px-10">Delete Invoice #{{ $invoices->sale_inv_id }}</p>
                    <p class="company_details_text">Are You Sure You Want to Delete This Invoice?</p>
                    <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="delete_btn px-15" data-id="{{ $invoices->sale_inv_id }}">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="recordpaymentpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Record A Payment For This Invoice</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form>
                <div class="row pxy-15 px-10">
                <div class="col-md-12"><p>Record a Payment you've Already Received, Such As Cash, Check, or Bank Payment.</p></div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Date</label>
                    <div class="input-group date" id="estimatedate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" placeholder="" data-target="#estimatedate">
                        <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Amount</label>
                    <div class="d-flex">
                        <select class="form-select amount_currency_input">
                        <option>$</option>
                        <option>€</option>
                        <option>(CFA)</option>
                        <option>£</option>
                        </select>
                        <input type="text" class="form-control amount_input" aria-describedby="inputGroupPrepend">
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Method</label>
                    <select class="form-control form-select">
                        <option>Select a Payment Method...</option>
                        <option>Bank Payment</option>
                        <option>Cash</option>
                        <option>Check</option>
                        <option>Credit Card</option>
                        <option>PayPal</option>
                        <option>Other Payment Method</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Account <span class="text-danger">*</span></label>
                    <select class="form-control form-select" required>
                    <option>Select a Payment Account...</option>
                    <option>Cash on Hand (USD)</option>
                    <option>Chisom Latifat (AED)</option>
                    <option>INR for cash (INR)</option>
                    <option>Shareholder Loan (USD)</option>
                    <option>Wave Payroll Clearing (USD)</option>
                    </select>
                    <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds From.</p>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="recordpaymentmemonotes">Memo / Notes</label>
                    <textarea id="recordpaymentmemonotes" class="form-control" rows="3" placeholder="Enter your text here"></textarea>
                    </div>
                </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
            <button type="submit" class="add_btn">Save</button>
            </div>
        </div>
        </div>
    </div>

    </div>
    <!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
          $('#editCustomerForm').on('submit', function(e) {
        e.preventDefault();

        var saleCusId = $(this).find('input[name="sale_cus_id"]').val();
        alert(saleCusId);

        $.ajax({
            url: "{{ route('salescustomers.update', ['sale_cus_id' => $invoices->sale_cus_id]) }}",
            type: 'PUT',
            data: $(this).serialize(), 
            success: function(response) {
                // console.log(response.customer)
                var customer = response.customer;
                // console.log(customer);

                var customerInfoHtml = `
                    <label>Customer</label>
                    <a data-toggle="dropdown" href="#">
                        <p class="company_business_name"><b>${customer.sale_cus_first_name} ${customer.sale_cus_last_name}</b></p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg pad-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <span class="company_business_name"><b>${customer.sale_cus_first_name} ${customer.sale_cus_last_name}</b></span>
                        <p class="company_details_text">${customer.sale_cus_business_name}</p>
                        <p class="company_details_text">${customer.sale_cus_email}</p>
                        <p class="company_details_text">Tel: ${customer.sale_cus_phone}</p>
                        <button class="add_btn_br px-15" data-toggle="modal" data-target="#editcustor_modal">Edit Details</button>
                        <a href="View-customer-profile.html">
                            <button class="add_btn_br px-15">View Profile</button>
                        </a>
                    </div>`;

                    var customerSalelHtml = `  
                    <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                    <p class="company_details_text">${customer.sale_cus_first_name} ${customer.sale_cus_last_name}</p>
                    <p class="company_details_text">${customer.sale_cus_business_name}</p>
                    <p class="company_details_text">${customer.sale_cus_phone}</p>
                    <p class="company_details_text">${customer.sale_cus_email}</p>
                    <p class="company_details_text">${customer.sale_bill_address1}</p>
                    <p class="company_details_text">${customer.sale_bill_address2}</p>
                    <p class="company_details_text">${customer.state.name}, ${customer.sale_bill_city_name} ${customer.sale_bill_zipcode}</p>
                    <p class="company_details_text">${customer.country.name}</p> `;

                    var customerShipHtml = `  
                    <p class="company_business_name" style="text-decoration: underline;">Shipped To</p>
                    <p class="company_details_text">${customer.sale_ship_shipto}</p>
                    <p class="company_details_text">${customer.sale_ship_phone}</p>
                    <p class="company_details_text">${customer.sale_cus_email}</p>
                    <p class="company_details_text">${customer.sale_ship_address1}</p>
                    <p class="company_details_text">${customer.sale_ship_address2}</p>
                    <p class="company_details_text">${customer.state.name}, ${customer.sale_ship_city_name} ${customer.sale_ship_zipcode}</p>
                    <p class="company_details_text">${customer.country.name}</p> `;
                
                // Update the customer info section with the new data
                $('#customerInfo').html(customerInfoHtml).show();

                $('#sale_customer').html(customerSalelHtml).show();

                $('#ship_customer').html(customerShipHtml).show();

                // Hide the modal
                $('#editcustor_modal').modal('hide');
               
            },
            error: function(xhr) {
            
            if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    console.log(errors); // Debug the errors object

                    // Clear previous error messages
                    $('.error-message').html('');

                    $.each(errors, function(field, messages) {
                        // Find the error message container for the specific field
                        var errorMessageContainer = $('#error_' + field);
                        if (errorMessageContainer.length) {
                            errorMessageContainer.html(messages.join('<br>'));
                        }
                    });
                } else {
                    console.log('An error occurred: ' + xhr.statusText);
                }
            }
        });
    });
});


    </script>

    <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('estimateForm');
        //alert(form);
        function submitForm() {
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // console.log('Estimate saved successfully!');
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        form.addEventListener('change', submitForm);
    });
    </script> -->
    <script>
        function printPage() {
            window.print();
        }
    </script>
 <style>
        @media print {
            .content-header {
                display: none;
            }
            #card-header {
                display: none;
            }
            #estimate-tab {
                display: none;
            }
        
        }

    </style>
    <script>
    function sendEstimate(url) {
        if (confirm('Are you sure you want to send this invoice?')) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    alert('Invoice link sent to the customer successfully.');
                    location.reload(); 
                },
                error: function(xhr) {
                    alert('An error occurred while sending the invoice.');
                }
            });
        }
    }
</script>
<script>
$(document).on('click', '.delete_btn', function() {
    var invoiceId = $(this).data('id'); // Get the bill ID
    var form = $('#delete-form-' + invoiceId);
    var url = "{{ route('business.invoices.destroy', ':id') }}"; // Use the named route
    url = url.replace(':id', invoiceId); // Replace with the actual ID
    // alert(url);
    // Send DELETE request using AJAX
    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(), // Serialize form data
        success: function(response) {
            if (response.success) {
                // Redirect or update the UI dynamically
                window.location.href = "{{ route('business.invoices.index') }}";
            } else {
                alert('An error occurred: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while deleting the record.');
        }
    });
});
</script>
    @endsection
@endif
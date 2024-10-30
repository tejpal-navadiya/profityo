@extends('masteradmin.layouts.app')
    <title>Profityo | View Recurring Invoices</title>
    @if(isset($access['view_recurring_invoices']) && $access['view_recurring_invoices'] == 1)
    @section('content')
    <link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="m-0">{{ __('Recurring Invoice Detail') }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Recurring Invoice') }}</li>
                            <li class="breadcrumb-item active">#{{ $reinvoices->sale_re_inv_id }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-auto">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <a href="#" data-toggle="modal" data-target="#deleteestimate-{{ $reinvoices->sale_re_inv_id }}"><button class="add_btn_br"><i
                                        class="fas fa-solid fa-trash mr-2"></i>Delete</button></a> -->
                            <!-- <a href="#"><button class="add_btn_br" onclick="printPage()"><i
                                        class="fas fa-solid fa-print mr-2"></i>Print</button></a> -->
                            
                           
                            <a href="{{ route('business.recurring_invoices.duplicate', $reinvoices->sale_re_inv_id) }}"><button class="add_btn_br"><i
                                        class="fas fa-regular fa-copy mr-2"></i>Duplicate</button></a>
                            <a href="{{ route('business.recurring_invoices.edit', $reinvoices->sale_re_inv_id) }}"><button class="add_btn_br"><i
                                        class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
                            <a href="{{ route('business.recurring_invoices.create') }}"><button class="add_btn">Create Another Recurring Invoice</button></a>
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
                            <!-- /.col -->
                            <div class="col-md-3">
                                <div class="form-group dropdown" id="customerInfo">
                                    <label>Customer</label>
                                    <a data-toggle="dropdown" href="#">
                                        <p class="company_business_name"><b>{{ $reinvoices->customer->sale_cus_first_name }} {{ $reinvoices->customer->sale_cus_last_name }}</b></p>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg pad-1">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <span class="company_business_name"><b>{{ $reinvoices->customer->sale_cus_first_name }} {{ $reinvoices->customer->sale_cus_last_name }}</b></span>
                                        <p class="company_details_text">{{ $reinvoices->customer->sale_cus_business_name }}</p>
                                        <p class="company_details_text">{{ $reinvoices->customer->sale_cus_email }}</p>
                                        <p class="company_details_text">Tel: {{ $reinvoices->customer->sale_cus_phone }}</p>
                                        <button class="add_btn_br px-15" data-toggle="modal"
                                            data-target="#editcustor_modal">Edit Details</button>
                                        <a href="View-customer-profile.html"><button class="add_btn_br px-15">View
                                                Profile</button></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="row justify-content-end">
                                    <div class="col-auto">
                                        <label>Invoice Amount</label>
                                        <p class="company_business_name">{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $reinvoices->sale_re_inv_final_amount }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="hrdivider"></div>
                                    </div>
                                    <div class="col-auto">
                                        <label>Created to Date</label>
                                        <p class="company_business_name">0 Invoices</p>
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
                                        $date = $reinvoices->created_at; 
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
                                @php
                                    $paymentTerms = [
                                        '' => 'On Receipt',  
                                        '7' => 'Within 7 Days',
                                        '14' => 'Within 14 Days',
                                        '30' => 'Within 30 Days',
                                        '45' => 'Within 45 Days',
                                        '60' => 'Within 60 Days',
                                        '90' => 'Within 90 Days',
                                    ];

                                    $selectedPaymentTerm = $paymentTerms[$reinvoices->sale_re_inv_payment_due_id] ?? 'On Receipt';
                                @endphp

                                    <p class="company_details_text">Payment terms: {{ $selectedPaymentTerm }}</p>
                                    <a href="{{ route('business.recurring_invoices.edit', $reinvoices->sale_re_inv_id) }}"><button class="viewdetails_btn"><i
                                                class="fas fa-solid fa-pen-to-square mr-2"></i>Edit Invoice</button></a>
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <img src="{{url('public/dist/img/right_arrow.svg')}}" class="detaisesarrow_icon">
                            </div>
                            <div class="col-md-3">
                                <div class="view_es_box">
                                    <img src="{{url('public/dist/img/checkbox.svg')}}"" class="detaises_icon">
                                    <p class="view_es_title">Set Schedule</p>
                                    <p class="company_details_text">Repeat Monthly: On the First Day of Wach Month</p>
                                    <p class="company_details_text">Dates: Create First Invoice on May 1st 2024,end on May 1st 2024</p>
                                    <p class="company_details_text">Time Zone: America/New York</p>
                                    <a href="#" data-toggle="modal" data-target="#paymentschedule"><button class="viewdetails_btn"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <img src="{{url('public/dist/img/right_arrow.svg')}}" class="detaisesarrow_icon">
                            </div>
                            <div class="col-md-3">
                                <div class="view_es_box">
                                    <img src="{{url('public/dist/img/payment.svg')}}" class="detaises_icon">
                                    <p class="company_details_text px-10">Automatic Payments: A Payment Pre-authorization<br>will be Sent With the Invoice.</p>
                                    <a href="#"><button class="viewdetails_btn"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
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
                        <h3 class="card-title float-sm-right">#{{ $reinvoices->sale_re_inv_id }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body2">
                        <div class="row justify-content-between pad-3">
                            <div class="col-md-3 ">
                                <!-- <img src="{{url('public/dist/img/logo.png')}}" alt="Profityo Logo" class="estimate_logo_img"> -->
                                @if($businessDetails && $businessDetails->bus_image)
                                <img src="{{ url(env('IMAGE_URL') . 'masteradmin/business_profile/' . $businessDetails->bus_image) }}"
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
                                <p class="company_details_text">{{ $reinvoices->customer->sale_cus_first_name }} {{ $reinvoices->customer->sale_cus_last_name }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_cus_business_name }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_cus_phone }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_cus_email }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_bill_address1 }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_bill_address2 }}</p>
                                <p class="company_details_text"> {{ $reinvoices->customer->state->name }}, {{ $reinvoices->customer->sale_bill_city_name }} {{ $reinvoices->customer->sale_bill_zipcode }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->bill_country->name }}</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto px-10" id="ship_customer">
                                <p class="company_business_name" style="text-decoration: underline;">Shipped To</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_ship_shipto }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_ship_phone }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_cus_email }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_ship_address1 }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->sale_ship_address2 }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->ship_state->name }}, {{ $reinvoices->customer->sale_ship_city_name }} {{ $reinvoices->customer->sale_ship_zipcode }}</p>
                                <p class="company_details_text">{{ $reinvoices->customer->country->name }}</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto px-10">
                                <table class="table estimate_detail_table">
                                    <tr>
                                        <td><strong>Invoice Number:</strong></td>
                                        <td>{{ $reinvoices->sale_re_inv_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>P.O./S.O. Number:</strong></td>
                                        <td>{{ $reinvoices->sale_re_inv_customer_ref }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Invoice Date:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($reinvoices->sale_re_inv_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Due:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($reinvoices->sale_re_inv_valid_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grand Total ({{ $currencys->find($reinvoices->sale_currency_id)->currency }}):</strong></td>
                                        <td><strong>{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $reinvoices->sale_re_inv_final_amount }}</strong></td>
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
                                    @foreach($reinvoicesItems as $item)
                                    <tbody>
                                        <tr>
                                            <td>{{ $item->invoices_product->sale_product_name ?? 'No Product Name' }}</td>
                                            <td class="text-center">{{ $item->sale_re_inv_item_qty }}</td>
                                            <td class="text-center">{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $item->sale_re_inv_item_price }}</td>
                                            <!-- <td class="text-center">5%</td> -->
                                            <td class="text-center">{{ $item->item_tax->tax_name ?? 'No Tax Name' }} {{ $item->item_tax->tax_rate ?? 'No Tax Name' }}%</td>
                                            <!-- <td class="text-center">{{ $item->sale_estim_item_desc ?? 'No Tax Name' }}</td> -->
                                            <td class="text-right">{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $item->sale_re_inv_item_qty * $item->sale_re_inv_item_price ?? '0'}} </td>
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
                                            <td>{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $reinvoices->sale_re_inv_sub_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount:</td>
                                            <td>{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $reinvoices->sale_re_inv_discount_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax :</td>
                                            <td>{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $reinvoices->sale_re_inv_tax_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total:</td>
                                            <td>{{ $currencys->find($reinvoices->sale_currency_id)->currency_symbol }}{{ $reinvoices->sale_re_inv_final_amount }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($reinvoices->sale_re_inv_notes))
                    <div class="col-md-12">
                            <p class="estimate_view_title ">Notes / Terms</p>
                            <p>{{ $reinvoices->sale_re_inv_notes ?? '' }}</p>
                    </div>
                    @endif
                    <div class="col-md-12">
                    <p class="estimate_view_title ">Footer</p>
                        <p>{{ $reinvoices->sale_re_inv_footer_note ?? '' }}</p>
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
                
                    <input type="hidden" name="sale_cus_id" value="{{ $reinvoices->sale_cus_id }}">
                        <div class="row pxy-15 px-10">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="customer">Customer <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer" name="sale_cus_business_name" placeholder="Business Or Person" required value="{{ $reinvoices->customer->sale_cus_business_name }}">
                            <span class="error-message" id="error_sale_cus_business_name" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_email">Email</label>
                            <input type="email" class="form-control" name="sale_cus_email" id="customer_email" placeholder="Enter Email" value="{{ $reinvoices->customer->sale_cus_email }}">
                            <span class="error-message" id="error_sale_cus_email" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_phonenumber">Phone</label>
                            <input type="Number" name="sale_cus_phone" class="form-control" id="customer_phonenumber" placeholder="Enter Phone Number" value="{{ $reinvoices->customer->sale_cus_phone }}">
                            <span class="error-message" id="error_sale_cus_phone" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_firstname">First Name</label>
                            <input type="text"  class="form-control" name="sale_cus_first_name" id="customer_firstname" placeholder="First Name" value="{{ $reinvoices->customer->sale_cus_first_name }}">
                            <span class="error-message" id="error_sale_cus_first_name" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_lastname">Last Name</label>
                            <input type="text" name="sale_cus_last_name" class="form-control" id="customer_lastname" placeholder="Last Name" value="{{ $reinvoices->customer->sale_cus_last_name }}">
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
                                    <option value="{{ $cur->id }}" @if($cur->id == $reinvoices->customer->sale_bill_currency_id) selected @endif>
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
                            <input type="text" class="form-control" id="company-businessaddress1" name="sale_bill_address1" value="{{ $reinvoices->customer->sale_bill_address1 }}" placeholder="Enter a Location">
                            <span class="error-message" id="error_sale_bill_address1" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress2">Address Line 2</label>
                            <input type="text" class="form-control" id="company-businessaddress2" name="sale_bill_address2" value="{{ $reinvoices->customer->sale_bill_address2 }}" placeholder="Enter a Location">
                            <span class="error-message" id="error_sale_bill_address2" style="color: red;"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesscity">City</label>
                            <input type="text" class="form-control" id="bill_city"  id="company-businesscity" name="sale_bill_city_name" value="{{ $reinvoices->customer->sale_bill_city_name }}" placeholder="Enter A City">
                            <span class="error-message" id="error_sale_bill_city_name" style="color: red;"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesszipcode">Postal/ZIP Code</label>
                            <input type="text" class="form-control" name="sale_bill_zipcode" id="company-businesszipcode" placeholder="Enter a Zip Code" value="{{ $reinvoices->customer->sale_bill_zipcode }}">
                            <span class="error-message" id="error_sale_bill_zipcode" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Country</label>
                            <select class="form-control select2" id="bill_country" name="sale_bill_country_id" style="width: 100%;">
                                <option default>Select a Country...</option>
                                @foreach($countries as $con)
                                    <option value="{{ $con->id }}" @if($con->id == $reinvoices->customer->sale_bill_country_id) selected @endif>
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
                                    <option value="{{ $state->id }}" @if($state->id == $reinvoices->customer->sale_bill_state_id) selected @endif>
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
                            <input type="radio" id="shippingaddress" name="shipping" name="sale_same_address" value="on" @if($reinvoices->customer->sale_same_address == 'on') checked @endif>
                            <label for="shippingaddress">Same As Billing Address</label>
                            <span class="error-message" id="error_sale_same_address" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer">Ship to Contact <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sale_ship_shipto" id="customer" placeholder="Business Or Person" required value="{{ $reinvoices->customer->sale_ship_shipto }}">
                            <span class="error-message" id="error_sale_ship_shipto" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer_phonenumber">Phone</label>
                            <input type="Number" class="form-control" name="sale_ship_phone" id="customer_phonenumber" placeholder="Enter Phone Number" value="{{ $reinvoices->customer->sale_ship_phone }}">
                            <span class="error-message" id="error_sale_ship_phone" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress1">Address Line 1</label>
                            <input type="text" class="form-control" name="sale_ship_address1" id="company-businessaddress1" placeholder="Enter a Location" value="{{ $reinvoices->customer->sale_ship_address1 }}">
                            <span class="error-message" id="error_sale_ship_address1" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businessaddress2">Address Line 2</label>
                            <input type="text" class="form-control" id="company-businessaddress2" placeholder="Enter a Location" name="sale_ship_address2" value="{{ $reinvoices->customer->sale_ship_address2 }}">
                            <span class="error-message" id="error_sale_ship_address2" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesscity">City</label>
                            <input type="text" class="form-control" name="sale_ship_city_name" id="company-businesscity"  placeholder="Enter A City" value="{{ $reinvoices->customer->sale_ship_city_name }}">
                            <span class="error-message" id="error_sale_ship_city_name" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="company-businesszipcode">Postal/ZIP Code</label>
                            <input type="text" class="form-control" id="company-businesszipcode" placeholder="Enter a Zip Code" name="sale_ship_zipcode" value="{{ $reinvoices->customer->sale_ship_zipcode }}">
                            <span class="error-message" id="error_sale_ship_zipcode" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Country</label>
                            <select class="form-control select2" id="ship_country" name="sale_ship_country_id" style="width: 100%;">
                                <option default>Select a Country...</option>
                                @foreach($currencys as $cont)
                                    <option value="{{ $cont->id }}" @if($cont->id == $reinvoices->customer->sale_ship_country_id) selected @endif>
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
                                    <option value="{{ $statest->id }}" @if($statest->id == $reinvoices->customer->sale_ship_state_id) selected @endif>
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
                            <input type="text" class="form-control" name="sale_ship_delivery_desc" id="deliveryinstructions" placeholder="" value="{{ $reinvoices->customer->sale_ship_delivery_desc }}">
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
                            <input type="Number" class="form-control" name="sale_cus_account_number" id="customeraccountnumber" placeholder="" value="{{ $reinvoices->customer->sale_cus_account_number }}">
                            <span class="error-message" id="error_sale_cus_account_number" style="color: red;"></span>
                            </div>
                        </div>
                                            
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="customerwebsite">Website</label>
                            <input type="text" class="form-control" name="sale_cus_website"  id="customerwebsite" placeholder="" value="{{ $reinvoices->customer->sale_cus_website }}">
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

    <div class="modal fade" id="paymentschedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Set Schedule</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php //dd($reinvoicesschedule); ?>
        <form action="{{ route('business.recurring_invoices.setScheduleStore', $reinvoices->sale_re_inv_id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
            <div class="row pxy-15 px-10">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Repeat this Invoice</label>
                  <select id="repeat-invoice-select" name="repeat_inv_type" class="form-control form-select">
                    <option value="Daily" {{ $reinvoicesschedule->repeat_inv_type ?? '' == 'Daily' ? 'selected' : '' }}>Daily</option>
                    <option value="Weekly" {{ $reinvoicesschedule->repeat_inv_type ?? '' == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="Monthly" {{ $reinvoicesschedule->repeat_inv_type ?? '' == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Yearly" {{ $reinvoicesschedule->repeat_inv_type ?? '' == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                    <!-- <option>Custom</option> -->
                  </select>
                </div>
              </div>
              <div class="col-md-3" id="day-selection-row" style="display:none;">
                <div class="form-group">
                <label>every</label>
                <select class="form-control form-select" name="repeat_inv_day" id="day-select">
                    <option value="1" {{ $reinvoicesschedule->repeat_inv_day ?? '' == '1' ? 'selected' : '' }}>Monday</option>
                    <option value="2"  {{ $reinvoicesschedule->repeat_inv_day ?? '' == '2' ? 'selected' : '' }}>Tuesday</option>
                    <option value="3"  {{ $reinvoicesschedule->repeat_inv_day ?? '' == '3' ? 'selected' : '' }}>Wednesday</option>
                    <option value="4"  {{ $reinvoicesschedule->repeat_inv_day ?? '' == '4' ? 'selected' : '' }}>Thursday</option>
                    <option value="5"  {{ $reinvoicesschedule->repeat_inv_day ?? '' == '5' ? 'selected' : '' }}>Friday</option>
                    <option value="6"  {{ $reinvoicesschedule->repeat_inv_day ?? '' == '6' ? 'selected' : '' }}>Saturday</option>
                    <option value="0"  {{ $reinvoicesschedule->repeat_inv_day ?? '' == '0' ? 'selected' : '' }}>Sunday</option>
                </select>
                </div>
              </div>
              <div class="col-md-3" id="month-selection-row" style="display:none;">
                <div class="form-group">
                    <label>every</label>
                    <select class="form-control form-select" name="repeat_inv_month" id="month-select">
                        <option value="0" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '0' ? 'selected' : '' }}>January</option>
                        <option value="1" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '1' ? 'selected' : '' }}>February</option>
                        <option value="2" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '2' ? 'selected' : '' }}>March</option>
                        <option value="3" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '3' ? 'selected' : '' }}>April</option>
                        <option value="4" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '4' ? 'selected' : '' }}>May</option>
                        <option value="5" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '5' ? 'selected' : '' }}>June</option>
                        <option value="6" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '6' ? 'selected' : '' }}>July</option>
                        <option value="7" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '7' ? 'selected' : '' }}>August</option>
                        <option value="8" {{ $reinvoicesschedule->repeat_inv_month?? ''  == '8' ? 'selected' : '' }}>September</option>
                        <option value="9" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '9' ? 'selected' : '' }}>October</option>
                        <option value="10" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '10' ? 'selected' : '' }}>November</option>
                        <option value="11" {{ $reinvoicesschedule->repeat_inv_month ?? '' == '11' ? 'selected' : '' }}>December</option>
                    </select>
                </div>
              </div>
              <div class="col-md-3" id="date-selection-row" style="display:none;">
                <div class="form-group">
                <label>on the</label>
                <select class="form-control form-select" name="repeat_inv_date" id="date-select">
                    <option value="First" {{ $reinvoicesschedule->repeat_inv_date ?? '' == 'First' ? 'selected' : '' }}>First</option>
                    <option value="Last" {{ $reinvoicesschedule->repeat_inv_date ?? '' == 'Last' ? 'selected' : '' }}>Last</option>
                    <option value="2nd" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '2nd' ? 'selected' : '' }}>2nd</option>
                    <option value="3rd" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '3rd' ? 'selected' : '' }}>3rd</option>
                    <option value="4th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '4th' ? 'selected' : '' }}>4th</option>
                    <option value="5th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '5th' ? 'selected' : '' }}>5th</option>
                    <option value="6th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '6th' ? 'selected' : '' }}>6th</option>
                    <option value="7th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '7th' ? 'selected' : '' }}>7th</option>
                    <option value="8th" {{ $reinvoicesschedule->repeat_inv_date ?? ''== '8th' ? 'selected' : '' }}>8th</option>
                    <option value="9th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '9th' ? 'selected' : '' }}>9th</option>
                    <option value="10th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '10th' ? 'selected' : '' }}>10th</option>
                    <option value="11th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '11th' ? 'selected' : '' }}>11th</option>
                    <option value="12th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '12th' ? 'selected' : '' }}>12th</option>
                    <option value="13th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '13th' ? 'selected' : '' }}>13th</option>
                    <option value="14th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '14th' ? 'selected' : '' }}>14th</option>
                    <option value="15th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '15th' ? 'selected' : '' }}>15th</option>
                    <option value="16th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '16th' ? 'selected' : '' }}>16th</option>
                    <option value="17th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '17th' ? 'selected' : '' }}>17th</option>
                    <option value="18th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '18th' ? 'selected' : '' }}>18th</option>
                    <option value="19th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '19th' ? 'selected' : '' }}>19th</option>
                    <option value="20th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '20th' ? 'selected' : '' }}>20th</option>
                    <option value="21st" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '21st' ? 'selected' : '' }}>21st</option>
                    <option value="22nd" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '22nd' ? 'selected' : '' }}>22nd</option>
                    <option value="23rd" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '23rd' ? 'selected' : '' }}>23rd</option>
                    <option value="24th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '24th' ? 'selected' : '' }}>24th</option>
                    <option value="25th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '25th' ? 'selected' : '' }}>25th</option>
                    <option value="26th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '26th' ? 'selected' : '' }}>26th</option>
                    <option value="27th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '27th' ? 'selected' : '' }}>27th</option>
                    <option value="28th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '28th' ? 'selected' : '' }}>28th</option>
                    <option value="29th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '29th' ? 'selected' : '' }}>29th</option>
                    <option value="30th" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '30th' ? 'selected' : '' }}>30th</option>
                    <option value="31st" {{ $reinvoicesschedule->repeat_inv_date ?? '' == '31st' ? 'selected' : '' }}>31st</option>
                </select>
                <label>day of every month</label>
                </div>
              </div>
              
            </div>
           
            <div class="row pxy-15 px-10">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Create first invoice on</label>
                  <div class="input-group date" id="estimatedate" data-target-input="nearest">
                    <x-flatpickr id="from-datepicker" name="invoice_date" placeholder="Select a date"/>
                    <div class="input-group-append">
                        <div class="input-group-text" id="from-calendar-icon">
                        <i class="fa fa-calendar-alt"></i>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-2">
                <div class="form-group">
                    <label>and end</label>
                    <select class="form-control form-select" name="create_inv_type" id="end-type">
                        <option value="after" {{ $reinvoicesschedule->create_inv_type ?? '' == 'after' ? 'selected' : '' }}>After</option>
                        <option value="on" {{ $reinvoicesschedule->create_inv_type ?? '' == 'on' ? 'selected' : '' }}>On</option>
                        <option value="never" {{ empty($reinvoicesschedule->create_inv_type) || ($reinvoicesschedule->create_inv_type ?? '') == 'never' ? 'selected' : '' }}>Never</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2" id="after-input" style="display: none;">
                <div class="form-group">
                    <input type="number" class="form-control" name="create_inv_number" id="invoice_number" value="1" value="{{ $reinvoicesschedule->create_inv_number ?? '' }}">
                    <label>invoices</label>
                </div>
            </div>

            <div class="col-md-3" id="on-datepicker" style="display: none;">
                <div class="form-group">
                    <div class="input-group date" id="invoicedate" data-target-input="nearest">
                        <x-flatpickr id="invoicedate-datepicker" name="create_inv_date" placeholder="Select a date" />
                        <div class="input-group-append">
                            <div class="input-group-text" id="invoicedate-calendar-icon">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
        <div class="modal-footer">
          <a type="button" class="add_btn_br" data-dismiss="modal">Cancel</a>
          <button type="submit" class="add_btn">Save</button>
        </div>
        </form>
      </div>
    </div>
    </div>

    </div>
    <!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script>
    $(document).ready(function () {
          $('#editCustomerForm').on('submit', function(e) {
        e.preventDefault();

        var saleCusId = $(this).find('input[name="sale_cus_id"]').val();
        alert(saleCusId);

        $.ajax({
            url: "{{ route('salescustomers.update', ['sale_cus_id' => $reinvoices->sale_cus_id]) }}",
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
// document.addEventListener('DOMContentLoaded', function () {
//     // Initialize Flatpickr with today's date
//     var fromdatepicker = flatpickr("#from-datepicker", {
//       locale: 'en',
//       altInput: true,
//       dateFormat: "m/d/Y",
//       altFormat: "d/m/Y",
//       allowInput: true,
//       defaultDate: new Date(),
//     });

//     // Add event listener to the calendar icon to open the datepicker
//     document.getElementById('from-calendar-icon').addEventListener('click', function () {
//       fromdatepicker.open();
//     });

//     // Show day selection dropdown when 'Weekly' is selected
//     var repeatInvoiceSelect = document.getElementById('repeat-invoice-select');
//     var daySelectionRow = document.getElementById('day-selection-row');
//     var daySelect = document.getElementById('day-select');
//     var dateSelect = document.getElementById('date-select');

//     // Get the current day (0 = Sunday, 1 = Monday, etc.)
//     var currentDay = new Date().getDay();

//     // Function to show the day dropdown when "Weekly" is selected
//     repeatInvoiceSelect.addEventListener('change', function () {
//       if (this.value === 'Weekly') {
//         daySelectionRow.style.display = 'block'; // Show the day dropdown
//         daySelect.value = currentDay; // Set the current day as selected
//       } else {
//         daySelectionRow.style.display = 'none';  // Hide the day dropdown for other options
//       }
      
//     });


//     // Change the date in the datepicker based on the selected day
//     daySelect.addEventListener('change', function () {
//       var selectedDay = parseInt(this.value); // Get selected day (0=Sunday, 1=Monday, etc.)
//       var today = new Date();
//       var currentDay = today.getDay(); // Get the current day (0=Sunday, 1=Monday, etc.)

//       // Calculate the difference between the current day and the selected day
//       var daysUntilNextSelectedDay = (selectedDay - currentDay + 7) % 7;
//       if (daysUntilNextSelectedDay === 0) {
//         daysUntilNextSelectedDay = 7; // If today is the selected day, set the next occurrence to next week
//       }

//       // Calculate the next occurrence of the selected day
//       var nextDate = new Date();
//       nextDate.setDate(today.getDate() + daysUntilNextSelectedDay);

//       // Update the Flatpickr date
//       fromdatepicker.setDate(nextDate);
//     });
// });
    $('#end-type').change(function () {
        var selectedValue = $(this).val();
        
        // Hide both fields initially
        $('#after-input').hide();
        $('#on-datepicker').hide();

        // Show the appropriate field based on the selected value
        if (selectedValue === 'after') {
            $('#after-input').show();
        } else if (selectedValue === 'on') {
            $('#on-datepicker').show();
        }
    });

    // Trigger change event on page load in case "After" or "On" is pre-selected
    $('#end-type').trigger('change');

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Flatpickr with today's date
    var fromdatepicker = flatpickr("#from-datepicker", {
        locale: 'en',
        altInput: true,
        dateFormat: "m/d/Y",
        altFormat: "d/m/Y",
        allowInput: true,
        defaultDate: new Date(),
        onChange: function(selectedDates, dateStr, instance) {
            // Update dropdowns when the date changes
            if (selectedDates.length > 0) {
                updateDropdown(selectedDates[0]);
            }
        }
    });

    // Add event listener to the calendar icon to open the datepicker
    document.getElementById('from-calendar-icon').addEventListener('click', function () {
        fromdatepicker.open();
    });
    
    var invoicedatepicker = flatpickr("#invoicedate-datepicker", {
        locale: 'en',
        altInput: true,
        dateFormat: "m/d/Y",
        altFormat: "d/m/Y",
        allowInput: true,
        defaultDate: new Date(),
    });

    // Add event listener to the calendar icon to open the datepicker
    document.getElementById('invoicedate-calendar-icon').addEventListener('click', function () {
        invoicedatepicker.open();
    });

    function updateDropdown(date) {
        var dateSelect = document.getElementById('date-select');
        var monthSelect = document.getElementById('month-select');
        
        if (!dateSelect || !monthSelect) {
            console.error('date-select or month-select element not found');
            return;
        }

        var day = date.getDate();
        var month = date.getMonth(); // Months are zero-based in JavaScript Date object

        // Find and select the correct option for the day
        for (var i = 0; i < dateSelect.options.length; i++) {
            var option = dateSelect.options[i];
            var optionValue = parseInt(option.value);
            
            if (optionValue === day) {
                option.selected = true;
                break;
            }
        }

        // Update the month dropdown
        monthSelect.value = month;
    }

    // If needed: Ensure the date picker reflects any changes made directly in the dropdowns
    document.getElementById('date-select')?.addEventListener('change', function() {
        var selectedDay = parseInt(this.value);
        var selectedMonth = parseInt(document.getElementById('month-select').value);
        var selectedYear = new Date().getFullYear(); // Adjust year if needed

        fromdatepicker.setDate(new Date(selectedYear, selectedMonth, selectedDay));
    });

    document.getElementById('month-select')?.addEventListener('change', function() {
        var selectedMonth = parseInt(this.value);
        var selectedDay = parseInt(document.getElementById('date-select').value);
        var selectedYear = new Date().getFullYear(); // Adjust year if needed

        fromdatepicker.setDate(new Date(selectedYear, selectedMonth, selectedDay));
    });

    // Get elements
    var repeatInvoiceSelect = document.getElementById('repeat-invoice-select');
    var daySelectionRow = document.getElementById('day-selection-row');
    var daySelect = document.getElementById('day-select');
    var dateSelectionRow = document.getElementById('date-selection-row');
    var dateSelect = document.getElementById('date-select');
    var monthSelectionRow = document.getElementById('month-selection-row');
    var monthSelect = document.getElementById('month-select'); // Month dropdown

    var currentDay = new Date().getDay();
    var today = new Date();
    var currentDate = today.getDate(); // Get the current date
    var currentMonth = today.getMonth(); // 0 = January, 1 = February, etc.
    var currentYear = today.getFullYear();
    var previouslySelectedDate = new Date().getDate();
    // alert(currentDate);
    // Show the appropriate dropdown based on selection
    repeatInvoiceSelect.addEventListener('change', function () {
       
        if (this.value === 'Daily') {
            daySelectionRow.style.display = 'none'; // Hide day dropdown
            dateSelectionRow.style.display = 'none'; // Hide date dropdown
            monthSelectionRow.style.display = 'none'; // Hide month dropdown
            fromdatepicker.setDate(today); // Set the date picker to today's date

        } else if (this.value === 'Weekly') {
            daySelectionRow.style.display = 'block'; // Show day dropdown
            dateSelectionRow.style.display = 'none'; // Hide date dropdown
            monthSelectionRow.style.display = 'none'; // Hide month dropdown
            daySelect.value = today.getDay(); // Set day dropdown to current day

        } else if (this.value === 'Monthly') {
            daySelectionRow.style.display = 'none'; // Hide day dropdown
            dateSelectionRow.style.display = 'block'; // Show date dropdown
            monthSelectionRow.style.display = 'none'; // Hide month dropdown

            dateSelect.value = 'First';
            dateSelect.dispatchEvent(new Event('change'));        

        } else if (this.value === 'Yearly') {
            daySelectionRow.style.display = 'none'; // Hide day dropdown
            dateSelectionRow.style.display = 'block'; // Show date dropdown
            monthSelectionRow.style.display = 'block'; // Show month dropdown

            // Set Flatpickr date to today's date
            fromdatepicker.setDate(today);

            // Automatically select the current month in the dropdown
            // Check if the month is already in the dropdown
            if (!monthSelect.querySelector(`option[value='${currentMonth}']`)) {
                var currentMonthOption = document.createElement('option');
                currentMonthOption.value = currentMonth.toString();
                currentMonthOption.text = getMonthName(currentMonth); // Function to get month name
                monthSelect.appendChild(currentMonthOption);
            }
            monthSelect.value = currentMonth.toString(); // Set current month in the dropdown

            // Add the current date to the date dropdown if it doesn't exist
            if (!dateSelect.querySelector(`option[value='${currentDate}th']`)) {
                var currentDateOption = document.createElement('option');
                currentDateOption.value = `${currentDate}th`;
                currentDateOption.text = `${currentDate}th`;
                dateSelect.appendChild(currentDateOption);
            }

            // Automatically select the current date in the dropdown
            dateSelect.value = `${currentDate}th`;

            // Trigger change event to ensure any related updates
            monthSelect.dispatchEvent(new Event('change'));
            dateSelect.dispatchEvent(new Event('change'));

        } else {
            daySelectionRow.style.display = 'none'; // Hide day dropdown
            dateSelectionRow.style.display = 'none'; // Hide date dropdown
            monthSelectionRow.style.display = 'none'; // Hide month dropdown
        }
    });

    daySelect.addEventListener('change', function () {
        var selectedDay = parseInt(this.value); // Get selected day (0=Sunday, 1=Monday, etc.)
        var today = new Date();
        var currentDay = today.getDay(); // Get the current day (0=Sunday, 1=Monday, etc.)

        // Calculate the difference between the current day and the selected day
        var daysUntilNextSelectedDay = (selectedDay - currentDay + 7) % 7;

        if (daysUntilNextSelectedDay === 0) {
            // If today is the selected day, set the date to today
            fromdatepicker.setDate(today);
        } else {
            // Calculate the next occurrence of the selected day
            var nextDate = new Date();
            nextDate.setDate(today.getDate() + daysUntilNextSelectedDay);
            fromdatepicker.setDate(nextDate);
        }
    });

    // Change the date in the datepicker based on the selected date of the month
    dateSelect.addEventListener('change', function () {
        if (repeatInvoiceSelect.value === 'Monthly' || repeatInvoiceSelect.value === 'Yearly') {

            var selectedOption = this.value; // Get selected option (e.g., "First", "2nd", etc.)
            var selectedMonth = parseInt(monthSelect.value); // Get selected month (0=January, 1=February, etc.)
            var selectedDate = parseInt(dateSelect.value) || previouslySelectedDate; // Use selected date or default to previously selected date

            var today = new Date(); // Ensure today is properly initialized
            var selectedYeara = currentYear; // Default to current year
            if (repeatInvoiceSelect.value === 'Yearly') {
                // Adjust year if necessary and ensure the selected day is valid in the selected month
                if (selectedMonth < today.getMonth()) {
                    selectedYeara += 1; // Move to next year if selecting a previous month
                }

                var selectedYear = selectedYeara; // Keep the year unchanged
                var nextDate = new Date(selectedYear, selectedMonth, 1); // Set to the first day of the selected month

            } else {
                var nextDate = new Date(today.getFullYear(), today.getMonth(), 1); // Start from the first of the current month
            }

        
            switch (selectedOption) {
                case 'First':
                    nextDate.setDate(1);
                    break;
                case 'Last':
                    if (repeatInvoiceSelect.value === 'Yearly') {
                    nextDate = new Date(selectedYear, selectedMonth + 1, 0); // Move to next month
                    }else{
                        nextDate.setMonth(today.getMonth() + 1); // Move to next month
                        nextDate.setDate(0);
                    }
                    break;
                case '2nd':
                    nextDate.setDate(2);
                    break;
                case '3rd':
                    nextDate.setDate(3);
                    break;
                case '4th':
                    nextDate.setDate(4);
                    break;
                case '5th':
                    nextDate.setDate(5);
                    break;
                case '6th':
                    nextDate.setDate(6);
                    break;
                case '7th':
                    nextDate.setDate(7);
                    break;
                case '8th':
                    nextDate.setDate(8);
                    break;
                case '9th':
                    nextDate.setDate(9);
                    break;
                case '10th':
                    nextDate.setDate(10);
                    break;
                case '11th':
                    nextDate.setDate(11);
                    break;
                case '12th':
                    nextDate.setDate(12);
                    break;
                case '13th':
                    nextDate.setDate(13);
                    break;
                case '14th':
                    nextDate.setDate(14);
                    break;
                case '15th':
                    nextDate.setDate(15);
                    break;
                case '16th':
                    nextDate.setDate(16);
                    break;
                case '17th':
                    nextDate.setDate(17);
                    break;
                case '18th':
                    nextDate.setDate(18);
                    break;
                case '19th':
                    nextDate.setDate(19);
                    break;
                case '20th':
                    nextDate.setDate(20);
                    break;
                case '21st':
                    nextDate.setDate(21);
                    break;
                case '22nd':
                    nextDate.setDate(22);
                    break;
                case '23rd':
                    nextDate.setDate(23);
                    break;
                case '24th':
                    nextDate.setDate(24);
                    break;
                case '25th':
                    nextDate.setDate(25);
                    break;
                case '26th':
                    nextDate.setDate(26);
                    break;
                case '27th':
                    nextDate.setDate(27);
                    break;
                case '28th':
                    nextDate.setDate(28);
                    break;
                case '29th':
                    nextDate.setDate(29);
                    break;
                case '30th':
                    nextDate.setDate(30);
                    break;
                case '31st':
                    nextDate.setDate(31);
                    break;
                    
                // Add more cases as needed
            }

            // Update the Flatpickr date
            fromdatepicker.setDate(nextDate);
        }
    });
    
    // Change the date in the datepicker based on the selected month (Yearly)
    monthSelect.addEventListener('change', function () {
        if (repeatInvoiceSelect.value === 'Yearly') {
            
            var selectedMonth = parseInt(monthSelect.value); // Get selected month (0 = January, 1 = February, etc.)
            var selectedYear = currentYear; // Default to current year
            var selectedDate = parseInt(dateSelect.value) || previouslySelectedDate; // Use selected date or default to previously selected date

            // Adjust year if necessary and ensure the selected day is valid in the selected month
            if (selectedMonth < currentMonth) {
                selectedYear += 1; // Move to next year if selecting a previous month
            }
            // alert(selectedYear);
            var daysInSelectedMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();
            if (selectedDate > daysInSelectedMonth) {
                selectedDate = daysInSelectedMonth; // Set to last valid day of the selected month
            }

            // Create a new date object with the selected year, month, and adjusted day
            var selectedFullDate = new Date(selectedYear, selectedMonth, selectedDate);

            // Update the date picker with the new date
            fromdatepicker.setDate(selectedFullDate);
        }
    });

});

</script>
    @endsection
@endif
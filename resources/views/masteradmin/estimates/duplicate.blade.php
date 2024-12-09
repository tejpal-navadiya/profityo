@extends('masteradmin.layouts.app')
<title>Profityo | Edit Estimates</title>
@if(isset($access['update_estimates']) && $access['update_estimates']) 
@section('content')
<link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
        <div class="col-auto">
          <h1 class="m-0">{{ __('Edit Estimate') }}</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item">{{ __('Edit Estimate') }}</li>
            <li class="breadcrumb-item active">#{{ $newId }}</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
            <a class="add_btn_br">Preview</a>
            <a href="#"><button class="add_btn">Save & Continue</button></a>
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
      @if(Session::has('estimate-edit'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ Session::get('estimate-edit') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          @php
          Session::forget('estimate-edit');
      @endphp
      @endif
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Business Address and Contact Details, Title, Summary, and Logo</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <form id="items-form" action="{{ route('business.estimates.duplicateStore', ['id' => $estimates->sale_estim_id]) }}"
        method="POST">
          @csrf
          @method('Patch')
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row justify-content-between">
              <div class="col-md-3 px-10">
                <div class="business_logo_uplod_box">
                  @if($businessDetails && $businessDetails->bus_image)
                  <img src="{{ url(env('IMAGE_URL') . 'storage/app/masteradmin/business_profile/' . $businessDetails->bus_image) }}"
                  class="elevation-2 img-box" target="_blank">
                  <!-- <h3 class="card-title float-sm-right px-10" data-toggle="modal" data-target="#removebusinessimage">Remove image</h3> -->

                  <div class="modal fade" id="removebusinessimage" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-body pad-1 text-center">
                      <i class="fas fa-solid fa-trash delete_icon"></i>
                      <p class="company_details_text">Removing your logo will remove it from all existing and future
                      invoices and estimates. Are you sure you want to remove your business logo?</p>
                      <a type="button" class="add_btn px-15" data-dismiss="modal">Cancel</a>
                      <a type="submit" class="delete_btn px-15">Delete</a>
                    </div>
                    </div>
                  </div>
                  </div>
                @else
              <form method="post" id="editBusinessImageForm" class="mt-6 space-y-6" enctype="multipart/form-data">
              @csrf
              @method('patch')

              <!-- <input type="file" name="image" id="image" class="form-control" >  -->
              <img src="{{url('public/dist/img/upload_icon.png')}}" class="upload_icon_img">
              <p class="upload_text">Browse or Drop your Logo Here Maximum 5MB in Size. JPG, PNG, or GIF Formats.
                Recommended Size: 300 x 200 Pixels.</p>
              </form>
            @endif

                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-7 px-10">
                <div class="row justify-content-end">
                  <div class="col-md-7 float-sm-right">
                    <input type="text" class="form-control text-right" name="sale_estim_title" id="estimatetitle"
                      placeholder="Estimate Title" value="{{ $estimates->sale_estim_title }}">
                  </div>
                </div>
                <div class="row justify-content-end">
                  <div class="col-md-7 float-sm-right px-10">
                    <input type="text" class="form-control text-right" name="sale_estim_summary" id="estimatesummary"
                      placeholder="Summary (e.g. project name, description of estimate)" value="{{ $estimates->sale_estim_summary }}">
                  </div>
                </div>
                <div class="px-10">
                  <p class="company_business_name text-right">{{ $businessDetails->bus_company_name }}</p>
                  <p class="company_details_text text-right">{{  $businessDetails->bus_address1 }}</p>
                  <p class="company_details_text text-right">{{  $businessDetails->bus_address2 }}</p>
                  <p class="company_details_text text-right">{{ $businessDetails->state->name ?? '' }},
                    {{  $businessDetails->city_name }} {{ $businessDetails->zipcode }}
                  </p>
                  <p class="company_details_text text-right">{{  $businessDetails->country->name ?? '' }}</p>
                  <p class="company_details_text text-right">Phone: {{  $businessDetails->bus_phone }}</p>
                  <p class="company_details_text text-right">Mobile: {{  $businessDetails->bus_mobile }}</p>
                  <p class="company_details_text text-right">{{  $businessDetails->bus_website }}</p>
                </div>
                <h3 class="card-title float-sm-right px-10" data-toggle="modal"
                  data-target="#editbusiness_companyaddress"><img src="{{url('public/dist/img/dot.png')}}"
                    class="dot_img">Edit your business address and contact details</h3>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
      </div>
      <!-- /.card -->

      <!-- card -->
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body2">
            <div class="row justify-content-between pad-3">
              <div class="col-md-3">
                <div id="customerInfo">
                  <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                  <p class="company_details_text">{{ $estimates->customer->sale_cus_business_name }}</p>
                  <p class="company_details_text">{{ $estimates->customer->sale_cus_first_name }} {{ $estimates->customer->sale_cus_last_name }}</p>
                  <p class="company_details_text">{{ $estimates->customer->sale_cus_email }}</p>
                  <p class="company_details_text">{{ $estimates->customer->sale_cus_phone }}</p>
                  <div class="edit_es_text" data-toggle="modal" data-target="#editcustor_modal_{{ $estimates->customer->sale_cus_id }}" data-id="{{ $estimates->customer->sale_cus_id }}">
                    <i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit {{ $estimates->customer->sale_cus_first_name }} {{ $estimates->customer->sale_cus_last_name }}
                  </div>
                </div>

                <div class="edit_es_text customer_list list2">
                  <i class="fas fa-solid fa-user-plus mr-2"></i>Choose a Different Customer
                </div>

                <div class="add_customer_list" style="display: none;">
                <label for="customerSelect">Select Customer</label>
                  <select id="customerSelect" name="sale_cus_id" class="form-control select2" style="width: 100%;">
                      <!-- <option>Select Items</option> -->
                      @foreach($salecustomer as $customer)
                      <option value="{{ $customer->sale_cus_id }}" {{ $customer->sale_cus_id == old('customer_id') ? 'selected' : '' }}>
                          {{ $customer->sale_cus_business_name }}
                      </option>
                      @endforeach
                  </select>
                  <span class="error-message" id="error_sale_cus_id" style="color: red;"></span>
                </div>
                
              </div>
              <!-- /.col -->
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="estimatenumber">Estimate Number</label>
                      <input type="text" class="form-control" name="sale_estim_number" id="estimatenumber" placeholder="" value="{{ $newId }}">
                      <span class="error-message" id="error_sale_estim_number" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="estimatecustomerref">Customer Ref</label>
                      <input type="text" class="form-control" name="sale_estim_customer_ref" id="estimatecustomerref"  placeholder="" value="{{ $estimates->sale_estim_customer_ref }}">
                      <span class="error-message" id="error_sale_estim_customer_ref" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Date</label>
                      <div class="input-group date" id="estimatedate" data-target-input="nearest">
                        <!-- <input type="text" class="form-control datetimepicker-input" name="sale_estim_date" placeholder=""
                        data-target="#estimatedate" value="{{ $estimates->sale_estim_date }}"/>
                        <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div> -->
                        <input type="hidden" id="from-datepicker-hidden" value="{{ $estimates->sale_estim_date }}" /> 

                        @php
                        $saleEstimDate = \Carbon\Carbon::parse($estimates->sale_estim_date)->format('m/d/Y');
                        @endphp

                        <x-flatpickr 
                              id="from-datepicker" 
                              name="sale_estim_date" 
                              placeholder="Select a date" 
                              :value="$saleEstimDate" 
                          />

                        <div class="input-group-append">
                          <div class="input-group-text" id="from-calendar-icon">
                              <i class="fa fa-calendar-alt"></i>
                          </div>
                        </div>
                        <span class="error-message" id="error_sale_estim_date" style="color: red;"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Valid Until</label>
                      <div class="input-group date" id="estimatevaliddate" data-target-input="nearest">
                        <!-- <input type="text" class="form-control datetimepicker-input" placeholder=""
                        data-target="#estimatevaliddate" name="sale_estim_valid_date" value="{{ $estimates->sale_estim_valid_date }}"/>
                        <div class="input-group-append" data-target="#estimatevaliddate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                        </div> -->

                        <input type="hidden" id="to-datepicker-hidden" value="{{ $estimates->sale_estim_valid_date }}" />
                       
                       @php
                           $formattedSaleEstimDate = \Carbon\Carbon::parse($estimates->sale_estim_valid_date)->format('m/d/Y');
                       @endphp

                       <x-flatpickr 
                             id="to-datepicker" 
                             name="sale_estim_valid_date" 
                             placeholder="Select a date" 
                             :value="$formattedSaleEstimDate" 
                         />
                      <div class="input-group-append">
                        <div class="input-group-text" id="to-calendar-icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                      </div>

                      </div>
                      <span class="error-message" id="error_sale_estim_valid_date" style="color: red;"></span>
                      <!-- <p class="within_day">Within 7 days</p> -->
                      <p class="within_day">Within <span id="total-days">{{ $estimates->sale_total_days ?? '0' }}</span> days</p>
                      <input type="hidden" id="hidden-total-days" name="sale_total_days" value="{{ $estimates->sale_total_days ?? '0' }}">
                      <span class="error-message" id="error_sale_total_days" style="color: red;"></span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <div class="row px-10">
              <div class="col-md-12 text-right">
              <a class="editcolum_btn" data-toggle="modal" data-target="#editcolum"><i
              class="fas fa-solid fa-pen-to-square mr-2"></i>Edit Columns</a>
                <a id="add" class="additem_btn"><i class="fas fa-plus add_plus_icon"></i>Add Item</a>
              </div>
              <div class="col-md-12 table-responsive ">
                <table class="table table-hover text-nowrap dashboard_table item_table" id="dynamic_field">
                <thead>
                  <tr>
                  <?php
                // dd($estimatesCustomizeMenu);
                      $hasData = false; // Flag to check if any data is displayed
                    ?>

                  @php
                      // Initialize $isChecked array
                      $isChecked1 = [];

                      // Populate $isChecked based on $HideMenus
                      foreach ($HideMenus as $hmenu) {
                          $isChecked1[$hmenu->mname] = (old($hmenu->mname) || $estimateCustomizeMenu->where('mname', $hmenu->mname)->first()?->is_access);
                      }
                  @endphp

                  @foreach($estimatesCustomizeMenu as $menu)
                    @if($menu->is_access == 1 && $menu->esti_cust_menu_title !== "on")
                        @php
                          //dd($isChecked);
                          $hasData = true;
                            $headerText =  $menu->esti_cust_menu_title ?? ucfirst($menu->mname);
                            $mname = strtolower($menu->mname);  
                            //$hideIcon = strpos($mname, 'hide') !== false; 
                            $hideIcon = ''; 
                            if ($headerText === 'Items (Default)' ) {
                                $headerText = 'Items';
                            }elseif ($headerText === 'Quantity (Default)' ) {
                                $headerText = 'Quantity';
                            }elseif ($headerText === 'Price (Default)' ) {
                                $headerText = 'Price';
                            }elseif ($headerText === 'Amount (Default)' ) {
                                $headerText = 'Amount';
                            }

                            $currentChecked = $isChecked1['hide ' . $mname] ?? false; 

                        @endphp
                      
                        @if(strpos($mname, 'item') !== false)
                            <th style="width: 30%;" id="itemsHeader">
                                {!! $headerText !!} 
                                @if($currentChecked)
                                    {!! '<i class="fas fa-eye-slash" aria-hidden="true"></i>' !!}
                                @endif
                            </th>
                          @elseif(strpos($mname, 'units') !== false)
                            <th style="width: 15%;" id="unitsHeader">
                                {!! $headerText !!} 
                                @if($currentChecked)
                                  {!! '<i class="fas fa-eye-slash" aria-hidden="true"></i>' !!}
                              @endif
                            </th>
                        @elseif(strpos($mname, 'price') !== false)
                            <th style="width: 15%;" id="priceHeader">
                                {!! $headerText !!} 
                                @if($currentChecked)
                                    {!! '<i class="fas fa-eye-slash" aria-hidden="true"></i>' !!}
                                @endif
                            </th>
                            <th>Tax</th> <!-- Always include Tax when price is available -->
                        @elseif(strpos($mname, 'amount') !== false)
                            <th id="amountHeader" class="text-right">
                                {!! $headerText !!} 
                                @if($currentChecked)
                                  {!! '<i class="fas fa-eye-slash" aria-hidden="true"></i>' !!}
                              @endif
                            </th>
                            <th class="text-right">Actions</th>
                        @endif
                    @endif
                  @endforeach



                  @if(!$hasData)
              <!-- Default Headers -->
                  <th style="width: 30%;" id="itemsHeader">Items</th>
                  <th style="width: 15%;" id="unitsHeader">Units</th>
                  <th style="width: 15%;" id="priceHeader">Price</th>
                  <th>Tax</th>
                  <th id="amountHeader" class="text-right">Amount</th>
                  <th class="text-right">Actions</th> <!-- New column for actions -->
                  @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($estimatesItems as $item)
                    <tr class="item-row">
                        <td>
                            <div>
                                <select class="form-control select2" name="items[][sale_product_id]" style="width: 100%;">
                                    <option>Select Items</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->sale_product_id }}" {{ $product->sale_product_id == $item->sale_product_id ? 'selected' : '' }}>
                                            {{ $product->sale_product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="error_items_0_sale_product_id" style="color: red;"></span>
                                <input type="text" class="form-control px-10" name="items[][sale_estim_item_desc]"
                                    placeholder="Enter item description" value="{{ $item->sale_estim_item_desc }}">
                                <span class="error-message" id="error_items_0_sale_estim_item_desc" style="color: red;"></span>
                            </div>
                        </td>
                        <td><input type="number" class="form-control" name="items[][sale_estim_item_qty]" value="{{ $item->sale_estim_item_qty }}" min="1" placeholder="Enter item Quantity">
                        <span class="error-message" id="error_items_0_sale_estim_item_qty" style="color: red;"></span>
                        </td>
                        <td>
                            <div class="d-flex">
                              <input type="text" name="items[][sale_estim_item_price]" class="form-control"
                                    aria-describedby="inputGroupPrepend" value="{{ $item->sale_estim_item_price }}" placeholder="Enter item Price">
                            </div>
                            <span class="error-message" id="error_items_0_sale_estim_item_price" style="color: red;"></span>
                        </td>
                        <td>
                            <select class="form-control select2" name="items[][sale_estim_item_tax]" style="width: 100%;">
                                @foreach($salestax as $salesTax)
                                    <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}"
                                        {{ $salesTax->tax_id == $item->sale_estim_item_tax ? 'selected' : '' }}>
                                        {{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%
                                    </option>
                                @endforeach
                            </select>
                            <div class="px-10"></div>
                            <select class="form-control select2" name="items[][sale_estim_item_tax]" style="width: 100%;">
                                @foreach($salestax as $salesTax)
                                    <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}"
                                        {{ $salesTax->tax_id == $item->sale_estim_item_tax ? 'selected' : '' }}>
                                        {{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-right item-price">{{ number_format($item->sale_estim_item_price * $item->sale_estim_item_qty, 2) }}</td>
                        <td  class="text-right"><i class="fa fa-trash delete_icon_grid delete-item"></i></td>
                    </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <br />
            <input type="hidden" name="sale_estim_sub_total" value="{{ $estimates->sale_estim_sub_total }}">
            <input type="hidden" name="sale_estim_discount_total" value="{{ $estimates->sale_estim_discount_total }}">
            <input type="hidden" name="sale_estim_tax_amount" value="{{ $estimates->sale_estim_tax_amount }}">
            <input type="hidden" name="sale_estim_final_amount" value="{{ $estimates->sale_estim_final_amount }}">
            <div class="row pad-2">
              <div class="col-md-4">
                  <div class="d-flex align-items-center">
                    <label style="margin-right: 10px;">Discount</label>
                    <input type="text" class="form-control" name="sale_estim_discount_desc"  aria-describedby="inputGroupPrepend" value="{{ $estimates->sale_estim_discount_desc }}" placeholder="Description (optional)">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="d-flex">
                  <input type="number" class="form-control form-controltext" name="sale_estim_item_discount"
                      aria-describedby="inputGroupPrepend" value="{{ $estimates->sale_estim_item_discount }}" min="1" placeholder="Enter a discount value">
                  <select class="form-select form-selectcurrency" id="sale_estim_discount_type" name="sale_estim_discount_type" >
                      <option value="1" {{ $estimates->sale_estim_discount_type == 1 ? 'selected' : '' }} >{{ $currencys->find($estimates->sale_currency_id)->currency_symbol }}</option>
                      <option value="2" {{ $estimates->sale_estim_discount_type == 2 ? 'selected' : '' }}>%</option>
                  </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="table-responsive">
                  <table class="table total_table">
                      <tr>
                      <select name="sale_currency_id" id="sale_currency_id" class="form-select form-selectcurrency select2" style="width: 100%;" required>
                        @foreach($currencys as $curr)
                          <!-- <option value="{{ $curr->id }}">{{ $curr->currency_symbol }}</option> -->
                          <option value="{{ $curr->id }}" {{ $curr->id == $estimates->sale_currency_id ? 'selected' : '' }} data-symbol="{{ $curr->currency_symbol }}">
                          {{ $curr->currency }} ({{ $curr->currency_symbol }}) - {{ $curr->currency_name }}
                        </option>
                        @endforeach
                      </select>
                      <td style="width:50%">Sub Total :</td>
                      <td id="sub-total">{{ $currencys->find($estimates->sale_currency_id)->currency_symbol }}{{ $estimates->sale_estim_sub_total }}</td>
                      </tr>
                      <tr>
                      <td>Discount :</td>
                      <td id="discount">{{ $currencys->find($estimates->sale_currency_id)->currency_symbol }}{{ $estimates->sale_estim_discount_total }}</td>
                      </tr>
                      <tr>
                      <td>Tax :</td>
                      <td id="tax">{{ $currencys->find($estimates->sale_currency_id)->currency_symbol }}{{ $estimates->sale_estim_tax_amount }}</td>
                      </tr>
                      <tr>
                      <td><strong>Total:</strong></td>
                      <td id="total"><strong>{{ $currencys->find($estimates->sale_currency_id)->currency_symbol }}{{ $estimates->sale_estim_final_amount }}</strong></td>
                      </tr>
                  </table>

                  </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="row pad-2">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputDescription">Notes / Terms</label>
                  <textarea id="inputDescription" class="form-control" name="sale_estim_notes" rows="3" placeholder="Enter notes or terms of service that are visible to your customer">{{ $estimates->sale_estim_notes }}</textarea>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.card -->
        <!-- card -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Footer</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row justify-content-between">
              <div class="col-md-12">
                <textarea id="inputDescription" name="sale_estim_footer_note" class="form-control" rows="3"
                  placeholder="Enter a footer for this estimate (e.g. tax information, thank you note)">{{ $estimates->sale_estim_footer_note }}</textarea>
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.card -->

        <div class="row py-20">
          <div class="col-md-12 text-center">
            <a class="add_btn_br">Preview</a>
            <button class="add_btn">Save & Continue</button>
          </div>
        </div><!-- /.col -->
      </div>
        <!-- /.card -->
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<div class="modal fade" id="editbusiness_companyaddress" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Business Address and Contact Details') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="editBusinessForm" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="modal-body">
          <div class="row pxy-15 px-10">
            <div class="col-md-12">
              <div class="form-group">
                <x-input-label for="company-business" :value="__('Company/Business')"> <span
                    class="text-danger">*</span></x-input-label>
                <x-text-input type="text" class="form-control" id="bus_company_name" placeholder="Enter Business Name"
                  name="bus_company_name" required autofocus autocomplete="bus_company_name"
                  :value="old('bus_company_name', $businessDetails->bus_company_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_company_name')" />
              </div>
            </div>
          </div>
          <div class="modal_sub_title">Address</div>
          <div class="row pxy-15 px-10">
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_address1" :value="__('Address Line 1')" />
                <x-text-input type="text" class="form-control" id="bus_address1" placeholder="Enter A Address Line 1"
                  name="bus_address1" required autofocus autocomplete="bus_address1" :value="old('bus_address1', $businessDetails->bus_address1 ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_address1')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_address2" :value="__('Address Line 2')" />
                <x-text-input type="text" class="form-control" id="bus_address2" placeholder="Enter A Address Line 2"
                  name="bus_address2" required autofocus autocomplete="bus_address2" :value="old('bus_address2', $businessDetails->bus_address2 ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_address2')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="city_name" :value="__('City')" />
                <x-text-input type="text" class="form-control" id="city_name" placeholder="Enter A City"
                  name="city_name" required autofocus autocomplete="city_name" :value="old('city_name', $businessDetails->city_name ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('city_name')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="zipcode" :value="__('Postal/ZIP Code')" />
                <x-text-input type="text" class="form-control" id="zipcode" placeholder="Enter a Zip Code"
                  name="zipcode" required autofocus autocomplete="zipcode" :value="old('zipcode', $businessDetails->zipcode ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="country" :value="__('Country')" />
                <select class="form-control select2" style="width: 100%;" id="country" name="country_id" required>
                  <option default>Select a Country...</option>
                  @foreach($countries as $country)
            <option value="{{ $country->id }}" {{ old('country_id', $businessDetails->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }} ({{ $country->iso2 }})</option>
          @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('Country')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="state" :value="__('Province/State')" />
                <select class="form-control select2" style="width: 100%;" id="state" name="state_id" required>
                  <option default>Select a State...</option>
                  @foreach($states as $state)
            <option value="{{ $state->id }}" {{ $state->id == old('state_id', $businessDetails->state_id) ? 'selected' : '' }}>
            {{ $state->name }}
            </option>
          @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
              </div>
            </div>
          </div>
          <div class="modal_sub_title">Contact</div>
          <div class="row pxy-15 px-10">
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_phone" :value="__('Phone')" />
                <x-text-input type="text" class="form-control" id="bus_phone" placeholder="Enter a Phone"
                  name="bus_phone" required autofocus autocomplete="bus_phone" :value="old('bus_phone', $businessDetails->bus_phone ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_phone')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_mobile" :value="__('Mobile')" />
                <x-text-input type="text" class="form-control" id="bus_mobile" placeholder="Enter a Mobile"
                  name="bus_mobile" required autofocus autocomplete="bus_mobile" :value="old('bus_mobile', $businessDetails->bus_mobile ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_mobile')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_website" :value="__('Website')" />
                <x-text-input type="text" class="form-control" id="bus_website" placeholder="Enter a Website"
                  name="bus_website" required autofocus autocomplete="bus_website" :value="old('bus_website', $businessDetails->bus_website ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_website')" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="currency">Business Currency </label>
                <h5 for="currency">
                  @if ($currency)
            <h5 for="currency">{{ $currency->currency }} - {{ $currency->currency_name }}</h5>
          @else
        <h5 for="currency">No currency information available</h5>
      @endif
                </h5>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
            <button type="submit" class="add_btn">{{ __('Save Changes') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editcolum" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Customize this Estimate</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <form method="post" id="estimateForm" action="{{ route('estimatemenus.update') }}" class="mt-6 space-y-6"
      enctype="multipart/form-data">
      @csrf
      @method('patch')
      <div class="modal-body">
    <div class="modal_sub_title" style="margin-top: 0;">Edit the titles of the columns of this estimate:</div>
    
    @foreach($specificMenus as $menu)
        <div class="colum_box">
            <h2 class="edit-colum_title">{{ $menu->mtitle }}</h2>

            @if($menu->children->count() > 0)
                <div class="row align-items-center justify-content-between">
                    @foreach($menu->children as $child)
                        @if($child->mtitle == 'Other')
                            <div class="col-md-3">
                                <div class="icheck-primary d-flex align-items-center">
                                @php
                                    $item = $estimateCustomizeMenu->where('mname', $menu->mname)->first();
                                    
                                    $value = ' ';
                                    // Check conditions for setting the $value
                                    if($item)
                                    {
                                      
                                        if ($item->mtitle == 'price other' || $item->mtitle == 'amount other' || $item->mtitle == 'item other' ||  $item->mtitle == 'units other') {
                                            $value = $item->esti_cust_menu_title ?? '';
                                            //dd($value);
                                        } 
                                      }
                                @endphp
                                   
                                    <input type="radio" id="{{ $child->mname }}" name="{{ $menu->mtitle }}" 
                                        value="{{ $child->mname }}" 
                                        {{ ($estimateCustomizeMenu->where('mname', $menu->mname)->first()?->esti_cust_menu_title == $value ) ? 'checked' : '' }}>
                                    
                                    <label for="{{ $child->mname }}">{{ $child->mtitle }}</label>


                                    <!-- Pre-fill text field -->
                                  
                                  <input type="text" class="form-control mar_15" placeholder="" 
                                      name="{{ $menu->mtitle }}_other"
                                      value="{{ $value }}">
                                </div>
                            </div>
                        @else
                            <div class="col-md-3">
                                <div class="icheck-primary">
                                    <input type="radio" id="{{ $child->mtitle }}" name="{{ $menu->mtitle }}" 
                                        value="{{ $child->mtitle }}" 
                                        {{ (old($menu->mtitle) == $child->mtitle || $estimateCustomizeMenu->where('mname', $menu->mname)->first()?->esti_cust_menu_title == $child->mtitle) ? 'checked' : '' }}>
                                    
                                    <label for="{{ $child->mtitle }}">{{ $child->mtitle }}</label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

    <div class="modal_sub_title px-15">Hide columns:</div>

    <div class="colum_box">
        <div class="row align-items-center">
            @foreach($HideMenus as $hmenu)
                <div class="col-md-3">
                    <div class="icheck-primary">
                        <!-- Pre-select checkbox -->
                        <input type="checkbox" id="{{ $hmenu->mname }}" name="{{ $hmenu->mname }}" 
                            {{ (old($hmenu->mname) || $estimateCustomizeMenu->where('mname', $hmenu->mname)->first()?->is_access) ? 'checked' : '' }}>
                        
                        <label for="{{ $hmenu->mname }}">{{ $hmenu->mtitle }}</label>
                        <p>{{ $hmenu->sub_title }}</p>
                    </div>
                </div>
            @endforeach

            @foreach($HideDescription as $dmenu)
                <div class="col-md-12">
                    <div class="icheck-primary">
                        <!-- Pre-select checkbox -->
                        <input type="checkbox" id="{{ $dmenu->mname }}" name="{{ $dmenu->mname }}" 
                            {{ (old($dmenu->mname) || $estimateCustomizeMenu->where('mname', $dmenu->mname)->first()?->is_access) ? 'checked' : '' }}>
                        
                        <label for="{{ $dmenu->mname }}">{{ $dmenu->mtitle }}</label>
                        <p>{{ $dmenu->sub_title }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row pad-3">
        <div class="col-md-12">
            @foreach($HideSettings as $smenu)
                <div class="icheck-primary">
                    <!-- Pre-select checkbox -->
                    <input type="checkbox" id="{{ $smenu->mname }}" name="{{ $smenu->mname }}" 
                        {{ (old($smenu->mname) || $estimateCustomizeMenu->where('mname', $smenu->mname)->first()?->is_access) ? 'checked' : '' }}>
                    
                    <label for="{{ $smenu->mname }}">{{ $smenu->mtitle }}</label>
                    <p>{{ $smenu->sub_title }}</p>
                </div>
            @endforeach
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


<div class="modal fade" id="editcustor_modal_{{ $estimates->customer->sale_cus_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
           
            <input type="hidden" name="sale_cus_id" value="{{ $estimates->sale_cus_id }}">
                <div class="row pxy-15 px-10">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="customer">Customer <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="customer" name="sale_cus_business_name" placeholder="Business Or Person" required value="{{ $estimates->customer->sale_cus_business_name }}">
                      <span class="error-message" id="error_sale_cus_business_name" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_email">Email</label>
                      <input type="email" class="form-control" name="sale_cus_email" id="customer_email" placeholder="Enter Email" value="{{ $estimates->customer->sale_cus_email }}">
                      <span class="error-message" id="error_sale_cus_email" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_phonenumber">Phone</label>
                      <input type="Number" name="sale_cus_phone" class="form-control" id="customer_phonenumber" placeholder="Enter Phone Number" value="{{ $estimates->customer->sale_cus_phone }}">
                      <span class="error-message" id="error_sale_cus_phone" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_firstname">First Name</label>
                      <input type="text"  class="form-control" name="sale_cus_first_name" id="customer_firstname" placeholder="First Name" value="{{ $estimates->customer->sale_cus_first_name }}">
                      <span class="error-message" id="error_sale_cus_first_name" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_lastname">Last Name</label>
                      <input type="text" name="sale_cus_last_name" class="form-control" id="customer_lastname" placeholder="Last Name" value="{{ $estimates->customer->sale_cus_last_name }}">
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
                            <option value="{{ $cur->id }}" @if($cur->id == $estimates->customer->sale_bill_currency_id) selected @endif>
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
                      <input type="text" class="form-control" id="company-businessaddress1" name="sale_bill_address1" value="{{ $estimates->customer->sale_bill_address1 }}" placeholder="Enter a Location">
                      <span class="error-message" id="error_sale_bill_address1" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress2">Address Line 2</label>
                      <input type="text" class="form-control" id="company-businessaddress2" name="sale_bill_address2" value="{{ $estimates->customer->sale_bill_address2 }}" placeholder="Enter a Location">
                      <span class="error-message" id="error_sale_bill_address2" style="color: red;"></span>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesscity">City</label>
                      <input type="text" class="form-control" id="bill_city"  id="company-businesscity" name="sale_bill_city_name" value="{{ $estimates->customer->sale_bill_city_name }}" placeholder="Enter A City">
                      <span class="error-message" id="error_sale_bill_city_name" style="color: red;"></span>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesszipcode">Postal/ZIP Code</label>
                      <input type="text" class="form-control" name="sale_bill_zipcode" id="company-businesszipcode" placeholder="Enter a Zip Code" value="{{ $estimates->customer->sale_bill_zipcode }}">
                      <span class="error-message" id="error_sale_bill_zipcode" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Country</label>
                      <select class="form-control select2" id="bill_country" name="sale_bill_country_id" style="width: 100%;">
                        <option default>Select a Country...</option>
                          @foreach($countries as $con)
                            <option value="{{ $con->id }}" @if($con->id == $estimates->customer->sale_bill_country_id) selected @endif>
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
                            <option value="{{ $state->id }}" @if($state->id == $estimates->customer->sale_bill_state_id) selected @endif>
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
                      <input type="radio" id="shippingaddress" name="shipping" name="sale_same_address" value="on" @if($estimates->customer->sale_same_address == 'on') checked @endif>
                      <label for="shippingaddress">Same As Billing Address</label>
                      <span class="error-message" id="error_sale_same_address" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer">Ship to Contact <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="sale_ship_shipto" id="customer" placeholder="Business Or Person" required value="{{ $estimates->customer->sale_ship_shipto }}">
                      <span class="error-message" id="error_sale_ship_shipto" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_phonenumber">Phone</label>
                      <input type="Number" class="form-control" name="sale_ship_phone" id="customer_phonenumber" placeholder="Enter Phone Number" value="{{ $estimates->customer->sale_ship_phone }}">
                      <span class="error-message" id="error_sale_ship_phone" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress1">Address Line 1</label>
                      <input type="text" class="form-control" name="sale_ship_address1" id="company-businessaddress1" placeholder="Enter a Location" value="{{ $estimates->customer->sale_ship_address1 }}">
                      <span class="error-message" id="error_sale_ship_address1" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress2">Address Line 2</label>
                      <input type="text" class="form-control" id="company-businessaddress2" placeholder="Enter a Location" name="sale_ship_address2" value="{{ $estimates->customer->sale_ship_address2 }}">
                      <span class="error-message" id="error_sale_ship_address2" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesscity">City</label>
                      <input type="text" class="form-control" name="sale_ship_city_name" id="company-businesscity"  placeholder="Enter A City" value="{{ $estimates->customer->sale_ship_city_name }}">
                      <span class="error-message" id="error_sale_ship_city_name" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesszipcode">Postal/ZIP Code</label>
                      <input type="text" class="form-control" id="company-businesszipcode" placeholder="Enter a Zip Code" name="sale_ship_zipcode" value="{{ $estimates->customer->sale_ship_zipcode }}">
                      <span class="error-message" id="error_sale_ship_zipcode" style="color: red;"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Country</label>
                      <select class="form-control select2" id="ship_country" name="sale_ship_country_id" style="width: 100%;">
                        <option default>Select a Country...</option>
                        @foreach($currencys as $cont)
                            <option value="{{ $cont->id }}" @if($cont->id == $estimates->customer->sale_ship_country_id) selected @endif>
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
                            <option value="{{ $statest->id }}" @if($statest->id == $estimates->customer->sale_ship_state_id) selected @endif>
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
                      <input type="text" class="form-control" name="sale_ship_delivery_desc" id="deliveryinstructions" placeholder="" value="{{ $estimates->customer->sale_ship_delivery_desc }}">
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
                      <input type="Number" class="form-control" name="sale_cus_account_number" id="customeraccountnumber" placeholder="" value="{{ $estimates->customer->sale_cus_account_number }}">
                      <span class="error-message" id="error_sale_cus_account_number" style="color: red;"></span>
                    </div>
                  </div>
                                    
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customerwebsite">Website</label>
                      <input type="text" class="form-control" name="sale_cus_website"  id="customerwebsite" placeholder="" value="{{ $estimates->customer->sale_cus_website }}">
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



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>

<script>
  $(document).ready(function () {
    $('.select2').select2();
    $('#country').change(function () {
      var countryId = $(this).val();
      // alert(countryId);
      if (countryId) {
        $.ajax({
          url: '{{ env('APP_URL') }}{{ config('global.businessAdminURL') }}/states/' + countryId,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('#state').empty();
            $('#state').append('<option value="">Select a State...</option>');
            $.each(data, function (key, value) {
              $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          }
        });
      } else {
        $('#state').empty();
        $('#state').append('<option value="">Select a State...</option>');
      }
    });
  });
</script>
<script>
  $(document).ready(function () {
    $('#editBusinessForm').on('submit', function (event) {
      event.preventDefault();

      $.ajax({
        url: '{{ route('business.business.edits') }}',
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.success) {
            var business = response.data;

            $('.company_business_name').text(business.bus_company_name);
            $('.company_details_text').eq(1).text(business.bus_address1);
            $('.company_details_text').eq(2).text(business.bus_address2);
            $('.company_details_text').eq(3).text(business.state.name + ', ' + business.city_name + ' ' + business.zipcode);
            $('.company_details_text').eq(4).text(business.country.name);
            $('.company_details_text').eq(5).text('Phone: ' + business.bus_phone);
            $('.company_details_text').eq(6).text('Mobile: ' + business.bus_mobile);
            $('.company_details_text').eq(7).text(business.bus_website);

            $('#editbusiness_companyaddress').modal('hide');

            // alert(response.message);
          } else {
            console.log('Update failed');
          }
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);
        }
      });
    });

    //delete business image
    $('.delete_btn').on('click', function (event) {
      event.preventDefault();

      $.ajax({
        url: '{{ route('business.business.edits') }}',
        type: 'PATCH',
        data: {
          _token: '{{ csrf_token() }}',
          delete_image: true
        },
        success: function (response) {
          if (response.success) {
            $('.company_details_text').eq(7).remove();
            $('#removebusinessimage').modal('hide');
            alert(response.message);
          } else {
            console.log('Delete failed');
          }
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);
        }
      });
    });

    //onchange image upload

    // $('#image').on('change', function(event) {
    //   event.preventDefault();
    //   var formData = new FormData($('#editBusinessImageForm')[0]);
    //   alert(formData);
    //       $.ajax({
    //           url: '{{ route('business.business.edit') }}',
    //           type: 'PATCH',
    //           data: formData,
    //           processData: false,
    //           contentType: false,
    //           success: function(response) {
    //               if (response.success) {
    //                   var business = response.data;

    //                   $('.company_business_name').text(business.bus_company_name);
    //                   $('.company_details_text').eq(0).text(business.bus_address1);
    //                   $('.company_details_text').eq(1).text(business.bus_address2);
    //                   $('.company_details_text').eq(2).text(business.state.name + ', ' + business.city_name + ' ' + business.zipcode);
    //                   $('.company_details_text').eq(3).text(business.country.name);
    //                   $('.company_details_text').eq(4).text('Phone: ' + business.bus_phone);
    //                   $('.company_details_text').eq(5).text('Mobile: ' + business.bus_mobile);
    //                   $('.company_details_text').eq(6).text(business.bus_website);

    //                   // Update the image if uploaded
    //                   if (business.bus_image) {
    //                       $('.upload_icon_img').attr('src', '{{ url("storage/masteradmin/business_profile") }}/' + business.bus_image);
    //                   }

    //                   alert(response.message);
    //               } else {
    //                   console.log('Update failed');
    //               }
    //           },
    //           error: function(xhr) {
    //               console.log('Error:', xhr.responseText);
    //           }
    //       });
    //   });

    //show customer list droupdown list
    $('.customer_list').on('click', function () {
      var $customerList = $(this).next('.add_customer_list');
      var $addCustomerBox = $(this);

      if ($customerList.is(':visible')) {
        // alert('customerlisdt');
        $customerList.hide();
        $addCustomerBox.show();
      } else {
        // alert('close');
        $('#customerInfo').hide();
        $('.add_customer_list').hide();
        $('.customer_list').show();
        $customerList.show();
        $addCustomerBox.hide();
        $addCustomerBox.hide();
      }
    });

    //cutomer data get
    $('#customerSelect').change(function () {
      var customerId = $(this).val();
      if (customerId) {
        $.ajax({
          url: '{{ route("business.salescustomers.getCustomerInfo") }}',
          type: 'GET',
          data: { sale_cus_id: customerId },
          success: function (response) {
              if (response.success) {
                
                  var customer = response.data;
                  // console.log(customer);
                

                  var customerInfoHtml = `
                      <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                      <p class="company_details_text"><strong>${customer.sale_cus_business_name}</strong></p>
                      <p class="company_details_text">${customer.sale_cus_first_name} ${customer.sale_cus_last_name}</p>
                      <p class="company_details_text">${customer.sale_bill_address1}, ${customer.sale_bill_address2}, ${customer.sale_bill_city_name}, ${customer.sale_bill_zipcode}</p>
                      <p class="company_details_text">${customer.state.name}</p>
                      <p class="company_details_text">${customer.country.name}</p>

                      <div class="edit_es_text customer" data-toggle="modal" data-target="#editcustor_modal_${customer.sale_cus_id}" data-id="${customer.sale_cus_id}">
                    <i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit ${customer.sale_cus_first_name} ${customer.sale_cus_last_name}
                      </div>
                      <div class="edit_es_text customer_list">
                          <i class="fas fa-solid fa-user-plus mr-2"></i>Choose a Different Customer
                      </div>
                  `;
                  $('#customerInfo').html(customerInfoHtml).show();
                  $('.add_customer_list').hide();

                  $('#sale_bill_currency_id').val(customer.sale_bill_currency_id).trigger('change');

                    // If using Select2 or similar, trigger the change event to update the UI
                    $('#sale_bill_currency_id').trigger('change.select2');

                  var customer_id = customer.sale_cus_id;
                  var formActionUrl = "{{ route('salescustomers.update', ['sale_cus_id' => '__customer_id__']) }}".replace('__customer_id__', customer_id);

                  // Set the form action URL
                  var form = $(`#editCustomerForm_${customer_id}`);
                  form.attr('action', formActionUrl);

                  if ($(`#editcustor_modal_${customer.sale_cus_id}`).length === 0) {
                        var modalHtml = `
                            <div class="modal fade" id="editcustor_modal_${customer.sale_cus_id }" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                             <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Customer</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form id="editCustomerForm_${customer.sale_cus_id}" class="ajax-form" method="POST" data-customer-id="${customer.sale_cus_id}">
                                  @csrf
                                  @method('PUT')
                                    <input type="hidden" name="sale_cus_id" value="${customer.sale_cus_id}">
                                  <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
                                    <ul class="nav nav-pills p-2 tab_box">
                                      <li class="nav-item"><a class="nav-link active" href="#editcontactajax" data-toggle="tab">Contact</a></li>
                                      <li class="nav-item"><a class="nav-link" href="#editbillinajax" data-toggle="tab">Billing</a></li>
                                      <li class="nav-item"><a class="nav-link" href="#editshippingajax" data-toggle="tab">Shipping</a></li>
                                      <li class="nav-item"><a class="nav-link" href="#editmoreajax" data-toggle="tab">More</a></li>
                                    </ul>
                                  </div><!-- /.card-header -->

                                  <div class="tab-content">
                                    <div class="tab-pane active" id="editcontactajax">
                                  
                                    <input type="hidden" name="sale_cus_id" value="${customer.sale_cus_id }">
                                        <div class="row pxy-15 px-10">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="customer">Customer <span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" id="customer" name="sale_cus_business_name" placeholder="Business Or Person" required value="${customer.sale_cus_business_name }">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customer_email">Email</label>
                                              <input type="email" class="form-control" name="sale_cus_email" id="customer_email" placeholder="Enter Email" value="${customer.sale_cus_email }">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customer_phonenumber">Phone</label>
                                              <input type="Number" name="sale_cus_phone" class="form-control" id="customer_phonenumber" placeholder="Enter Phone Number" value="${customer.sale_cus_phone }">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customer_firstname">First Name</label>
                                              <input type="text"  class="form-control" name="sale_cus_first_name" id="customer_firstname" placeholder="First Name" value="${customer.sale_cus_first_name }">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customer_lastname">Last Name</label>
                                              <input type="text" name="sale_cus_last_name" class="form-control" id="customer_lastname" placeholder="Last Name" value="${customer.sale_cus_last_name }">
                                            </div>
                                          </div>
                                        </div>
                                      
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="editbillinajax">
                                    
                                        <div class="row pxy-15 px-10">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="sale_bill_currency_id_${customer.sale_cus_id}">Currency</label>
                                                <select id="sale_bill_currency_id_${customer.sale_cus_id}" name="sale_bill_currency_id" class="form-control select2" style="width: 100%;" required>
                                                    <option value="" default>Select a Currency...</option>
                                                    
                                                    @foreach($currencys as $cur)
                                                        <option value="{{ $cur->id }}" ${customer.sale_bill_currency_id === "{{ $cur->id }}" ? 'selected' : ''}>
                                                            {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal_sub_title">Billing Address</div>
                                        <div class="row pxy-15 px-10">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businessaddress1">Address Line 1</label>
                                              <input type="text" class="form-control" id="company-businessaddress1" name="sale_bill_address1" value="${customer.sale_bill_address1 }" placeholder="Enter a Location">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businessaddress2">Address Line 2</label>
                                              <input type="text" class="form-control" id="company-businessaddress2" name="sale_bill_address2" value="${customer.sale_bill_address2 }" placeholder="Enter a Location">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businesscity">City</label>
                                              <input type="text" class="form-control" id="bill_city"  id="company-businesscity" value="${customer.sale_bill_city_name }" placeholder="Enter A City">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businesszipcode">Postal/ZIP Code</label>
                                              <input type="text" class="form-control" name="sale_bill_zipcode" id="company-businesszipcode" placeholder="Enter a Zip Code" value="${customer.sale_bill_zipcode }">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="sale_bill_country_id_${customer.sale_cus_id}">Country</label>
                                                <select id="sale_bill_country_id_${customer.sale_cus_id}" name="sale_bill_country_id" class="form-control select2 bill_country" style="width: 100%;" data-target="#sale_bill_state_id_${customer.sale_cus_id}" data-url="{{ url('business/getstates') }}" required>
                                                    <option value="" default>Select a Country...</option>
                                                    @foreach($countries as $con)
                                                        <option value="{{ $con->id }}" ${customer.sale_bill_country_id === "{{ $cur->id }}" ? 'selected' : ''}>
                                                       {{ $con->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="sale_bill_state_id_${customer.sale_cus_id}">State</label>
                                                <select id="sale_bill_state_id_${customer.sale_cus_id}" name="sale_bill_state_id" class="form-control select2" style="width: 100%;" required>
                                                    <option value="" default>Select a State...</option>
                                                    @foreach($customer_states as $state)
                                                        <option value="{{ $state->id }}" ${customer.sale_bill_state_id === "{{ $cur->id }}" ? 'selected' : ''}>
                                                       {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          </div>
                                        </div>
                                      
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="editshippingajax">
                                  
                                        <div class="modal_sub_title px-15">Shipping Address</div>
                                        <div class="row pxy-15 px-10">
                                          <div class="col-md-12">
                                            <div class="icheck-primary">
                                              <input type="radio" id="shippingaddress" name="shipping" name="sale_same_address" value="on" ${customer.sale_same_address === 'on' ? 'checked' : ''}>
                                              <label for="shippingaddress">Same As Billing Address</label>
                                      
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customer">Ship to Contact <span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" name="sale_ship_shipto" id="customer" placeholder="Business Or Person" required value="${customer.sale_ship_shipto}">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customer_phonenumber">Phone</label>
                                              <input type="Number" class="form-control" name="sale_ship_phone" id="customer_phonenumber" placeholder="Enter Phone Number" value="${customer.sale_ship_phone}">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businessaddress1">Address Line 1</label>
                                              <input type="text" class="form-control" name="sale_ship_address1" id="company-businessaddress1" placeholder="Enter a Location" value="${customer.sale_ship_address1}">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businessaddress2">Address Line 2</label>
                                              <input type="text" class="form-control" id="company-businessaddress2" placeholder="Enter a Location" name="sale_ship_address2" value="${customer.sale_ship_address2}">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businesscity">City</label>
                                              <input type="text" class="form-control" name="sale_ship_city_name" id="company-businesscity"  placeholder="Enter A City" value="${customer.sale_ship_city_name}">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="company-businesszipcode">Postal/ZIP Code</label>
                                              <input type="text" class="form-control" id="company-businesszipcode" placeholder="Enter a Zip Code" name="sale_ship_zipcode" value="${customer.sale_ship_zipcode}">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="sale_ship_country_id_${customer.sale_cus_id}">Country</label>
                                                <select id="sale_ship_country_id_${customer.sale_cus_id}" name="sale_ship_country_id" class="form-control select2 ship_country" style="width: 100%;" required data-target="#sale_ship_state_id_${customer.sale_cus_id}" data-url="{{ url('business/getstates') }}">
                                                    <option value="" default>Select a Country...</option>
                                                    @foreach($currencys as $cont)
                                                        <option value="{{ $cont->id }}" >
                                                       {{ $cont->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="sale_ship_state_id_${customer.sale_cus_id}">State</label>
                                                <select id="sale_ship_state_id_${customer.sale_cus_id}" name="sale_ship_state_id" class="form-control select2" style="width: 100%;" >
                                                    <option value="" default>Select a State...</option>
                                                    @foreach($ship_state as $statest)
                                                        <option value="{{ $statest->id }}" ${customer.sale_ship_state_id === "{{ $cur->id }}" ? 'selected' : ''}>
                                                       {{ $statest->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="deliveryinstructions">Delivery instructions</label>
                                              <input type="text" class="form-control" name="sale_ship_delivery_desc" id="deliveryinstructions" placeholder="" value="${customer.sale_ship_delivery_desc}">
                                            </div>
                                          </div>
                                        </div>
                                  
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="editmoreajax">
                                  
                                        <div class="row pxy-15 px-10">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customeraccountnumber">Account Number</label>
                                              <input type="Number" class="form-control" name="sale_cus_account_number" id="customeraccountnumber" placeholder="" value="${customer.sale_cus_account_number}">
                                            </div>
                                          </div>
                                                            
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="customerwebsite">Website</label>
                                              <input type="text" class="form-control" name="sale_cus_website"  id="customerwebsite" placeholder="" value="${customer.sale_cus_website}">
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
                                  <button type="submit" form="editCustomerForm_${customer.sale_cus_id}" class="add_btn">Save</button>
                                </div>
                                </form>
                              </div>
                            </div>
                            </div>
                        `;
                        $('body').append(modalHtml);

                         // Set the selected value in the dropdown
                         var selectcurrency = $(`#sale_bill_currency_id_${customer.sale_cus_id}`);
                         selectcurrency.val(customer.sale_bill_currency_id).trigger('change');

                        var selectcountry = $(`#sale_bill_country_id_${customer.sale_cus_id}`);
                        selectcountry.val(customer.sale_bill_country_id).trigger('change');

                        var selectstate = $(`#sale_bill_state_id_${customer.sale_cus_id}`);
                        selectstate.val(customer.sale_bill_state_id).trigger('change');

                        var shipselectstate = $(`#sale_ship_state_id_${customer.sale_cus_id}`);
                        shipselectstate.val(customer.sale_ship_state_id).trigger('change');

                        var shipselectcountry = $(`#sale_ship_country_id_${customer.sale_cus_id}`);
                        shipselectcountry.val(customer.sale_ship_country_id).trigger('change');

                        
                        selectcurrency.select2();
                        selectcountry.select2();
                        selectstate.select2();
                        shipselectcountry.select2();
                        shipselectstate.select2();

                        function loadStates($countryDropdown, selectedStateId) {
                          var countryId = $countryDropdown.val();
                          var targetSelector = $countryDropdown.data('target');
                          var url = $countryDropdown.data('url');
                          var $stateDropdown = $(targetSelector);

                          if (countryId) {
                              $.ajax({
                                  url: url + '/' + countryId,
                                  type: 'GET',
                                  dataType: 'json',
                                  success: function(response) {
                                      if (response) {
                                          $stateDropdown.empty();
                                          $stateDropdown.append('<option value="">Select State...</option>');
                                          $.each(response, function(key, state) {
                                              $stateDropdown.append('<option value="'+ state.id +'">'+ state.name +'</option>');
                                          });
                                          if (selectedStateId) {
                                              $stateDropdown.val(selectedStateId).trigger('change');
                                          }
                                          $stateDropdown.select2();
                                      }
                                  },
                                  error: function(xhr, status, error) {
                                      console.error('AJAX Error: ', status, error);
                                  }
                              });
                          } else {
                              $stateDropdown.empty();
                              $stateDropdown.append('<option value="">Select State...</option>');
                          }
                      }
                      
                      function loadShipStates($countryDropdown, selectedStateId) {
                        var countryId = $countryDropdown.val();
                        var targetSelector = $countryDropdown.data('target');
                        var url = $countryDropdown.data('url');
                        var $stateDropdown = $(targetSelector);

                        if (countryId) {
                            $.ajax({
                                url: url + '/' + countryId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    if (response) {
                                        $stateDropdown.empty();
                                        $stateDropdown.append('<option value="">Select State...</option>');
                                        $.each(response, function(key, state) {
                                            $stateDropdown.append('<option value="'+ state.id +'">'+ state.name +'</option>');
                                        });
                                        if (selectedStateId) {
                                            $stateDropdown.val(selectedStateId).trigger('change');
                                        }
                                        $stateDropdown.select2();
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX Error: ', status, error);
                                }
                            });
                        } else {
                            $stateDropdown.empty();
                            $stateDropdown.append('<option value="">Select State...</option>');
                        }
                      }  
                      // Bind change event for bill_country
                      $(document).on('change', '.bill_country', function() {
                          loadStates($(this));
                      });

                      $(document).on('change', '.ship_country', function() {
                          loadShipStates($(this));
                      });

                      // Pre-select the state for an existing customer
                      loadStates($(`#sale_bill_country_id_${customer.sale_cus_id}`), customer.sale_bill_state_id);

                      loadShipStates($(`#sale_ship_country_id_${customer.sale_cus_id}`), customer.sale_ship_state_id);

    
                      
                    }
                    $('.select2').select2();
                    // Event delegation for dynamically added content
                    $('#customerInfo').on('click', '.customer', function (e) {
                        e.preventDefault();
                        var customerId = $(this).data('id');
                        $(`#editcustor_modal_${customerId}`).modal('show');
                    });


                    // Show the new modal
                  
                  // Event delegation for dynamically added content
                  $('#customerInfo').on('click', '.customer_list', function (e) {
                      e.preventDefault();
                      $('#customerInfo').hide(); // Hide the customer info
                      $('.add_customer_list').show(); // Show the dropdown list
                      $('#customerSelect').focus(); // Set focus to the select element
                  });


                    // Show the modal
                    // $(`#editcustor_modal_${customer.sale_cus_id}`).modal('show');
                  
              } else {
                  // alert(response.message);
              }
          },

          error: function () {
            // alert('Error retrieving customer information');
          }
        });
      } else {
        $('#customerInfo').hide();
      }
    });




    // Function to calculate my items amount
    function calculateTotals() {
      const currencySymbol = $('#sale_currency_id option:selected').data('symbol') || '$'; // Retrieve currency symbol

      let subTotal = 0;
      let totalDiscount = 0;
      let totalTax = 0;
      let total = 0;

      // Calculate item totals
      $('.item-row').each(function () {
        const qty = parseFloat($(this).find('input[name="items[][sale_estim_item_qty]"]').val()) || 0;
        const price = parseFloat($(this).find('input[name="items[][sale_estim_item_price]"]').val()) || 0;
        const itemDiscount = parseFloat($(this).find('input[name="sale_estim_item_discount"]').val()) || 0;
        const itemTotal = qty * price;
        const discountAmount = itemDiscount; 
        const taxableAmount = itemTotal - discountAmount;

        subTotal += itemTotal;
        totalDiscount += discountAmount;

        // Tax rate 
        const itemTaxRate = parseFloat($(this).find('select[name="items[][sale_estim_item_tax]"] option:selected').data('tax-rate')) || 0;
        const itemTax = taxableAmount * (itemTaxRate / 100);
        totalTax += itemTax;

        // Update the price for the current item
        const itemTotalPrice = itemTotal;
        $(this).find('.item-price').text(`${itemTotalPrice.toFixed(2)}`);

      });

      //apply discount
      const globalDiscountValue = parseFloat($('input[name="sale_estim_item_discount"]').val()) || 0;
      const discountType = $('select[name="sale_estim_discount_type"]').val(); // 1 for $, 2 for %
      // alert(discountType);
      if (discountType == '2') { 
        totalDiscount = (subTotal * globalDiscountValue) / 100;
      } else { 
        totalDiscount = globalDiscountValue;
      }
      
      $('#sale_estim_discount_type option[value="1"]').text(currencySymbol);
      total = subTotal - totalDiscount + totalTax;

      // Update calculated values
      $('#sub-total').text(`${currencySymbol}${subTotal.toFixed(2)}`);
      $('#discount').text(`${currencySymbol}${totalDiscount.toFixed(2)}`);
      $('#tax').text(`${currencySymbol}${totalTax.toFixed(2)}`);
      $('#total').text(`${currencySymbol}${total.toFixed(2)}`);

      $('input[name="sale_estim_sub_total"]').val(subTotal.toFixed(2));
      $('input[name="sale_estim_discount_total"]').val(totalDiscount.toFixed(2));
      $('input[name="sale_estim_tax_amount"]').val(totalTax.toFixed(2));
      $('input[name="sale_estim_final_amount"]').val(total.toFixed(2));


    }

    // changes in product select
    $(document).on('change', 'select[name="items[][sale_product_id]"]', function () {
      var selectedProductId = $(this).val();
      var $row = $(this).closest('.item-row');

      if (selectedProductId) {
        $.ajax({
          url: '{{ route('business.estimates.getProductDetails', '') }}/' + selectedProductId,
          method: 'GET',
          success: function (response) {
            $row.find('input[name="items[][sale_estim_item_price]"]').val(response.sale_product_price);
            $row.find('input[name="items[][sale_estim_item_desc]"]').val(response.sale_product_desc);
            $row.find('input[name="sale_estim_item_discount').val(0); // Default discount value
            $row.find('input[name="items[][sale_estim_item_qty]"]').val(1);
            // $row.find('select[name="items[][sale_currency_id]"]').val(response.sale_product_currency_id).trigger('change');
            $row.find('select[name="items[][sale_estim_item_tax]"]').val(response.sale_product_tax).trigger('change');

            $row.find('.item-price').text('$' + parseFloat(response.sale_product_price).toFixed(2));

            calculateTotals(); 
          }
        });
      }
    });

    // Handle changes in quantity, price, discount, and tax inputs
    $(document).on('input', 'input[name="items[][sale_estim_item_qty]"], input[name="items[][sale_estim_item_price]"], input[name="sale_estim_item_discount"], select[name="items[][sale_estim_item_tax]"], select[name="sale_estim_discount_type"]', function () {
      calculateTotals(); 
    });

    // item removal
    $(document).on('click', '.delete-item', function () {
      $(this).closest('.item-row').remove();
      calculateTotals(); 
    });

    // global discount input change
    $(document).on('input', 'input[name="sale_estim_item_discount"]', function () {
      calculateTotals();
    });

    $('#sale_currency_id').on('change', function () {
        calculateTotals(); // Recalculate totals when currency changes
    });

  });


</script>

<script>
  $(document).ready(function () {
    let rowCount = 1;

    $('#add').click(function () {
      rowCount++;
      $('#dynamic_field').append(`
            <tr class="item-row" id="row${rowCount}">
                <td>
                    <div>
                        <select class="form-control select2" name="items[][sale_product_id]" style="width: 100%;">
                            <option>Select Items</option>
                            @foreach($products as $product)
                <option value="{{ $product->sale_product_id }}">{{ $product->sale_product_name }}</option>
              @endforeach
                        </select>
                        <input type="text" class="form-control px-10" name="items[][sale_estim_item_desc]" placeholder="Enter item description">
                    </div>
                </td>
                <td><input type="number" class="form-control" name="items[][sale_estim_item_qty]" min="1"></td>
                <td>
                    <div class="d-flex">
                        <input type="text" name="items[][sale_estim_item_price]" class="form-control" aria-describedby="inputGroupPrepend">
                       
                    </div>
                </td>
                <td>
                    <select class="form-control select2" name="items[][sale_estim_item_tax]" style="width: 100%;">
                        @foreach($salestax as $salesTax)
                        <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}">{{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%</option>
                      @endforeach
                    </select>
                    <div class="px-10"></div>
                    <select class="form-control select2" name="items[][sale_estim_item_tax]" style="width: 100%;">
                        @foreach($salestax as $salesTax)
                        <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}">{{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%</option>
                      @endforeach
                    </select>
                </td>
                <td class="text-right item-price">0.00</td>
                <td class="text-right"><i class="fa fa-trash delete_icon_grid delete-item" id="${rowCount}"></i></td>
            </tr>
        `);

      $('.select2').select2();
    });

    $(document).on('click', '.delete-item', function () {
      var rowId = $(this).attr("id");
      $('#row' + rowId).remove();
    });




  });
  //update estimate data
    $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#items-form').on('submit', function (e) {
      e.preventDefault();

      let formData = {};

      $('.item-row').each(function (index) {
        const rowIndex = index;
        formData[`items[${rowIndex}][sale_product_id]`] = $(this).find('select[name="items[][sale_product_id]"]').val();
        formData[`items[${rowIndex}][sale_estim_item_desc]`] = $(this).find('input[name="items[][sale_estim_item_desc]"]').val();
        formData[`items[${rowIndex}][sale_estim_item_qty]`] = $(this).find('input[name="items[][sale_estim_item_qty]"]').val();
        formData[`items[${rowIndex}][sale_estim_item_price]`] = $(this).find('input[name="items[][sale_estim_item_price]"]').val();
        formData[`items[${rowIndex}][sale_estim_item_tax]`] = $(this).find('select[name="items[][sale_estim_item_tax]"]').val();
      });

      formData['sale_estim_item_discount'] = $('input[name="sale_estim_item_discount"]').val();
      formData['sale_estim_discount_type'] = $('select[name="sale_estim_discount_type"]').val();
      formData['sale_estim_title'] = $('input[name="sale_estim_title"]').val();
      formData['sale_estim_summary'] = $('input[name="sale_estim_summary"]').val();
      formData['sale_cus_id'] = $('select[name="sale_cus_id"]').val();
      formData['sale_estim_number'] = $('input[name="sale_estim_number"]').val();
      formData['sale_estim_customer_ref'] = $('input[name="sale_estim_customer_ref"]').val();
      formData['sale_estim_date'] = $('input[name="sale_estim_date"]').val();
      formData['sale_estim_valid_date'] = $('input[name="sale_estim_valid_date"]').val();
      formData['sale_estim_discount_desc'] = $('input[name="sale_estim_discount_desc"]').val();
      formData['sale_estim_sub_total'] = $('input[name="sale_estim_sub_total"]').val();
      formData['sale_estim_discount_total'] = $('input[name="sale_estim_discount_total"]').val();
      formData['sale_estim_tax_amount'] = $('input[name="sale_estim_tax_amount"]').val();
      formData['sale_estim_final_amount'] = $('input[name="sale_estim_final_amount"]').val();
      formData['sale_estim_notes'] = $('#inputDescription[name="sale_estim_notes"]').val();
      formData['sale_estim_footer_note'] = $('#inputDescription[name="sale_estim_footer_note"]').val();
      formData['sale_status'] = 0;
      formData['sale_currency_id'] = $('select[name="sale_currency_id"]').val();
      formData['sale_total_days'] = $('#hidden-total-days[name="sale_total_days"]').val();


      $.ajax({
        url: "{{ route('business.estimates.duplicateStore', ['id' => $estimates->sale_estim_id]) }}",
        method: 'PATCH',
        data: formData,
        success: function (response) {
          window.location.href = response.redirect_url;

          // alert('Items saved successfully!');

          // $('#items-form')[0].reset();
          // $('#dynamic_field').find('.item-row').remove();
        },
        error: function (xhr) {
        if (xhr.status === 422) {
        var errors = xhr.responseJSON.errors;
        console.log(errors); // Debug the errors object

        // Clear previous error messages
        $('.error-message').html('');
        $('input, select').removeClass('is-invalid');

        var firstErrorField = null; // Variable to store the first error field

        $.each(errors, function (field, messages) {
          // Replace characters to match the format of your HTML IDs
          var fieldId = field.replace(/\./g, '_').replace(/\[\]/g, '_');
          var errorMessageContainerId = 'error_' + fieldId;
          var errorMessageContainer = $('#' + errorMessageContainerId);

          if (errorMessageContainer.length) {
          errorMessageContainer.html(messages.join('<br>'));

          // Find the input field related to the error
          var $field = $('[name="' + field + '"]');

          if ($field.length > 0) {
            $field.addClass('is-invalid');
            
            // Set first error field for scrolling
            if (!firstErrorField) {
            firstErrorField = $field;
            }
            scrollToCenter($field);
          } else {
            // console.log('Field not found for:', field);
          }
          } else {
          // console.log('Error container not found for:', errorMessageContainerId);
          }
        });


        } else {
        // console.log('An error occurred: ' + xhr.statusText);
        }
      }
     
      });
    });

  });

  function scrollToCenter($element) {
      if ($element.length) {
          var elementOffset = $element.offset(); // Get element's offset
          var elementTop = elementOffset.top; // Get element's top position
          var elementHeight = $element.outerHeight(); // Get element's height
          var windowHeight = $(window).height(); // Get window height

          // Calculate the scroll position to center the element
          var scrollTop = elementTop - (windowHeight / 2) + (elementHeight / 2);

          // Scroll to the calculated position
          $('html, body').scrollTop(scrollTop);
      } else {
          // console.log('Element not found or has zero length.');
      }
    }
    
  $(document).ready(function() {
    $('#editCustomerForm').on('submit', function(e) {
      // alert('hii');
    e.preventDefault();

    var saleCusId = $(this).find('input[name="sale_cus_id"]').val();
    // alert(saleCusId);

    $.ajax({
        url: "{{ route('salescustomers.update', ['sale_cus_id' => $estimates->sale_cus_id]) }}",
        type: 'PUT',
        data: $(this).serialize(), 
        success: function(response) {
            // Assuming 'response' contains the updated customer data
            // console.log(response.customer)
            var customer = response.customer;
            // console.log(customer);

            var customerInfoHtml = `
                <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                <p class="company_details_text"><strong>${customer.sale_cus_business_name}</strong></p>
                <p class="company_details_text">${customer.sale_cus_first_name} ${customer.sale_cus_last_name}</p>
                <p class="company_details_text">${customer.sale_cus_account_number}</p>
                <p class="company_details_text">${customer.sale_cus_website}</p>
                <p class="company_details_text">${customer.sale_bill_address1}, ${customer.sale_bill_address2}, ${customer.sale_bill_city_name}, ${customer.sale_bill_zipcode}</p>
                <p class="company_details_text">${customer.state.name}</p>
                <p class="company_details_text">${customer.country.name}</p>

                <p class="company_business_name" style="text-decoration: underline;">Ship To</p>
                <p class="company_details_text">${customer.sale_ship_address1}, ${customer.sale_ship_address2}, ${customer.sale_ship_city_name}, ${customer.sale_ship_zipcode}</p>
                <p class="company_details_text">${customer.sale_ship_phone}</p>

                <p class="company_details_text">${customer.sale_cus_email}</p>
                <p class="company_details_text">${customer.sale_cus_phone}</p>

                <div class="edit_es_text" data-toggle="modal" data-target="#editcustor_modal_${customer.sale_cus_id}" data-id="${customer.sale_cus_id}">

                    <i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit ${customer.sale_cus_first_name} ${customer.sale_cus_last_name}
                </div>

                <div class="edit_es_text customer_list">
                        <i class="fas fa-solid fa-user-plus mr-2"></i>Choose a Different Customer
                    </div>

            `;
            
            // Update the customer info section with the new data
            $('#customerInfo').html(customerInfoHtml).show();

            // Hide the modal
            $('#editcustor_modal_' + saleCusId).modal('hide');
            
            $('#customer_list').hide();
            $('.list2').hide();
            // Event delegation for dynamically added content
            $('#customerInfo').on('click', '.customer_list', function (e) {
                $('#customerInfo').hide(); // Hide the customer info
                $('.add_customer_list').show(); // Show the dropdown list
                $('#customerSelect').focus(); // Set focus to the select element
            });

            

            updateCustomerDropdown();

             

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



function updateCustomerDropdown() {
        $.ajax({
            url: "{{ route('salescustomers.list') }}", 
            type: 'GET',
            success: function(customers) {
                var customerSelect = $('#customerSelect');
                customerSelect.empty(); 
                
                customers.forEach(function(customer) {
                    var optionHtml = `<option value="${customer.sale_cus_id}">${customer.sale_cus_business_name}</option>`;
                    customerSelect.append(optionHtml);
                });

                
            },
            error: function(xhr) {
            if(xhr.status === 422) { // Laravel validation error status
                var errors = xhr.responseJSON.errors;
                displayValidationErrors(errors);
            } else {
                console.log('An error occurred: ' + xhr.statusText);
            }
        }
        });
    }
    
});

$(document).ready(function() {
    $(document).on('submit', 'form.ajax-form', function(e) {
      // alert('hii');
        e.preventDefault();
        
        var form = $(this);
        var customerId = form.data('customer-id');  
        var formData = form.serialize();
        var formAction = "{{ route('salescustomers.update', ['sale_cus_id' => '__customer_id__']) }}".replace('__customer_id__', customerId);

        $.ajax({
            url: formAction,
            type: 'PUT',
            data: formData,
            success: function(response) {
                var customer = response.customer;

                var customerInfoHtml = `
                    <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                    <p class="company_details_text"><strong>${customer.sale_cus_business_name}</strong></p>
                    <p class="company_details_text">${customer.sale_cus_first_name} ${customer.sale_cus_last_name}</p>
                    <p class="company_details_text">${customer.sale_cus_account_number}</p>
                    <p class="company_details_text">${customer.sale_cus_website}</p>
                    <p class="company_details_text">${customer.sale_bill_address1}, ${customer.sale_bill_address2}, ${customer.sale_bill_city_name}, ${customer.sale_bill_zipcode}</p>
                    <p class="company_details_text">${customer.state.name}</p>
                    <p class="company_details_text">${customer.country.name}</p>

                    <p class="company_business_name" style="text-decoration: underline;">Ship To</p>
                    <p class="company_details_text">${customer.sale_ship_address1}, ${customer.sale_ship_address2}, ${customer.sale_ship_city_name}, ${customer.sale_ship_zipcode}</p>
                    <p class="company_details_text">${customer.sale_ship_phone}</p>

                    <p class="company_details_text">${customer.sale_cus_email}</p>
                    <p class="company_details_text">${customer.sale_cus_phone}</p>

                    <div class="edit_es_text" data-toggle="modal" data-target="#editcustor_modal_${customer.sale_cus_id}" data-id="${customer.sale_cus_id}">
                        <i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit ${customer.sale_cus_first_name} ${customer.sale_cus_last_name}
                    </div>
                    <div class="edit_es_text customer_list">
                        <i class="fas fa-solid fa-user-plus mr-2"></i>Choose a Different Customer
                    </div>
                `;

                $('#customerInfo').html(customerInfoHtml).show();

                $('#editcustor_modal_' + customer.sale_cus_id).modal('hide');

                updateCustomerDropdown();
            },
            error: function(xhr) {
                console.log('An error occurred: ' + xhr.statusText);
            }
        });
    });

    function updateCustomerDropdown() {
        $.ajax({
            url: "{{ route('salescustomers.list') }}", 
            type: 'GET',
            success: function(customers) {
                var customerSelect = $('#customerSelect');
                customerSelect.empty(); 
                
                customers.forEach(function(customer) {
                    var optionHtml = `<option value="${customer.sale_cus_id}">${customer.sale_cus_business_name}</option>`;
                    customerSelect.append(optionHtml);
                });

            },
            error: function(xhr) {
                console.log('Failed to update customer dropdown: ' + xhr.statusText);
            }
        });
    }

   
}); 


</script>
<script>
    $(document).ready(function() {
        $('#bill_country').change(function() {
         
            var country_id = $(this).val();
            alert(country_id);
            if (country_id) {
                $.ajax({
                    url: '{{ url('business/getstates') }}/' + country_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#bill_state').empty();
                        $('#bill_state').append('<option value="">Select State</option>');
                        $.each(data, function(key, value) {
                            $('#bill_state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#bill_state').empty();
                $('#bill_state').append('<option value="">Select State</option>');
            }
        });

        $('#ship_country').change(function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                  url: '{{ url('business/getstates') }}/' + country_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#ship_state').empty();
                        $('#ship_state').append('<option value="">Select State</option>');
                        $.each(data, function(key, value) {
                            $('#ship_state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#ship_state').empty();
                $('#ship_state').append('<option value="">Select State</option>');
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var fromInput = document.getElementById('from-datepicker-hidden');
    var toInput = document.getElementById('to-datepicker-hidden');

    // console.log('From Input Value:', fromInput ? fromInput.value : 'No value');
    // console.log('To Input Value:', toInput ? toInput.value : 'No value');

    if (fromInput && toInput) {
        var fromdatepicker = flatpickr("#from-datepicker", {
          locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "m/d/Y",
            allowInput: true,
            defaultDate: fromInput.value || null,
            onChange: calculateDays
        });

        var todatepicker = flatpickr("#to-datepicker", {
          locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "m/d/Y",
            allowInput: true,
            defaultDate: toInput.value || null ,
            onChange: calculateDays
        });

        document.getElementById('from-calendar-icon').addEventListener('click', function() {
            fromdatepicker.open(); 
        });

        document.getElementById('to-calendar-icon').addEventListener('click', function() {
            todatepicker.open(); 
        });

        function calculateDays() {
        var sdate = fromdatepicker.input.value;  
        var edate = todatepicker.input.value;  
        var totalDays = 0;   

        if(sdate && edate) {
            var startDate = new Date(sdate);
            var endDate = new Date(edate);

            var timeDifference = endDate.getTime() - startDate.getTime();

            var totalDays = timeDifference / (1000 * 3600 * 24); 

            if (totalDays < 0) {
            document.getElementById("total-days").innerText = "Invalid date range"; 
            document.getElementById("hidden-total-days").value = ''; 

          } else {
              document.getElementById("total-days").innerText = totalDays; 
              document.getElementById("hidden-total-days").value = totalDays; 
          }

        }

      }

    } else {
        console.error('Hidden input elements not found or have no value');
    }
});

    </script>
  <script>
    $(document).ready(function () {
    $('#estimateForm').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
      url: $(this).attr('action'),
      type: 'PATCH',
      data: $(this).serialize(),
      success: function (response) {
        // console.log(response); 

        if (response.success) {
        updateTableHeaders();
        $('#editcolum').modal('hide');
        // alert(response.message);
        } else {
        alert('An unexpected error occurred.');
        }
      },
      error: function (xhr) {
        alert('An error occurred while updating the menu.');
      }
      });
    });

    function updateTableHeaders() {
      $.ajax({
      url: '{{ route('estimatemenus.menulist') }}',
      type: 'GET',
      success: function (data) {
        // console.log(data);
        // $('#itemsHeader').text(data.Items_other || data.Items || 'Items');
        // $('#unitsHeader').text(data.Units_other || data.Units || 'Units');
        // $('#priceHeader').text(data.Price_other || data.Price || 'Price');
        // $('#amountHeader').text(data.Amount_other || data.Amount || 'Amount');

        $('#itemsHeader').html(getHeaderTextWithIcon(
        data.Items_other || (data.Items === "Items (Default)" ? "Items" : data.Items),
        data.hide_items
        ));
        $('#unitsHeader').html(getHeaderTextWithIcon(
        data.Units_other || (data.Units === "Quantity (Default)" ? "Quantity" : data.Units),
        data.hide_units
        ));
        $('#priceHeader').html(getHeaderTextWithIcon(
        data.Price_other || (data.Price === "Price (Default)" ? "Price" : data.Price),
        data.hide_price
        ));
        $('#amountHeader').html(getHeaderTextWithIcon(
        data.Amount_other || (data.Amount === "Amount (Default)" ? "Amount" : data.Amount),
        data.hide_amount
        ));
      },
      error: function (xhr) {
        console.error('Failed to retrieve session data.');
      }
      });
    }

    function getHeaderTextWithIcon(headerText, hideIcon) {
      if (hideIcon === "on") {
      return `${headerText} <i class="fa fa-eye-slash" aria-hidden="true"></i>`;
      } else {
      return headerText;
      }
    }
    });
  </script>
@endsection
@endif
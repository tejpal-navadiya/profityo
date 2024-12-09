<?php //dd($access); ?>
@extends('masteradmin.layouts.app')
<title>Profityo | View All Estimates</title>
@if(isset($access['view_estimates']) && $access['view_estimates'] == 1) 
@section('content')
<!-- @include('flatpickr::components.style') -->
<link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
        <div class="col-auto">
          <h1 class="m-0">{{ __('Estimates') }}</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ __('Estimates') }}</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
          @if(isset($access['add_estimates']) && $access['add_estimates']) 
            <a href="{{ route('business.estimates.create') }}"><button class="add_btn"><i
                  class="fas fa-plus add_plus_icon"></i>{{ __('Create Estimate') }}</button></a>
          @endif
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content px-10">
    <div class="container-fluid">
      @if(Session::has('estimate-add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('estimate-add') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('estimate-add');
      @endphp
      @endif

      @if(Session::has('estimate-delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('estimate-delete') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('estimate-delete');
      @endphp
      @endif

    

      <!-- Small boxes (Stat box) -->
      <div class="col-lg-12 fillter_box">
        <div class="row align-items-center justify-content-between">
          <div class="col-auto">
            <p class="m-0 filter-text"><i class="fas fa-solid fa-filter"></i>Filters</p>
          </div><!-- /.col -->
          <div class="col-auto">
            <p class="m-0 float-sm-right filter-text">Clear Filters<i class="fas fa-regular fa-circle-xmark"></i></p>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-3 col-1024 col-md-6 px-10">
            <select id="sale_cus_id" class="form-control select2" style="width: 100%;" name="sale_cus_id">
              <option value="" default>All Customers</option>
              @foreach($salecustomer as $value)
                <option value="{{ $value->sale_cus_id }}">{{ $value->sale_cus_business_name }} </option>
              @endforeach
            </select>
          </div>
          <div class="col-lg-2 col-1024 col-md-6 px-10">
            <select class="form-control form-select" style="width: 100%;" name="sale_status" id="sale_status">
              <option value="">All Statuses</option>
              <option value="Draft">Draft</option>
              <option value="Saved">Saved</option>
              <option value="Sent">Sent</option>
              <option value="Converted">Converted</option>
            </select>
          </div>
          <div class="col-lg-4 col-1024 col-md-6 px-10 d-flex">
            <div class="input-group date" >
              <x-flatpickr id="from-datepicker" placeholder="From"/>
              <div class="input-group-append">
                <span class="input-group-text" id="from-calendar-icon">
                    <i class="fa fa-calendar-alt"></i>
                </span>
              </div>
            </div>

            <div class="input-group date" >
              <x-flatpickr id="to-datepicker" placeholder="To" />
              <div class="input-group-append">
                <span class="input-group-text" id="to-calendar-icon">
                    <i class="fa fa-calendar-alt"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-1024 col-md-6 px-10">
            <div class="input-group">
              <input type="search" class="form-control" name="sale_estim_number"  placeholder="Enter Estimate #" id="sale_estim_number">
              <div class="input-group-append" id="sale_estim_number_submit">
                <button type="submit" class="btn btn-default" >
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div id="filter_data">
      <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
        <ul class="nav nav-pills p-2 tab_box">
          <li class="nav-item"><a class="nav-link active" href="#activeestimate" data-toggle="tab">Active <span
                class="badge badge-toes">{{ count($activeEstimates) }}</span></a></li>
          <li class="nav-item"><a class="nav-link" href="#draftestimate" data-toggle="tab">Draft <span
                class="badge badge-toes">{{ count($draftEstimates) }}</span></a></li>
          <li class="nav-item"><a class="nav-link" href="#allestimate" data-toggle="tab">All</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card px-20">
        <div class="card-body1">
          <div class="tab-content">
            <div class="tab-pane active" id="activeestimate">
              <div class="col-md-12 pad_table">
                <table id="example1" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Customer</th>
                      <th>Number</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($activeEstimates) > 0)
                      @foreach ($activeEstimates as $value)
                        <tr id="estimate-row-approve-{{ $value->sale_estim_id }}">
                          <td>{{ $value->customer->sale_cus_first_name ?? '' }} {{ $value->customer->sale_cus_last_name ?? '' }}</td>
                          <td>{{ $value->sale_estim_number }}</td>
                          <td>{{ \Carbon\Carbon::parse($value->sale_estim_date)->format('M d, Y') }}</td>
                          <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_estim_final_amount }}</td>
                          <td><span class="status_btn">{{ $value->sale_status }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                              @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Saved') {
                                        $nextStatus = 'Send';
                                    } elseif($value->sale_status == 'Sent') {
                                        $nextStatus = 'Convert to Invoice';
                                    } elseif($value->sale_status == 'Converted') {
                                        $nextStatus = 'Duplicate';
                                    }else{
                                      $nextStatus = 'Duplicate';
                                    }
                                @endphp

                                @if($nextStatus)
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_estim_id }}, '{{ $nextStatus }}')" >
                                    {{ $nextStatus }}
                                </a>
                                @else
                                    <span class="d-block">Unknown Status</span>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                @if(isset($access['view_estimates']) && $access['view_estimates'] == 1)   
                                  <a href="{{ route('business.estimates.view', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_estimates']) && $access['update_estimates'] == 1) 
                                  <a href="{{ route('business.estimates.edit', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.estimates.duplicate', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="{{ route('business.estimates.viewInvoice', [$value->sale_estim_id]) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="javascript:void(0);" onclick="sendEstimate('{{ route('business.estimate.send', [$value->sale_estim_id, $user_id]) }}', {{ $value->sale_estim_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_estimates']) && $access['delete_estimates'] == 1) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimateapprove-{{ $value->sale_estim_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                       
                        </tr>
                        
                        <div class="modal fade" id="deleteestimateapprove-{{ $value->sale_estim_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.estimates.destroy', ['id' => $value->sale_estim_id]) }}" id="delete-form-{{ $value->sale_estim_id }}" data-id="{{ $value->sale_estim_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete Customer</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_estim_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>

                      @endforeach
                      @else
                      @endif
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane" id="draftestimate">
              <div class="col-md-12 pad_table">
                <table id="example5" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Customer</th>
                      <th>Number</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($draftEstimates) > 0)
                      @foreach ($draftEstimates as $value)
                        <tr id="estimate-row-draft-{{ $value->sale_estim_id }}">
                          <td>{{ $value->customer->sale_cus_first_name ?? '' }} {{ $value->customer->sale_cus_last_name ?? '' }}</td>
                          <td>{{ $value->sale_estim_number }}</td>
                          <td>{{ \Carbon\Carbon::parse($value->sale_estim_date)->format('M d, Y') }}</td>
                          <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_estim_final_amount }}</td>
                          <td><span class="status_btn">{{ $value->sale_status }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                              @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Saved') {
                                        $nextStatus = 'Send';
                                    } elseif($value->sale_status == 'Sent') {
                                        $nextStatus = 'Convert to Invoice';
                                    } elseif($value->sale_status == 'Converted') {
                                        $nextStatus = 'Duplicate';
                                    }else{
                                      $nextStatus = 'Duplicate';
                                    }
                                @endphp

                                @if($nextStatus)
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_estim_id }}, '{{ $nextStatus }}')" >
                                    {{ $nextStatus }}
                                </a>
                                @else
                                    <span class="d-block">Unknown Status</span>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                @if(isset($access['view_estimates']) && $access['view_estimates'] == 1) 
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="{{ route('business.estimates.view', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_estimates']) && $access['update_estimates'] == 1) 
                                  <a href="{{ route('business.estimates.edit', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.estimates.duplicate', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="{{ route('business.estimates.viewInvoice', [$value->sale_estim_id]) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="javascript:void(0);" onclick="sendEstimate('{{ route('business.estimate.send', [$value->sale_estim_id, $user_id]) }}', {{ $value->sale_estim_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_estimates']) && $access['delete_estimates'] == 1) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimatedraft-{{ $value->sale_estim_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>

                        <div class="modal fade" id="deleteestimatedraft-{{ $value->sale_estim_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <form method="POST" action="{{ route('business.estimates.destroy', ['id' => $value->sale_estim_id]) }}" id="delete-form-{{ $value->sale_estim_id }}" data-id="{{ $value->sale_estim_id }}">
                              @csrf
                              @method('DELETE')
                          <div class="modal-body pad-1 text-center">
                            <i class="fas fa-solid fa-trash delete_icon"></i>
                            <p class="company_business_name px-10"><b>Delete Customer</b></p>
                            <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                          
                              <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                            <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_estim_id }}">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>


                      @endforeach
                    @else
                    
                    @endif
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane" id="allestimate">
              <div class="col-md-12 pad_table">
                <table id="example4" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Customer</th>
                      <th>Number</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($allEstimates) > 0)
                      @foreach ($allEstimates as $value)
                        <tr id="estimate-row-{{ $value->sale_estim_id }}">
                          <td>{{ $value->customer->sale_cus_first_name ?? '' }} {{ $value->customer->sale_cus_last_name ?? '' }}</td>
                          <td>{{ $value->sale_estim_number }}</td>
                          <td>{{ \Carbon\Carbon::parse($value->sale_estim_date)->format('M d, Y') }}</td>
                          <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_estim_final_amount }}</td>
                          <td><span class="status_btn">{{ $value->sale_status }}</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                             
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Saved') {
                                        $nextStatus = 'Send';
                                    } elseif($value->sale_status == 'Sent') {
                                        $nextStatus = 'Convert to Invoice';
                                    } elseif($value->sale_status == 'Converted') {
                                        $nextStatus = 'Duplicate';
                                    }else{
                                      $nextStatus = 'Duplicate';
                                    }
                                @endphp

                                @if($nextStatus)
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_estim_id }}, '{{ $nextStatus }}')" >
                                    {{ $nextStatus }}
                                </a>
                                @else
                                    <span class="d-block">Unknown Status</span>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                               
                                <div class="dropdown-menu dropdown-menu-right">
                                  @if(isset($access['view_estimates']) && $access['view_estimates'] == 1) 
                                  <a href="{{ route('business.estimates.view', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_estimates']) && $access['update_estimates'] == 1) 
                                  <a href="{{ route('business.estimates.edit', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.estimates.duplicate', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="{{ route('business.estimates.viewInvoice', [$value->sale_estim_id]) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="javascript:void(0);"  data-id="{{ $value->sale_estim_id }}" onclick="sendEstimate('{{ route('business.estimate.send', [$value->sale_estim_id, $user_id]) }}', {{ $value->sale_estim_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id, 'download' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_estimates']) && $access['delete_estimates'] == 1) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimatall-{{ $value->sale_estim_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>

                        <div class="modal fade" id="deleteestimatall-{{ $value->sale_estim_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.estimates.destroy', ['id' => $value->sale_estim_id]) }}" id="delete-form-{{ $value->sale_estim_id }}" data-id="{{ $value->sale_estim_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete Customer</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_estim_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>

                      @endforeach
                          @else
                      
                    @endif
                  </tbody>
                </table>
              </div>
            </div>

            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div><!-- /.card-->
      </div>                               
      <!-- /.row (main row) -->
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

<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script>
  function updateStatus(estimateId, nextStatus) {
    $.ajax({
      url: "{{ route('business.estimates.statusStore', ':id') }}".replace(':id', estimateId),
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            sale_status: nextStatus 
        },
        success: function(response) {
          // console.log(response);
            if (response.success) {
              if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                } else {
                    location.reload();
                }
               
            } else {
                // alert(response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while updating the status.');
        }
    });
}

$(document).on('click', '.delete_btn', function() {
    var estimateId = $(this).data('id'); 
    var form = $('#delete-form-' + estimateId);
    var url = form.attr('action'); 

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(), 
        success: function(response) {
            if (response.success) {


              //count update when delete the record 
              var table = $('#example4').DataTable();

                var row = $('#estimate-row-' + estimateId); 

                if (row.length > 0) {
                    table.row(row).remove().draw(false); 
                }
                
                var example5 = $('#example5').DataTable();

                var example5_row = $('#estimate-row-draft-' + estimateId); 

                if (example5_row.length > 0) {
                  example5.row(example5_row).remove().draw(false); 
                }

                var example1 = $('#example1').DataTable();

                var example1_row = $('#estimate-row-approve-' + estimateId); 

                if (example1_row.length > 0) {
                  example1.row(example1_row).remove().draw(false); 
                }

                //delete the list 
                $('#estimate-row-' + estimateId).remove();

                $('#estimate-row-draft-' + estimateId).remove();

                $('#estimate-row-approve-' + estimateId).remove();

                //hide popup when delete record
                $('#deleteestimatall-' + estimateId).modal('hide');
                $('#deleteestimatedraft-' + estimateId).modal('hide');
                $('#deleteestimateapprove-' + estimateId).modal('hide');

                //update the raw count
                updateBadgeCount('.nav-pills .nav-link[href="#activeestimate"] .badge');
                updateBadgeCount('.nav-pills .nav-link[href="#draftestimate"] .badge');

                

                // alert(response.message);
            } else {
                alert('An error occurred: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while deleting the record.');
        }
    });
});

function updateBadgeCount(selector) {
    var badge = $(selector);
    var currentCount = parseInt(badge.text(), 10); 
    if (currentCount > 0) {
        badge.text(currentCount - 1); 
    }
}
</script>
<script>
    function sendEstimate(url, estimateId) {
      // alert(estimateId); 
        if (confirm('Are you sure you want to send this estimate?')) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                   
                    alert('Estimate link sent to the customer successfully.');
                    location.reload(); 
                },
                error: function(xhr) {
                    alert('An error occurred while sending the estimate.');
                }
            });
        }
    }
</script>

<script>
  $(document).ready(function() {
    var defaultStartDate = "";  
    var defaultEndDate = "";    
    var defaultSaleEstimNumber = ""; 
    var defaultSaleCusId = "";  
    var defaultSaleStatus = "";  

  
        $('#from-datepicker').val(defaultStartDate);
   
        $('#to-datepicker').val(defaultEndDate);

        $('#sale_estim_number').val(defaultSaleEstimNumber);

        $('#sale_cus_id').val(defaultSaleCusId);

        $('#sale_status').val(defaultSaleStatus);

        var fromdatepicker = flatpickr("#from-datepicker", {
          locale: 'en',
                altInput: true,
                dateFormat: "MM/DD/YYYY",
                altFormat: "MM/DD/YYYY",
                onChange: function(selectedDates, dateStr, instance) {
        
                      fetchFilteredData();
                      //alert('edate');
                  },
                parseDate: (datestr, format) => {
                  return moment(datestr, format, true).toDate();
                },
                formatDate: (date, format, locale) => {
                  return moment(date).format(format);
                }
            });
            document.getElementById('from-calendar-icon').addEventListener('click', function () {
              fromdatepicker.open(); 
            });

          var todatepicker = flatpickr("#to-datepicker", {
            locale: 'en',
              altInput: true,
              dateFormat: "MM/DD/YYYY",
              altFormat: "MM/DD/YYYY",
              onChange: function(selectedDates, dateStr, instance) {
        
                  fetchFilteredData();
                  
                  //alert('edate');
              },
              parseDate: (datestr, format) => {
                return moment(datestr, format, true).toDate();
              },
              formatDate: (date, format, locale) => {
                return moment(date).format(format);
              }
          });
          document.getElementById('to-calendar-icon').addEventListener('click', function () {
            todatepicker.open(); 
          });

          $('.filter-text').on('click', function() {
                clearFilters();
            });

            
   
    // Function to fetch filtered data
    function fetchFilteredData() {
        var formData = {
            start_date: $('#from-datepicker').val(),
            end_date: $('#to-datepicker').val(),
            sale_estim_number: $('#sale_estim_number').val(),
            sale_cus_id: $('#sale_cus_id').val(),
            sale_status: $('#sale_status').val(),
            _token: '{{ csrf_token() }}'
        };



        // alert(start_date);
        // alert(end_date);
        // alert(sale_cus_id);
        // alert(sale_estim_number);
        // console.log('Form Data:', formData); // Debug: Log form data to console


        $.ajax({
          url: '{{ route('business.estimates.index') }}',
          type: 'GET',
          data: formData,
          success: function(response) {
              $('#filter_data').html(response); // Update the results container with HTML content
              
          },
          error: function(xhr) {
              console.error('Error:', xhr);
              //alert('An error occurred while fetching data.');
          }
        });

    }

     // Attach change event handlers to filter inputs
     $('#sale_cus_id, #sale_status').on('change keyup', function(e) {
      e.preventDefault(); 
      fetchFilteredData();
    });

     // filter estimate number
    $('#sale_estim_number_submit').on('click', function(e) {
        e.preventDefault(); // Prevent default button behavior if inside a form
        fetchFilteredData();
    });

    function clearFilters() {
      // Clear filters
      $('#sale_cus_id').val('').trigger('change');

      // Clear datepicker fields
      const fromDatePicker = flatpickr("#from-datepicker", {
        locale: 'en',
        altInput: true,
        dateFormat: "MM/DD/YYYY",
        altFormat: "MM/DD/YYYY",
        parseDate: (datestr, format) => {
            return moment(datestr, format, true).toDate();
        },
        formatDate: (date, format, locale) => {
            return moment(date).format(format);
        }
      });
      fromDatePicker.clear(); // Clears the "from" datepicker

      const todatepicker = flatpickr("#to-datepicker", {
        locale: 'en',
        altInput: true,
        dateFormat: "MM/DD/YYYY",
        altFormat: "MM/DD/YYYY",
        parseDate: (datestr, format) => {
            return moment(datestr, format, true).toDate();
        },
        formatDate: (date, format, locale) => {
            return moment(date).format(format);
        }
      });

      todatepicker.clear(); // Clears the "to" datepicker


      // Reset other fields
      $('#sale_estim_number').val('');  // Reset input field
      $('#sale_status').val('');  // Reset dropdown field

      // Trigger any additional functionality if needed
      fetchFilteredData(); // Example: Fetch data based on the cleared filters
  }


});

</script>

@endsection
@endif
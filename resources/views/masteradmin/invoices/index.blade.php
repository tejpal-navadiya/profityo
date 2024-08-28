@if(isset($access['view_invoices']) && $access['view_invoices']) 
@extends('masteradmin.layouts.app')
<title>Profityo | View Invoice</title>
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Invoices</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Invoices</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('business.invoices.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Create Invoices</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="col-lg-12 fillter_box">
          <div class="row align-items-center">
            <div class="col-lg-3 col-invoice-box col-md-6">
              <div class="invoice_count_box_br1">
                <div class="invoice_count_box in-primary">
                  <div class="in_contact">
                    <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}" class="invoice_report_icon icon_cr1"></div>
                    <div class="mar_15">
                      <p class="in_contact_title">Overdue</p>
                      <p class="in_contact_total text_color1">$125.50</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-invoice-box col-md-6">
              <div class="invoice_count_box_br2">
                <div class="invoice_count_box in-secondary">
                  <div class="in_contact">
                    <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}" class="invoice_report_icon icon_cr2"></div>
                    <div class="mar_15">
                      <p class="in_contact_title">Due Within Next 30 Days</p>
                      <p class="in_contact_total text_color2">$65.25</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-invoice-box col-md-6">
              <div class="invoice_count_box_br3">
                <div class="invoice_count_box in-success">
                  <div class="in_contact">
                    <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}" class="invoice_report_icon icon_cr3"></div>
                    <div class="mar_15">
                      <p class="in_contact_title">Average Time To Get Paid</p>
                      <p class="in_contact_total text_color3">0 Days</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-invoice-box col-md-6">
              <div class="invoice_count_box_br4">
                <div class="invoice_count_box in-info">
                  <div class="in_contact">
                    <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}" class="invoice_report_icon icon_cr4"></div>
                    <div class="mar_15">
                      <p class="in_contact_title">Upcoming Payout</p>
                      <p class="in_contact_total text_color4">None</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center px-20">
            <P class="refersh_text">Last updated just a moment ago.</P><div class="reset_icon"><img src="{{url('public/dist/img/reset_icon.svg')}}" class="reset_icon_img"></div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Small boxes (Stat box) -->
        <div class="col-lg-12 px-20 fillter_box">
          <div class="row align-items-center justify-content-between">
            <div class="col-auto">
              <p class="m-0 filter-text"><i class="fas fa-solid fa-filter"></i>Filters</p>
            </div><!-- /.col -->
            <div class="col-auto">
              <p class="m-0 float-right filter-text">Clear Filters<i class="fas fa-regular fa-circle-xmark"></i></p>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-3 col-1024 col-md-6 px-10">
              <select class="form-control select2" style="width: 100%;">
                <option default>All customers</option>
                <option>Lamar Mitchell</option>
                <option>Britanney Avery</option>
                <option>Sebastian Ware</option>
                <option>Kyla Carrillo</option>
              </select>
            </div>
            <div class="col-lg-2 col-1024 col-md-6 px-10">
              <select class="form-control form-select" style="width: 100%;">
                <option default>All statuses</option>
                <option>Draft</option>
                <option>Expired</option>
                <option>Converted</option>
                <option>Saved</option>
                <option>Sent</option>
                <option>Viewed</option>
              </select>
            </div>
            <div class="col-lg-4 col-1024 col-md-6 px-10 d-flex">
              <div class="input-group date" id="fromdate" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" placeholder="From" data-target="#fromdate"/>
                <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                </div>
              </div>
              <div class="input-group date" id="todate" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" placeholder="To" data-target="#todate"/>
                <div class="input-group-append" data-target="#todate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-1024 col-md-6 px-10">
              <div class="input-group">
                <input type="search" class="form-control" placeholder="Enter Invoice #">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fa fa-search"></i>
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
          <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
            <ul class="nav nav-pills p-2 tab_box">
              <li class="nav-item"><a class="nav-link active" href="#unpaidinvoice" data-toggle="tab">Unpaid <span class="badge badge-toes">{{ count($unpaidInvoices) }}</span></a></li>
              <li class="nav-item"><a class="nav-link" href="#draftinvoice" data-toggle="tab">Draft <span class="badge badge-toes">{{ count($draftInvoices) }}</span></a></li>
              <li class="nav-item"><a class="nav-link" href="#allinvoice" data-toggle="tab">All Invoices</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="tab-content">
                <div class="tab-pane active" id="unpaidinvoice">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example1" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Due</th>
                          <th>Amount Due</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if (count($unpaidInvoices) > 0)
                      @foreach ($unpaidInvoices as $value)
                        <tr id="invoices-row-unpaid-{{ $value->sale_inv_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>{{ $value->sale_inv_number }}</td>
                          <td>{{ $value->sale_inv_date }}</td>
                          <td>{{ $value->sale_inv_final_amount }}</td>
                          <td>{{ $value->sale_inv_final_amount }}</td>
                          <td>@php
                                    $nextStatus = '';
                                    $nextStatusColor = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatusColor = '';
                                        $nextStatus = 'Draft';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Approve';
                                        $nextStatusColor = '';
                                    } elseif($value->sale_status == 'Send') {
                                        $nextStatus = 'Send';
                                        $nextStatusColor = '';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatusColor = 'overdue_status';
                                        $nextStatus = 'Overdue';
                                    }elseif($value->sale_status == 'View') {
                                        $nextStatusColor = 'Paid_status';
                                        $nextStatus = 'Paid';
                                    }
                                @endphp
                                <span class="status_btn {{ $nextStatusColor }}">{{ $nextStatus }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Send';
                                    } elseif($value->sale_status == 'Send') {
                                        $nextStatus = 'Record Payment';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatus = 'View';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatus = 'View';
                                    }elseif($value->sale_status == 'View') {
                                        $nextStatus = 'View';
                                    }
                                @endphp

                                @if($nextStatus == 'Record Payment')
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#recordpaymentpopup" >
                                Record Payment
                                </a>
                                
                                @else
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')" >
                                {{ $nextStatus }}
                                </a>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @if(isset($access['update_invoices']) && $access['update_invoices']) 
                                  <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.invoices.sendviews', [ $value->sale_inv_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  
                                  <a href="javascript:void(0);" onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.invoices.sendviews', [ $value->sale_inv_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_invoices']) && $access['delete_invoices']) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoiceunpaid-{{ $value->sale_inv_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                       
                        </tr>
                        
                        <div class="modal fade" id="deleteinvoiceunpaid-{{ $value->sale_inv_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}" id="delete-form-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete invoice</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_inv_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>

                      @endforeach
                    @else
                      <tr>
                        <th colspan="6">No Data found</th>
                      </tr>
                    @endif
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="draftinvoice">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example5" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Due</th>
                          <th>Amount Due</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if (count($draftInvoices) > 0)
                      @foreach ($draftInvoices as $value)
                        <tr id="invoices-row-draft-{{ $value->sale_inv_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>{{ $value->sale_inv_number }}</td>
                          <td>{{ $value->sale_inv_date }}</td>
                          <td>{{ $value->sale_inv_final_amount }}</td>
                          <td>{{ $value->sale_inv_final_amount }}</td>
                          <td>@php
                                    $nextStatus = '';
                                    $nextStatusColor = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatusColor = '';
                                        $nextStatus = 'Draft';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Approve';
                                        $nextStatusColor = '';
                                    } elseif($value->sale_status == 'Send') {
                                        $nextStatus = 'Send';
                                        $nextStatusColor = '';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatusColor = 'overdue_status';
                                        $nextStatus = 'Overdue';
                                    }elseif($value->sale_status == 'View') {
                                        $nextStatusColor = 'Paid_status';
                                        $nextStatus = 'Paid';
                                    }
                                @endphp
                                <span class="status_btn {{ $nextStatusColor }}">{{ $nextStatus }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Send';
                                    } elseif($value->sale_status == 'Send') {
                                        $nextStatus = 'Record Payment';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatus = 'View';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatus = 'View';
                                    }elseif($value->sale_status == 'View') {
                                        $nextStatus = 'View';
                                    }
                                @endphp

                                @if($nextStatus == 'Record Payment')
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#recordpaymentpopup" >
                                Record Payment
                                </a>
                                
                                @else
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')" >
                                {{ $nextStatus }}
                                </a>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @if(isset($access['update_invoices']) && $access['update_invoices']) 
                                  <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.invoices.sendviews', [ $value->sale_inv_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  
                                  <a href="javascript:void(0);" onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.invoices.sendviews', [ $value->sale_inv_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_invoices']) && $access['delete_invoices']) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoicedraft-{{ $value->sale_inv_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                       
                        </tr>
                        
                        <div class="modal fade" id="deleteinvoicedraft-{{ $value->sale_inv_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}" id="delete-form-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete invoice</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_inv_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>


                      @endforeach
                    @else
                      <tr>
                        <th colspan="6">No Data found</th>
                      </tr>
                    @endif
                      
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="allinvoice">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example4" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Due</th>
                          <th>Amount Due</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if (count($allInvoices) > 0)
                      @foreach ($allInvoices as $value)
                        <tr id="invoices-row-all-{{ $value->sale_inv_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>{{ $value->sale_inv_number }}</td>
                          <td>{{ $value->sale_inv_date }}</td>
                          <td>{{ $value->sale_inv_final_amount }}</td>
                          <td>{{ $value->sale_inv_final_amount }}</td>
                          <td>@php
                                    $nextStatus = '';
                                    $nextStatusColor = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatusColor = '';
                                        $nextStatus = 'Draft';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Approve';
                                        $nextStatusColor = '';
                                    } elseif($value->sale_status == 'Send') {
                                        $nextStatus = 'Send';
                                        $nextStatusColor = '';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatusColor = 'overdue_status';
                                        $nextStatus = 'Overdue';
                                    }elseif($value->sale_status == 'View') {
                                        $nextStatusColor = 'Paid_status';
                                        $nextStatus = 'Paid';
                                    }
                                @endphp
                                <span class="status_btn {{ $nextStatusColor }}">{{ $nextStatus }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Send';
                                    } elseif($value->sale_status == 'Send') {
                                        $nextStatus = 'Record Payment';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatus = 'View';
                                    } elseif($value->sale_status == 'Record Payment') {
                                        $nextStatus = 'View';
                                    }elseif($value->sale_status == 'View') {
                                        $nextStatus = 'View';
                                    }
                                @endphp

                                @if($nextStatus == 'Record Payment')
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#recordpaymentpopup" >
                                Record Payment
                                </a>
                                
                                @else
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')" >
                                {{ $nextStatus }}
                                </a>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @if(isset($access['update_invoices']) && $access['update_invoices']) 
                                  <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.invoices.sendviews', [ $value->sale_inv_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                 
                                  <a href="javascript:void(0);" onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.invoices.sendviews', [ $value->sale_inv_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_invoices']) && $access['delete_invoices']) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoiceall-{{ $value->sale_inv_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                       
                        </tr>
                        
                        <div class="modal fade" id="deleteinvoiceall-{{ $value->sale_inv_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}" id="delete-form-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete invoice</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_inv_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>


                      @endforeach
                    @else
                      <tr>
                        <th colspan="6">No Data found</th>
                      </tr>
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
  function updateStatus(invoiceId, nextStatus) {
    $.ajax({
      url: "{{ route('business.invoices.statusStore', ':id') }}".replace(':id', invoiceId),
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            sale_status: nextStatus 
        },
        success: function(response) {
        //   console.log(response);
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
    var invoiceId = $(this).data('id'); 
    var form = $('#delete-form-' + invoiceId);
    var url = form.attr('action'); 

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(), 
        success: function(response) {
            if (response.success) {
                $('#invoices-row-unpaid-' + invoiceId).remove();

                $('#invoices-row-draft-' + invoiceId).remove();

                $('#invoices-row-all-' + invoiceId).remove();

                $('#deleteinvoiceall-' + invoiceId).modal('hide');
                $('#deleteinvoicedraft-' + invoiceId).modal('hide');
                $('#deleteinvoiceunpaid-' + invoiceId).modal('hide');

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
</script>
<script>
    function sendInvoice(url, invoiceId) {
      // alert(estimateId); 
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
@endsection
@endif
@extends('masteradmin.layouts.app')
<title>Profityo | View Invoice</title>
@if(isset($access['view_invoices']) && $access['view_invoices'] == 1)
  @section('content')
  <link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">
  <style>
    .due-message {
    color: red;
    }
  </style>
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
        @if(isset($access['add_invoices']) && $access['add_invoices'] == 1)
      <a href="{{ route('business.invoices.create') }}"><button class="add_btn"><i
        class="fas fa-plus add_plus_icon"></i>Create Invoices</button></a>
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
      <!-- Small boxes (Stat box) -->
      <div class="col-lg-12 fillter_box">
      <div class="row align-items-center">
        <div class="col-lg-3 col-invoice-box col-md-6">
        <div class="invoice_count_box_br1">
          <div class="invoice_count_box in-primary">
          <div class="in_contact">
            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
              class="invoice_report_icon icon_cr1"></div>
            <div class="mar_15">
            <p class="in_contact_title">Overdue</p>
            <p class="in_contact_total text_color1">${{ number_format($overdueTotal, 2) }} </p>
            </div>
          </div>
          </div>
        </div>
        </div>
        <div class="col-lg-3 col-invoice-box col-md-6">
        <div class="invoice_count_box_br2">
          <div class="invoice_count_box in-secondary">
          <div class="in_contact">
            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
              class="invoice_report_icon icon_cr2"></div>
            <div class="mar_15">
            <p class="in_contact_title">Due Within Next 30 Days</p>
            <p class="in_contact_total text_color2">${{ number_format($totalDueNext30Days, 2) }}</p>
            </div>
          </div>
          </div>
        </div>
        </div>
        <div class="col-lg-3 col-invoice-box col-md-6">
        <div class="invoice_count_box_br3">
          <div class="invoice_count_box in-success">
          <div class="in_contact">
            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
              class="invoice_report_icon icon_cr3"></div>
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
            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
              class="invoice_report_icon icon_cr4"></div>
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
        <P class="refersh_text">Last updated just a moment ago.</P>
        <div class="reset_icon"><img src="{{url('public/dist/img/reset_icon.svg')}}" class="reset_icon_img"></div>
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
        <select id="sale_cus_id" class="form-control select2" style="width: 100%;" name="sale_cus_id">
          <option value="" default>All customers</option>
          @foreach($salecustomer as $value)
        <option value="{{ $value->sale_cus_id }}">{{ $value->sale_cus_business_name }} </option>
      @endforeach
        </select>
        </div>
        <div class="col-lg-2 col-1024 col-md-6 px-10">
        <select class="form-control form-select" style="width: 100%;" name="sale_status" id="sale_status">
          <option value="">All statuses</option>
          <option value="Draft">Draft</option>
          <option value="Unsent">Unsent</option>
          <option value="Sent">Sent</option>
          <option value="Partial">Partial</option>
          <option value="Paid">Paid</option>
          <option value="Overpaid">Overpaid</option>
          <option value="Overdue">Overdue</option>
        </select>
        </div>
        <div class="col-lg-4 col-1024 col-md-6 px-10 d-flex">
        <div class="input-group date">
          <x-flatpickr id="from-datepicker" placeholder="From" />
          <div class="input-group-append">
          <span class="input-group-text" id="from-calendar-icon">
            <i class="fa fa-calendar-alt"></i>
          </span>
          </div>
        </div>
        <div class="input-group date">
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
          <input type="search" class="form-control" name="sale_inv_number" placeholder="Enter Invoice #"
          id="sale_inv_number">
          <div class="input-group-append" id="sale_inv_number_submit">
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
      <div id="filter_data">
      <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
        <ul class="nav nav-pills p-2 tab_box">
        <li class="nav-item"><a class="nav-link active" href="#unpaidinvoice" data-toggle="tab">Unpaid <span
            class="badge badge-toes">{{ count($unpaidInvoices) }}</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#draftinvoice" data-toggle="tab">Draft <span
            class="badge badge-toes">{{ count($draftInvoices) }}</span></a></li>
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
              <th>Due Day</th>

              <th>Status</th>
              <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if (count($unpaidInvoices) > 0)
              @foreach ($unpaidInvoices as $value)

            <tr id="invoices-row-unpaid-{{ $value->sale_inv_id }}">
            <td>{{ $value->customer->sale_cus_first_name ?? '' }}
            {{ $value->customer->sale_cus_last_name ?? '' }}</td>
            <td>{{ $value->sale_inv_number }}</td>
            <td>{{ \Carbon\Carbon::parse($value->sale_inv_date)->format('M d, Y') }}</td>
            <td>{{ $value->sale_inv_final_amount }}</td>
            <td>{{ $value->sale_inv_due_amount }}</td>
            <td>
            @php
          // Calculate the due date
          $dueDate = \Carbon\Carbon::parse($value->sale_inv_valid_date);
          $currentDate = \Carbon\Carbon::now();
          $daysDifference = $dueDate->diffInDays($currentDate, false);

          if ($daysDifference == 0) {
          $dueMessage = 'Today'; // Message for today
          $dueMessageColor = 'black'; // Set default color
          } elseif ($daysDifference < 0) {
          $dueMessage = 'Due in ' . $daysDifference . ' Days'; // Upcoming message
          $dueMessageColor = 'black'; // Set default color

          } else {
          $dueMessage = abs($daysDifference) . ' Days ago'; // Overdue message
          $dueMessageColor = 'red'; // Overdue color
          }
      @endphp
            <span style="color: {{ $dueMessageColor }};">
            {{ $dueMessage }}
            </span>
            </td>
            <td>
                        @php
                            // Fetch the current due amount and original amount for this specific record
                            $remainingDueAmount = $value->sale_inv_due_amount; // Current due amount
                            $originalDueAmount = $value->sale_inv_final_amount;  // Total amount before payment

                            // Set default status and color
                            $nextStatus = $value->sale_status;
                            $nextStatusColor = '';

                            // Check if the due date has passed and the invoice is unpaid
                            if ($daysDifference > 0 && $remainingDueAmount > 0) {
                                // Overdue status
                                $nextStatus = 'Overdue';
                                $nextStatusColor = 'overdue_status'; // Class for overdue status
                            }
                            
                            // Check the remaining due amount to determine if fully or partially paid
                            elseif ($remainingDueAmount == 0) {
                                // Fully paid status
                                //$nextStatus = 'Paid';
                                $nextStatusColor = 'Paid_status'; // Set class for paid status
                            } elseif ($remainingDueAmount < $originalDueAmount) {
                                // Partially paid status
                               // $nextStatus = 'Partial';
                                $nextStatusColor = 'partial_status'; // Set class for partially paid
                            } else {
                                // If none of the payment conditions match, fallback to the existing sale status
                                switch($value->sale_status) {
                                    case 'Draft':
                                        $nextStatusColor = ''; // Draft status class (if needed)
                                        break;
                                    case 'Unsent':
                                        $nextStatusColor = ''; // Unsent status class (if needed)
                                        break;
                                    case 'Sent':
                                        $nextStatusColor = ''; // Sent status class (if needed)
                                        break;
                                    case 'Partlal':
                                        $nextStatusColor = 'partial_status'; // Class for partial payments
                                        break;
                                    case 'Paid':
                                        $nextStatusColor = 'Paid_status'; // Class for fully paidOver Paid
                                        break;
                                        case 'Over Paid':
                                        $nextStatusColor = 'OverPaid_status'; // Class for fully paidOver Paid
                                        break;
                                    default:
                                        $nextStatusColor = ''; // Default to no specific color
                                }
                            }
                        @endphp

                        <!-- Display status with corresponding CSS class -->
                        <span class="status_btn {{ $nextStatusColor }}">{{ $nextStatus }}</span>
                    </td>


            <!-- <td>@php
            
          $nextStatus = '';
          $nextStatusColor = '';
          if ($value->sale_status == 'Draft') {
          $nextStatusColor = '';
          } elseif ($value->sale_status == 'Unsent') {
          $nextStatusColor = '';
          } elseif ($value->sale_status == 'Sent') {
          $nextStatusColor = '';
          } elseif ($value->sale_status == 'Partlal') {
          $nextStatusColor = 'overdue_status';
          } elseif ($value->sale_status == 'Paid') {
          $nextStatusColor = 'Paid_status';
          }
      @endphp
            <span class="status_btn {{ $nextStatusColor }}">{{ $value->sale_status }}</span>
            </td> -->
            <!-- Actions Dropdown -->
            <td>
            <ul class="navbar-nav ml-auto float-sm-right">
            <li class="nav-item dropdown d-flex align-items-center">
            @php
          $nextStatus = '';
          if ($value->sale_status == 'Draft') {
          $nextStatus = 'Approve';
          } elseif ($value->sale_status == 'Unsent') {
          $nextStatus = 'Send';
          } elseif ($value->sale_status == 'Sent') {
          $nextStatus = 'Record Payment';
          } elseif ($value->sale_status == 'Partial') {
          $nextStatus = 'Record Payment';
          } elseif ($value->sale_status == 'Paid') {
          $nextStatus = 'View';
          }
      @endphp

            @if($nextStatus == 'Record Payment')
        <a href="javascript:void(0);" data-toggle="modal"
        data-target="#recordpaymentpopup{{ $value->sale_inv_id }}">
        Record Payment
        </a>
        <div class="modal fade" id="recordpaymentpopup{{ $value->sale_inv_id }}" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Record A Payment For This
          Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST"
          action="{{ route('business.payments.paymentstore', $value->sale_inv_id) }}">
          @csrf
          <input type="hidden" name="invoice_id" value="{{ $value->sale_inv_id }}">

          <div class="row pxy-15 px-10">
          <div class="col-md-12">
          <p>Record a Payment you've Already Received, Such As Cash, Check, or Bank
          Payment.</p>
          </div>
          <!-- <div class="col-md-6">
          <div class="form-group">
          <label>Date</label>
          <div class="input-group date" id="estimatedate" data-target-input="nearest">
          <input type="text" name="payment_date" class="form-control datetimepicker-input" placeholder="" data-target="#estimatedate">
          <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div>
          </div>
          </div>
          </div> -->
          <div class="col-md-3">
          <div class="form-group">
          <label>Date</label>
          <div class="input-group date" id="estimatedate"
          data-target-input="nearest">
          <input type="hidden" id="from-datepickerp-hidden"
          value="{{ $value->sale_inv_date }}" />
          <!-- <input type="text" class="form-control datetimepicker-input" name="sale_estim_date" placeholder=""
          data-target="#estimatedate" />
          <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div> -->
          <x-flatpickr id="from-datepickerp" name="payment_date"
          placeholder="Select a date"
          value="{{ old('payment_date', $value->sale_inv_date) }}" />
          <div class="input-group-append">
          <div class="input-group-text" id="from-calendar-iconp">
          <i class="fa fa-calendar-alt"></i>
          </div>
          </div>
          </div>
          <span class="error-message" id="error_payment_date"
          style="color: red;"></span>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Amount</label>
          <div class="d-flex">
          <select class="form-select amount_currency_input" name="payment_amount">
          <option>$</option>
          <option>€</option>
          <option>(CFA)</option>
          <option>£</option>
          </select>
          <input type="text" name="payment_amount"
          class="form-control amount_input"
          value="{{ $value->sale_inv_due_amount }}"
          aria-describedby="inputGroupPrepend">
          </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Method</label>
          <select class="form-control form-select" name="payment_method">
          <option>Select a Payment Account...</option>
          @foreach($paymethod as $pay)
          <option value="{{ $pay->m_id }}">{{ $pay->method_name }}</option> <!-- Store ID -->
          @endforeach
          </select>
          </div>
          </div>
          <div class="col-md-6">
          <label>Account <span class="text-danger">*</span></label>
          <select class="form-control form-select" name="payment_account"
          placeholder="Enter your text here">
          <option>Select a Payment Account...</option>
          @foreach($accounts as $account)
          <option value="{{ $account->chart_acc_id }}">{{ $account->chart_acc_name }}</option> <!-- Store ID -->
          @endforeach
          </select>
          <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds From.
          </p>
          </div>

          <div class="col-md-12">
          <div class="form-group">
          <label for="recordpaymentmemonotes">Memo / Notes</label>
          <textarea id="recordpaymentmemonotes" class="form-control" name="notes"
          rows="3" placeholder="Enter your text here"></textarea>
          </div>
          </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Save</button>
          </div>
          </form>

        </div>
        </div>
        </div>
        </div>
      @else
    <a href="javascript:void(0);"
    onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')">
    {{ $nextStatus }}
    </a>
  @endif
            <a class="nav-link user_nav" data-toggle="dropdown" href="#">
            <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            @if(isset($access['view_invoices']) && $access['view_invoices'] == 1)
        <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}"
        class="dropdown-item">
        <i class="fas fa-regular fa-eye mr-2"></i> View
        </a>
      @endif
            @if(isset($access['update_invoices']) && $access['update_invoices'] == 1)
        <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}"
        class="dropdown-item">
        <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
        </a>
      @endif
            <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}"
            class="dropdown-item">
            <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
            </a>
            <a target="_blank"
            href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'print' => 'true']) }}"
            class="dropdown-item">
            <i class="fas fa-solid fa-print mr-2"></i> Print
            </a>

            <a href="javascript:void(0);"
            onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"
            class="dropdown-item">
            <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
            </a>
            <a href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'download' => 'true']) }}"
            class="dropdown-item">
            <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
            </a>
            @if(isset($access['delete_invoices']) && $access['delete_invoices'] == 1)
        <a href="#" class="dropdown-item" data-toggle="modal"
        data-target="#deleteinvoiceunpaid-{{ $value->sale_inv_id }}">
        <i class="fas fa-solid fa-trash mr-2"></i> Delete
        </a>
      @endif
            </div>
            </li>
            </ul>
            </td>

            </tr>

            <div class="modal fade" id="deleteinvoiceunpaid-{{ $value->sale_inv_id }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST"
            action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}"
            id="delete-form-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
            @csrf
            @method('DELETE')
            <div class="modal-body pad-1 text-center">
            <i class="fas fa-solid fa-trash delete_icon"></i>
            <p class="company_business_name px-10"><b>Delete invoice</b></p>
            <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>

            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
            <button type="button" class="delete_btn px-15"
            data-id="{{ $value->sale_inv_id }}">Delete</button>
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
          <div class="tab-pane" id="draftinvoice">
          <div class="col-md-12 table-responsive pad_table">
            <table id="example5" class="table table-hover text-nowrap">
            <thead>
              <tr>
              <th>Customer</th>
              <th>Number</th>
              <th>Date</th>
              <th>Due</th>
              <!-- <th>Due Day</th> -->
              <th>Amount Due</th>
              <th>Status</th>
              <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if (count($draftInvoices) > 0)
              @foreach ($draftInvoices as $value)
            <tr id="invoices-row-draft-{{ $value->sale_inv_id }}">
            <td>{{ $value->customer->sale_cus_first_name ?? '' }}
            {{ $value->customer->sale_cus_last_name ?? '' }}</td>
            <td>{{ $value->sale_inv_number }}</td>
            <td>{{ \Carbon\Carbon::parse($value->sale_inv_date)->format('M d, Y') }}</td>
            <td>{{ $value->sale_inv_final_amount }}</td>
            <!-- <td>
            @php
          // Calculate the due date
          $dueDate = \Carbon\Carbon::parse($value->sale_inv_valid_date);
          $currentDate = \Carbon\Carbon::now();
          $daysDifference = $dueDate->diffInDays($currentDate, false);

          // Set due message and color based on days difference
          if ($daysDifference == 0) {
          $dueMessage = 'Today'; // Message for today
          $dueMessageColor = 'black'; // Set default color
          } elseif ($daysDifference < 0) {
          $dueMessage = 'Due in ' . $daysDifference . ' Days'; // Upcoming message
          $dueMessageColor = 'black'; // Set default color

          } else {
          $dueMessage = abs($daysDifference) . ' Days ago'; // Overdue message
          $dueMessageColor = 'red'; // Overdue color
          }
      @endphp
            <span style="color: {{ $dueMessageColor }};">
            {{ $dueMessage }}
            </span>
            </td> -->
            <td>{{ $value->sale_inv_final_amount }}</td>
            <td>@php
          $nextStatus = '';
          $nextStatusColor = '';
          if ($value->sale_status == 'Draft') {
          $nextStatusColor = '';
          } elseif ($value->sale_status == 'Unsent') {
          $nextStatusColor = '';
          } elseif ($value->sale_status == 'Sent') {
          $nextStatusColor = '';
          } elseif ($value->sale_status == 'Partial') {
          $nextStatusColor = 'overdue_status';
          } elseif ($value->sale_status == 'Paid') {
          $nextStatusColor = 'Paid_status';
          }
      @endphp
            <span class="status_btn {{ $nextStatusColor }}">{{ $value->sale_status }}</span>
            </td>
            <!-- Actions Dropdown -->
            <td>
            <ul class="navbar-nav ml-auto float-sm-right">
            <li class="nav-item dropdown d-flex align-items-center">
            @php
          $nextStatus = '';
          if ($value->sale_status == 'Draft') {
          $nextStatus = 'Approve';
          } elseif ($value->sale_status == 'Unsent') {
          $nextStatus = 'Send';
          } elseif ($value->sale_status == 'Sent') {
          $nextStatus = 'Record Payment';
          } elseif ($value->sale_status == 'Partial') {
          $nextStatus = 'Record Payment';
          } elseif ($value->sale_status == 'Paid') {
          $nextStatus = 'View';
          }
      @endphp

            @if($nextStatus == 'Record Payment')
        <a href="javascript:void(0);" data-toggle="modal" data-target="#recordpaymentpopup">
        Record Payment
        </a>

      @else
    <a href="javascript:void(0);"
    onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')">
    {{ $nextStatus }}
    </a>
  @endif
            <a class="nav-link user_nav" data-toggle="dropdown" href="#">
            <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            @if(isset($access['view_invoices']) && $access['view_invoices'] == 1)
        <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}"
        class="dropdown-item">
        <i class="fas fa-regular fa-eye mr-2"></i> View
        </a>
      @endif
            @if(isset($access['update_invoices']) && $access['update_invoices'] == 1)
        <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}"
        class="dropdown-item">
        <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
        </a>
      @endif
            <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}"
            class="dropdown-item">
            <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
            </a>
            <a target="_blank"
            href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'print' => 'true']) }}"
            class="dropdown-item">
            <i class="fas fa-solid fa-print mr-2"></i> Print
            </a>

            <a href="javascript:void(0);"
            onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"
            class="dropdown-item">
            <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
            </a>
            <a href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'download' => 'true']) }}"
            class="dropdown-item">
            <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
            </a>
            @if(isset($access['delete_invoices']) && $access['delete_invoices'] == 1)
        <a href="#" class="dropdown-item" data-toggle="modal"
        data-target="#deleteinvoicedraft-{{ $value->sale_inv_id }}">
        <i class="fas fa-solid fa-trash mr-2"></i> Delete
        </a>
      @endif
            </div>
            </li>
            </ul>
            </td>

            </tr>

            <div class="modal fade" id="deleteinvoicedraft-{{ $value->sale_inv_id }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST"
            action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}"
            id="delete-form-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
            @csrf
            @method('DELETE')
            <div class="modal-body pad-1 text-center">
            <i class="fas fa-solid fa-trash delete_icon"></i>
            <p class="company_business_name px-10"><b>Delete invoice</b></p>
            <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>

            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
            <button type="button" class="delete_btn px-15"
            data-id="{{ $value->sale_inv_id }}">Delete</button>
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
          <div class="tab-pane" id="allinvoice">
          <div class="col-md-12 table-responsive pad_table">
            <table id="example4" class="table table-hover text-nowrap">
            <thead>
              <tr>
              <th>Customer</th>
              <th>Number</th>
              <th>Date</th>
              <th>Due</th>
              <!-- <th>Due Day</th> -->
              <th>Amount Due</th>
              <th>Status</th>
              <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if (count($allInvoices) > 0)
              @foreach ($allInvoices as $value)
            <tr id="invoices-row-all-{{ $value->sale_inv_id }}">
            <td>{{ $value->customer->sale_cus_first_name ?? '' }}
            {{ $value->customer->sale_cus_last_name ?? '' }}</td>
            <td>{{ $value->sale_inv_number }}</td>
            <td>{{ \Carbon\Carbon::parse($value->sale_inv_date)->format('M d, Y') }}</td>
            <td>{{ $value->sale_inv_final_amount }}</td>
            <!-- <td>
            @php
          // Calculate the due date
          $dueDate = \Carbon\Carbon::parse($value->sale_inv_valid_date);
          $currentDate = \Carbon\Carbon::now();
          $daysDifference = $dueDate->diffInDays($currentDate, false);

          // Set due message and color based on days difference
          if ($daysDifference == 0) {
          $dueMessage = 'Today'; // Message for today
          $dueMessageColor = 'black'; // Set default color
          } elseif ($daysDifference < 0) {
          $dueMessage = 'Due in ' . $daysDifference . ' Days'; // Upcoming message
          $dueMessageColor = 'black'; // Set default color

          } else {
          $dueMessage = abs($daysDifference) . ' Days ago'; // Overdue message
          $dueMessageColor = 'red'; // Overdue color
          }
      @endphp
            <span style="color: {{ $dueMessageColor }};">
            {{ $dueMessage }}
            </span>
            </td> -->
            <td>{{ $value->sale_inv_due_amount }}</td>
            <td>
                        @php
                            // Fetch the current due amount and original amount for this specific record
                            $remainingDueAmount = $value->sale_inv_due_amount; // Current due amount
                            $originalDueAmount = $value->sale_inv_final_amount;  // Total amount before payment

                            // Set default status and color
                            $nextStatus = $value->sale_status;
                            $nextStatusColor = '';

                            // Check if the due date has passed and the invoice is unpaid
                            if ($daysDifference > 0 && $remainingDueAmount > 0) {
                                // Overdue status
                              $nextStatus = 'Overdue';
                                $nextStatusColor = 'overdue_status'; // Class for overdue status
                            }
                            
                            // Check the remaining due amount to determine if fully or partially paid
                            elseif ($remainingDueAmount == 0) {
                                // Fully paid status
                                //$nextStatus = 'Paid';
                                $nextStatusColor = 'Paid_status'; // Set class for paid status
                            } elseif ($remainingDueAmount < $originalDueAmount) {
                                // Partially paid status
                               // $nextStatus = 'Partial';
                                $nextStatusColor = 'partial_status'; // Set class for partially paid
                            } else {
                                // If none of the payment conditions match, fallback to the existing sale status
                                switch($value->sale_status) {
                                    case 'Draft':
                                        $nextStatusColor = ''; // Draft status class (if needed)
                                        break;
                                    case 'Unsent':
                                        $nextStatusColor = ''; // Unsent status class (if needed)
                                        break;
                                    case 'Sent':
                                        $nextStatusColor = ''; // Sent status class (if needed)
                                        break;
                                    case 'Partial':
                                        $nextStatusColor = 'partial_status'; // Class for partial payments
                                        break;
                                    case 'Paid':
                                        $nextStatusColor = 'Paid_status'; // Class for fully paidOver Paid
                                        break;
                                        case 'Over Paid':
                                        $nextStatusColor = 'OverPaid_status'; // Class for fully paidOver Paid
                                        break;
                                    default:
                                        $nextStatusColor = ''; // Default to no specific color
                                }
                            }
                        @endphp

                        <!-- Display status with corresponding CSS class -->
                        <span class="status_btn {{ $nextStatusColor }}">{{ $nextStatus }}</span>
                    </td>
            <!-- <td>
                        @php
                            // Fetch the current due amount and original amount for this specific record
                            $remainingDueAmount = $value->sale_inv_due_amount; // Current due amount
                            $originalDueAmount = $value->sale_inv_final_amount;  // Total amount before payment

                            // Set default status and color
                            $nextStatus = $value->sale_status;
                            $nextStatusColor = '';

                            // Check if the due date has passed and the invoice is unpaid
                            if ($daysDifference > 0 && $remainingDueAmount > 0) {
                                // Overdue status
                                $nextStatus = 'Overdue';
                                $nextStatusColor = 'overdue_status'; // Class for overdue status
                            }
                            // Check the remaining due amount to determine if fully or partially paid
                            elseif ($remainingDueAmount == 0) {
                                // Fully paid status
                                $nextStatus = 'Paid';
                                $nextStatusColor = 'Paid_status'; // Set class for paid status
                            } elseif ($remainingDueAmount < $originalDueAmount) {
                                // Partially paid status
                                $nextStatus = 'Partial';
                                $nextStatusColor = 'partial_status'; // Set class for partially paid
                            } 
                            else {
                                // If none of the payment conditions match, fallback to the existing sale status
                                switch($value->sale_status) {
                                    case 'Draft':
                                        $nextStatusColor = ''; // Draft status class (if needed)
                                        break;
                                    case 'Unsent':
                                        $nextStatusColor = ''; // Unsent status class (if needed)
                                        break;
                                    case 'Sent':
                                        $nextStatusColor = ''; // Sent status class (if needed)
                                        break;
                                    case 'Partial':
                                        $nextStatusColor = 'partial_status'; // Class for partial payments
                                        break;
                                    case 'Paid':
                                        $nextStatusColor = 'Paid_status'; // Class for fully paid
                                        break;
                                    default:
                                        $nextStatusColor = ''; // Default to no specific color
                                }
                            }
                        @endphp

                        <!-- Display status with corresponding CSS class --
                        <span class="status_btn {{ $nextStatusColor }}">{{ $nextStatus }}</span>
                    </td> -->
            <!-- Actions Dropdown -->
            <td>
            <ul class="navbar-nav ml-auto float-sm-right">
            <li class="nav-item dropdown d-flex align-items-center">
            @php
          $nextStatus = '';
          if ($value->sale_status == 'Draft') {
          $nextStatus = 'Approve';
          } elseif ($value->sale_status == 'Unsent') {
          $nextStatus = 'Send';
          } elseif ($value->sale_status == 'Sent') {
          $nextStatus = 'Record Payment';
          } elseif ($value->sale_status == 'Partial') {
          $nextStatus = 'Record Payment';
          } elseif ($value->sale_status == 'Paid') {
          $nextStatus = 'View';
          }
          elseif ($value->sale_status == 'Over Paid') {
          $nextStatus = 'Manage overpayment';
          }
      @endphp

            @if($nextStatus == 'Record Payment')
        <a href="javascript:void(0);" data-toggle="modal"
        data-target="#recordpaymentpopup2{{ $value->sale_inv_id }}">
        Record Payment
        </a>
        <div class="modal fade" id="recordpaymentpopup2{{ $value->sale_inv_id }}" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Record A Payment For This
          Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST"
          action="{{ route('business.payments.paymentstore', $value->sale_inv_id) }}">
          @csrf
          <input type="hidden" name="invoice_id" value="{{ $value->sale_inv_id }}">

          <div class="row pxy-15 px-10">
          <div class="col-md-12">
          <p>Record a Payment you've Already Received, Such As Cash, Check, or Bank
          Payment.</p>
          </div>
          <!-- <div class="col-md-6">
          <div class="form-group">
          <label>Date</label>
          <div class="input-group date" id="estimatedate" data-target-input="nearest">
          <input type="text" name="payment_date" class="form-control datetimepicker-input" placeholder="" data-target="#estimatedate">
          <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div>
          </div>
          </div>
          </div> -->
          <div class="col-md-3">
          <div class="form-group">
          <label>Date</label>
          <div class="input-group date" id="estimatedate"
          data-target-input="nearest">
          <input type="hidden" id="from-datepickerp-hidden"
          value="{{ $value->sale_inv_date }}" />
          <!-- <input type="text" class="form-control datetimepicker-input" name="sale_estim_date" placeholder=""
          data-target="#estimatedate" />
          <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div> -->
          <x-flatpickr id="from-datepickerp" name="payment_date"
          placeholder="Select a date"
          value="{{ old('payment_date', $value->sale_inv_date) }}" />
          <div class="input-group-append">
          <div class="input-group-text" id="from-calendar-iconp">
          <i class="fa fa-calendar-alt"></i>
          </div>
          </div>
          </div>
          <span class="error-message" id="error_payment_date"
          style="color: red;"></span>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Amount</label>
          <div class="d-flex">
          <select class="form-select amount_currency_input" name="payment_amount">
          <option>$</option>
          <option>€</option>
          <option>(CFA)</option>
          <option>£</option>
          </select>
          <input type="text" name="payment_amount"
          class="form-control amount_input"
          value="{{ $value->sale_inv_due_amount }}"
          aria-describedby="inputGroupPrepend">
          </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Method</label>
          <select class="form-control form-select" name="payment_method">
          <option>Select a Payment Account...</option>
          @foreach($paymethod as $pay)
          <option value="{{ $pay->m_id }}">{{ $pay->method_name }}</option> <!-- Store ID -->
          @endforeach
          </select>
          </div>
          </div>
          <div class="col-md-6">
          <label>Account <span class="text-danger">*</span></label>
          <select class="form-control form-select" name="payment_account"
          placeholder="Enter your text here">
          <option>Select a Payment Account...</option>
          @foreach($accounts as $account)
          <option value="{{ $account->chart_acc_id }}">{{ $account->chart_acc_name }}</option> <!-- Store ID -->
          @endforeach
          </select>
          <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds From.
          </p>
          </div>

          <div class="col-md-12">
          <div class="form-group">
          <label for="recordpaymentmemonotes">Memo / Notes</label>
          <textarea id="recordpaymentmemonotes" class="form-control" name="notes"
          rows="3" placeholder="Enter your text here"></textarea>
          </div>
          </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Save</button>
          </div>
          </form>

        </div>
        </div>
        </div>
        </div>
          <!--  -->
  @elseif($nextStatus == 'Manage overpayment')
        <a href="javascript:void(0);" data-toggle="modal"
        data-target="#overpayment{{ $value->sale_inv_id }}">
        Manage overpayment
        </a>
        <div class="modal fade" id="overpayment{{ $value->sale_inv_id }}" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Manage overpayment For This
          Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST"
          action="{{ route('business.payments.paymentstore', $value->sale_inv_id) }}">
          @csrf
          <input type="hidden" name="invoice_id" value="{{ $value->sale_inv_id }}">

          <div class="row pxy-15 px-10">
          <div class="col-md-12">
          <p>Manage overpayment you've Already Received, Such As Cash, Check, or Bank
          Payment.</p>
          </div>
          <!-- <div class="col-md-6">
          <div class="form-group">
          <label>Date</label>
          <div class="input-group date" id="estimatedate" data-target-input="nearest">
          <input type="text" name="payment_date" class="form-control datetimepicker-input" placeholder="" data-target="#estimatedate">
          <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div>
          </div>
          </div>
          </div> -->
          <div class="col-md-3">
          <div class="form-group">
          <label>Date</label>
          <div class="input-group date" id="estimatedate"
          data-target-input="nearest">
          <input type="hidden" id="from-datepickerp-hidden"
          value="{{ $value->sale_inv_date }}" />
          <!-- <input type="text" class="form-control datetimepicker-input" name="sale_estim_date" placeholder=""
          data-target="#estimatedate" />
          <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div> -->
          <x-flatpickr id="from-datepickerp" name="payment_date"
          placeholder="Select a date"
          value="{{ old('payment_date', $value->sale_inv_date) }}" />
          <div class="input-group-append">
          <div class="input-group-text" id="from-calendar-iconp">
          <i class="fa fa-calendar-alt"></i>
          </div>
          </div>
          </div>
          <span class="error-message" id="error_payment_date"
          style="color: red;"></span>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Amount</label>
          <div class="d-flex">
          <select class="form-select amount_currency_input" name="payment_amount">
          <option>$</option>
          <option>€</option>
          <option>(CFA)</option>
          <option>£</option>
          </select>
          <input type="text" name="payment_amount"
          class="form-control amount_input"
          value="{{ $value->sale_inv_due_amount }}"
          aria-describedby="inputGroupPrepend">
          </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
          <label>Method</label>
          <select class="form-control form-select" name="payment_method">
          <option>Select a Payment Account...</option>
          @foreach($paymethod as $pay)
          <option value="{{ $pay->m_id }}">{{ $pay->method_name }}</option> <!-- Store ID -->
          @endforeach
          </select>
          </div>
          </div>
          <div class="col-md-6">
          <label>Account <span class="text-danger">*</span></label>
          <select class="form-control form-select" name="payment_account"
          placeholder="Enter your text here">
          <option>Select a Payment Account...</option>
          @foreach($accounts as $account)
          <option value="{{ $account->chart_acc_id }}">{{ $account->chart_acc_name }}</option> <!-- Store ID -->
          @endforeach
          </select>
          <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds From.
          </p>
          </div>

          <div class="col-md-12">
          <div class="form-group">
          <label for="recordpaymentmemonotes">Memo / Notes</label>
          <textarea id="recordpaymentmemonotes" class="form-control" name="notes"
          rows="3" placeholder="Enter your text here"></textarea>
          </div>
          </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Save</button>
          </div>
          </form>

        </div>
        </div>
        </div>
        </div>

      @else
    <a href="javascript:void(0);"
    onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')">
    {{ $nextStatus }}
    </a>


  @endif







  <!-- end -->
            <a class="nav-link user_nav" data-toggle="dropdown" href="#">
            <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
            @if(isset($access['view_invoices']) && $access['view_invoices'] == 1)
        <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}"
        class="dropdown-item">
        <i class="fas fa-regular fa-eye mr-2"></i> View
        </a>
      @endif
            @if(isset($access['update_invoices']) && $access['update_invoices'] == 1)
        <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}"
        class="dropdown-item">
        <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
        </a>
      @endif
            <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}"
            class="dropdown-item">
            <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
            </a>
            <a target="_blank"
            href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'print' => 'true']) }}"
            class="dropdown-item">
            <i class="fas fa-solid fa-print mr-2"></i> Print
            </a>

            <a href="javascript:void(0);"
            onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"
            class="dropdown-item">
            <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
            </a>
            <a href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'download' => 'true']) }}"
            class="dropdown-item">
            <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
            </a>
            @if(isset($access['delete_invoices']) && $access['delete_invoices'] == 1)
        <a href="#" class="dropdown-item" data-toggle="modal"
        data-target="#deleteinvoiceall-{{ $value->sale_inv_id }}">
        <i class="fas fa-solid fa-trash mr-2"></i> Delete
        </a>
      @endif
            </div>
            </li>
            </ul>
            </td>

            </tr>

            <div class="modal fade" id="deleteinvoiceall-{{ $value->sale_inv_id }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST"
            action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}"
            id="delete-form-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
            @csrf
            @method('DELETE')
            <div class="modal-body pad-1 text-center">
            <i class="fas fa-solid fa-trash delete_icon"></i>
            <p class="company_business_name px-10"><b>Delete invoice</b></p>
            <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>

            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
            <button type="button" class="delete_btn px-15"
            data-id="{{ $value->sale_inv_id }}">Delete</button>
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
    function updateStatus(invoiceId, nextStatus) {
    $.ajax({
      url: "{{ route('business.invoices.statusStore', ':id') }}".replace(':id', invoiceId),
      method: 'POST',
      data: {
      _token: '{{ csrf_token() }}',
      sale_status: nextStatus
      },
      success: function (response) {
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
      error: function (xhr) {
      alert('An error occurred while updating the status.');
      }
    });
    }

    $(document).on('click', '.delete_btn', function () {
    var invoiceId = $(this).data('id');
    var form = $('#delete-form-' + invoiceId);
    var url = form.attr('action');

    $.ajax({
      url: url,
      type: 'POST',
      data: form.serialize(),
      success: function (response) {
      if (response.success) {

        //count update when delete the record 
        var table = $('#example4').DataTable();

        var row = $('#invoices-row-all-' + invoiceId);

        if (row.length > 0) {
        table.row(row).remove().draw(false);
        }

        var example5 = $('#example5').DataTable();

        var example5_row = $('#invoices-row-draft-' + invoiceId);

        if (example5_row.length > 0) {
        example5.row(example5_row).remove().draw(false);
        }

        var example1 = $('#example1').DataTable();

        var example1_row = $('#invoices-row-unpaid-' + invoiceId);

        if (example1_row.length > 0) {
        example1.row(example1_row).remove().draw(false);
        }


        $('#invoices-row-unpaid-' + invoiceId).remove();

        $('#invoices-row-draft-' + invoiceId).remove();

        $('#invoices-row-all-' + invoiceId).remove();

        $('#deleteinvoiceall-' + invoiceId).modal('hide');
        $('#deleteinvoicedraft-' + invoiceId).modal('hide');
        $('#deleteinvoiceunpaid-' + invoiceId).modal('hide');

        //update the raw count
        updateBadgeCount('.nav-pills .nav-link[href="#unpaidinvoice"] .badge');
        updateBadgeCount('.nav-pills .nav-link[href="#draftinvoice"] .badge');

        // alert(response.message);
      } else {
        alert('An error occurred: ' + response.message);
      }
      },
      error: function (xhr) {
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
    function sendInvoice(url, invoiceId) {
    // alert(estimateId); 
    if (confirm('Are you sure you want to send this invoice?')) {
      $.ajax({
      url: url,
      type: 'GET',
      data: {
        _token: '{{ csrf_token() }}'
      },
      success: function (response) {

        alert('Invoice link sent to the customer successfully.');
        location.reload();
      },
      error: function (xhr) {
        alert('An error occurred while sending the invoice.');
      }
      });
    }
    }
  </script>

  <script>
    $(document).ready(function () {
    var defaultStartDate = "";
    var defaultEndDate = "";
    var defaultSaleEstimNumber = "";
    var defaultSaleCusId = "";
    var defaultSaleStatus = "";
    var formInput = document.getElementById('from-datepickerp-hidden');


    $('#from-datepicker').val(defaultStartDate);

    $('#to-datepicker').val(defaultEndDate);

    $('#sale_inv_number').val(defaultSaleEstimNumber);

    $('#sale_cus_id').val(defaultSaleCusId);

    $('#sale_status').val(defaultSaleStatus);

    var fromdatepicker = flatpickr("#from-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "MM/DD/YYYY",
      altFormat: "MM/DD/YYYY",
      onChange: function (selectedDates, dateStr, instance) {

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

    //////////////////////////////////////////////////////

    var fromdatepickerp = flatpickr("#from-datepickerp", {

      locale: 'en',
      altInput: true,
      dateFormat: "MM/DD/YYYY",
      altFormat: "MM/DD/YYYY",
      defaultDate: formInput.value || null,
      onChange: function (selectedDates, dateStr, instance) {

      // fetchFilteredData();
      //alert('edate');
      },
      parseDate: (datestr, format) => {
      return moment(datestr, format, true).toDate();
      },
      formatDate: (date, format, locale) => {
      return moment(date).format(format);
      }
    });
    document.getElementById('from-calendar-iconp').addEventListener('click', function () {
      fromdatepickerp.open();
    });


    var todatepicker = flatpickr("#to-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "MM/DD/YYYY",
      altFormat: "MM/DD/YYYY",
      onChange: function (selectedDates, dateStr, instance) {

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


    $('.filter-text').on('click', function () {
      clearFilters();
    });



    // Function to fetch filtered data
    function fetchFilteredData() {
      var formData = {
      start_date: $('#from-datepicker').val(),
      end_date: $('#to-datepicker').val(),
      sale_inv_number: $('#sale_inv_number').val(),
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
      url: '{{ route('business.invoices.index') }}', // Define the route for filtering
      type: 'GET',
      data: formData,
      success: function (response) {
        // console.log(response);
        $('#filter_data').html(response); // Update the results container with the filtered data
      },
      error: function (xhr) {
        console.error('Error:', xhr);
        alert('An error occurred while fetching data.');
      }
      });
    }

    // Attach change event handlers to filter inputs
    $('#sale_cus_id, #sale_status, #sale_inv_number1').on('change keyup', function (e) {
      e.preventDefault();
      fetchFilteredData();
    });

    $('#sale_inv_number_submit').on('click', function (e) {
      e.preventDefault(); // Prevent default button behavior if inside a form
      fetchFilteredData();
    });

    function clearFilters() {
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

      $('#sale_inv_number').val('');  // Reset input field
      $('#sale_status').val('');  // Reset another dropdown/input field

      // Trigger any additional functionality if needed
      fetchFilteredData(); // Example: Fetch data based on the cleared filters
    }

    });

  </script>
  @endsection
@endif
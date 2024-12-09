@extends('masteradmin.layouts.app')
<title>Profityo | View All Bills</title>
@if(isset($access['view_bills']) && $access['view_bills'] == 1)
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
        <h1 class="m-0">{{ __('Bills') }}</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ __('Bills') }}</li>
        </ol>
      </div><!-- /.col -->
      <div class="col-auto">
        <ol class="breadcrumb float-sm-right">
        @if(isset($access['add_bills']) && $access['add_bills'])
      <a href="{{ route('business.bill.create') }}"><button class="add_btn"><i
        class="fas fa-plus add_plus_icon"></i>{{ __('Create A Bill') }}</button></a>
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
      @if(Session::has('bill-add'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ Session::get('bill-add') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>
      @php
    Session::forget('bill-add');
    @endphp
    @endif

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
        <select class="form-control select2" style="width: 100%;" id="sale_vendor_id" name="sale_vendor_id">
          <option value="" default>All Vendors</option>
          @foreach($vendor as $value)
        <option value="{{ $value->purchases_vendor_id }}">{{ $value->purchases_vendor_name }} </option>
      @endforeach
        </select>
        </div>
        <div class="col-lg-4 col-1024 col-md-6 px-10 d-flex">
        <div class="input-group date" id="fromdate" data-target-input="nearest">
          <x-flatpickr id="from-datepicker" placeholder="From" />
          <div class="input-group-append">
          <span class="input-group-text" id="from-calendar-icon">
            <i class="fa fa-calendar-alt"></i>
          </span>
          </div>
        </div>
        <div class="input-group date" id="todate" data-target-input="nearest">
          <x-flatpickr id="to-datepicker" placeholder="To" />
          <div class="input-group-append">
          <span class="input-group-text" id="to-calendar-icon">
            <i class="fa fa-calendar-alt"></i>
          </span>
          </div>
        </div>
        </div>
      </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div id="filter_data">
      <div class="card px-20">
        <div class="card-body1">
        <div class="col-md-12 table-responsive pad_table">
          <table id="example4" class="table table-hover text-nowrap">
          <thead>
            <tr>
            <th>Vendors</th>
            <th>Number</th>
            <th>Date</th>
            <th>Due Date</th>
            <th>Amount Due</th>
            <th>Due Day</th>
            <th>Status</th>
            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
            </tr>
          </thead>
          <tbody>
            @if (count($allBill) > 0)
            @foreach ($allBill as $value)
          <tr id="row-bill-{{ $value->sale_bill_id }}">
          <td>{{ $value->vendor->purchases_vendor_name ?? ''}}</td>
          <td>{{ $value->sale_bill_number }}</td>
          <td>{{ \Carbon\Carbon::parse($value->sale_bill_date)->format('M d, Y') }}</td>
          <td>{{ \Carbon\Carbon::parse($value->sale_bill_valid_date)->format('M d, Y') }}</td>
          <td>
            {{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_bill_due_amount }}
          </td>
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
          <!-- <td><span class="status_btn Paid_status">{{ $value->sale_status }}</span></td> -->
          <td>
            @php
          // Fetch the current due amount and original amount for this specific record
          $remainingDueAmount = $value->sale_bill_due_amount; // Current due amount
          $originalDueAmount = $value->sale_bill_final_amount;  // Total amount before payment

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
          switch ($value->sale_status) {
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
          <td>
            <ul class="navbar-nav ml-auto float-right">
            <li class="nav-item dropdown d-flex align-items-center">
            <!-- <a class="d-block invoice_underline" data-toggle="modal" data-target="#recordpaymentpopup">Record a payment</a> -->
            <a href="javascript:void(0);" data-toggle="modal"
            data-target="#recordpaymentpopup2{{ $value->sale_bill_id }}">
            Record Payment
            </a>
            <div class="modal fade" id="recordpaymentpopup2{{ $value->sale_bill_id }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Record A Manual Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="POST" id="rcordForm"
            action="{{ route('business.bill.paymentsbillstore', $value->sale_bill_id) }}">
            @csrf
            <input type="hidden" name="invoice_id" value="{{ $value->sale_bill_id }}">

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
              <div class="col-md-6">
              <div class="form-group">
              <label>Date</label>
              <div class="input-group date" id="estimatedate" data-target-input="nearest">
              <input type="hidden" id="from-datepickerp-hidden"
              value="{{ $value->sale_bill_valid_date }}" />
              <!-- <input type="text" class="form-control datetimepicker-input" name="sale_estim_date" placeholder=""
                data-target="#estimatedate" />
                <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                </div> -->
              <x-flatpickr id="from-datepickerp" name="payment_date"
              placeholder="Select a date"
              value="{{ old('payment_date', $value->sale_bill_valid_date) }}" />
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
              <input type="text" name="payment_amount" class="form-control"
              value="{{ $value->sale_bill_due_amount }}"
              aria-describedby="inputGroupPrepend">
              <div class="input-group-append">
              <span class="form-control" style="width: 20%;">
              @if ($value->sale_currency_id)
          {{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}
        @else
        {{ 'Currency not set' }} <!-- Fallback if currency_id is not set -->
      @endif
              </span>
              </div>
              </div>
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
              <label>Method</label>
              <select class="form-control form-select" name="payment_method">
              <option>Select a Payment Account...</option>
              @foreach($paymethod as $pay)
          <option value="{{ $pay->m_id }}">{{ $pay->method_name }}</option>
          <!-- Store ID -->
        @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-6">
              <label>Account <span class="text-danger">*</span></label>
              <select class="form-control form-select" id="payment_account" name="payment_account"
              placeholder="Enter your text here">
              <option>Select a Payment Account...</option>
              @foreach($accounts as $account)
          <option value="{{ $account->chart_acc_id }}">{{ $account->chart_acc_name }}
          </option> <!-- Store ID -->
        @endforeach
              </select>
              <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds From.
              </p>
              <span id="payment_accountError" class="text-danger mt-2" style="display:none;">Please enter Account name.</span>
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



            <a class="nav-link user_nav" data-toggle="dropdown" href="#">
            <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ route('business.bill.view', $value->sale_bill_id) }}" class="dropdown-item">
            <i class="fas fa-regular fa-eye mr-2"></i> View
            </a>
            <a href="{{ route('business.bill.edit', $value->sale_bill_id) }}" class="dropdown-item">
            <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
            </a>
            <a href="{{ route('business.bill.duplicate', $value->sale_bill_id) }}" class="dropdown-item">
            <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
            </a>
            <a href="#" class="dropdown-item" data-toggle="modal"
            data-target="#deletebill_{{ $value->sale_bill_id }}">
            <i class="fas fa-solid fa-trash mr-2"></i> Delete
            </a>


            </div>
            </li>
            </ul>
          </td>

          <div class="modal fade" id="deletebill_{{ $value->sale_bill_id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST"
            action="{{ route('business.bill.destroy', ['id' => $value->sale_bill_id]) }}"
            id="delete-form-{{ $value->sale_bill_id }}" data-id="{{ $value->sale_bill_id }}">
            @csrf
            @method('DELETE')
            <div class="modal-body pad-1 text-center">
            <i class="fas fa-solid fa-trash delete_icon"></i>
            <p class="company_business_name px-10"><b>Delete Bill</b></p>
            <p class="company_details_text px-10">Delete Bill {{ $value->sale_bill_id }}</p>
            <p class="company_details_text">Are You Sure You Want to Delete This Bill?</p>
            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
            <button type="button" class="delete_btn px-15"
            data-id="{{ $value->sale_bill_id }}">Delete</button>
            </div>
            </form>
            </div>
            </div>
          </div>

          </tr>

      @endforeach
      @else
  @endif
          </tbody>
          </table>
        </div>
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

  <!-- <div class="modal fade" id="recordpaymentpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Record A Manual Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
        <div class="row pxy-15 px-10">
          <div class="col-md-6">
          <div class="form-group">
            <label>Payment Date</label>
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
            <input type="number" class="form-control" aria-describedby="inputGroupPrepend" placeholder="$12.50"> 
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
    </div> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>

  <script>
    $(document).on('click', '.delete_btn', function () {
    var invoiceId = $(this).data('id');
    var form = $('#delete-form-' + invoiceId);
    var url = form.attr('action');
    var formInput = document.getElementById('from-datepickerp-hidden');

    $.ajax({
      url: url,
      type: 'POST',
      data: form.serialize(),
      success: function (response) {
      // console.log(response);
      if (response.success) {
        // alert('jiiii');
        //count update when delete the record 
        var table = $('#example4').DataTable();

        var row = $('#row-bill-' + invoiceId);

        if (row.length > 0) {
        table.row(row).remove().draw(false);
        }

        $('#row-bill-' + invoiceId).remove();

        $('#deletebill_' + invoiceId).modal('hide');

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


  </script>
  <script>
    $(document).ready(function () {
    var defaultStartDate = "";
    var defaultEndDate = "";
    var defaultSaleCusId = "";

    $('#from-datepicker').val(defaultStartDate);

    $('#to-datepicker').val(defaultEndDate);

    $('#sale_vendor_id').val(defaultSaleCusId);

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

    var todatepicker = flatpickr("#to-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "MM/DD/YYYY",
      altFormat: "MM/DD/YYYY",
      onChange: function (selectedDates, dateStr, instance) {

      fetchFilteredData();

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
      sale_vendor_id: $('#sale_vendor_id').val(),
      _token: '{{ csrf_token() }}'
      };



      // alert(start_date);
      // alert(end_date);
      // alert(sale_cus_id);
      // alert(sale_estim_number);
      // console.log('Form Data:', formData); // Debug: Log form data to console


      $.ajax({
      url: '{{ route('business.bill.index') }}',
      type: 'GET',
      data: formData,
      success: function (response) {
        $('#filter_data').html(response); // Update the results container with HTML content

      },
      error: function (xhr) {
        console.error('Error:', xhr);
        // alert('An error occurred while fetching data.');
      }
      });

    }



    // Attach change event handlers to filter inputs
    $('#sale_vendor_id').on('change keyup', function (e) {
      e.preventDefault();
      fetchFilteredData();
    });

    function clearFilters() {
      // Clear filters
      $('#sale_vendor_id').val('').trigger('change');


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

      // $('#from-datepicker').flatpickr().clear();  // Clear "from" datepicker
      // $('#to-datepicker').flatpickr().clear();    // Clear "to" datepicker

      fetchFilteredData();
    }


    });
    var formInput = document.getElementById('from-datepickerp-hidden');

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
    
  </script>
<script>
$(document).ready(function() {
    // Form submit event
    $('#rcordForm').on('submit', function(e) {
        var companyField = $('#payment_account');
        var errorField = $('#payment_accountError');

        // Check if the company name field is empty
        if (companyField.val().trim() === "") {
            errorField.show(); // Show the error message
            companyField.addClass("is-invalid"); // Add invalid class to highlight the field
            e.preventDefault(); // Prevent form submission
        } else {
            errorField.hide(); // Hide the error message if input is valid
            companyField.removeClass("is-invalid"); // Remove invalid class if input is valid
        }
    });

    // Hide error message when the user starts typing
    $('#payment_account').on('input', function() {
        var errorField = $('#payment_accountError');
        if ($(this).val().trim() !== "") {
            errorField.hide(); // Hide the error message if the field is no longer empty
            $(this).removeClass("is-invalid"); // Remove the invalid class
        }
    });
});
</script>
  @endsection
@endif
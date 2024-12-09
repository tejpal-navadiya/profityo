<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profityo | Business Detail</title>
  @if(isset($access['view_vendors']) && $access['view_vendors'])
    @include('masteradmin.layouts.headerlink')
    <link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">

  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    @include('masteradmin.layouts.navigation')
    @include('masteradmin.layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
        <div class="col-auto">
          <h1 class="m-0">Vendor Detail</h1>
          <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Vendor</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
          <a data-toggle="modal"
            data-target="#delete-vendor-modal-{{ $PurchasVendor->purchases_vendor_id }}"><button
            class="add_btn_br"><i class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
          <a href="{{ route('business.purchasvendor.edit', $PurchasVendor->purchases_vendor_id) }}"><button
            class="add_btn_br"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
          <a href="{{ route('business.purchasvendor.create') }}"><button class="add_btn">Create Another
            Vendor</button></a>
          </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      </div>
      <input type="hidden" name="sale_vendor_id" id="sale_vendor_id" value="{{ $PurchasVendor->purchases_vendor_id }}">
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content px-10">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-6">
          <div class="card">
          <div class="card-header">
            <h3 class="card-title">Vendor Information</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p class="company_business_name"> {{ $PurchasVendor->purchases_vendor_name }}
            {{ $PurchasVendor->purchases_vendor_last_name }}</p>
            <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_email }}</p>
            <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_phone }}</p>
            <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_address1 }} </p>
          </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
          <div class="card-header">
            <h3 class="card-title">Additional Information</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_account_number }}</p>
            <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_zipcode }}</p>
            <p class="company_details_text">-</p>
            <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_website }}</p>
          </div>
          </div>
        </div>
        </div>
        <?php  //dd($PurchasVendor); ?>

        <div class="card">
        <div class="card-header">
          <div class="row justify-content-between align-items-center">
          <div class="col-auto">
            <h3 class="card-title">Bills</h3>
          </div>
          <div class="col-auto"><a href="{{ route('business.bill.create') }}"><button class="reminder_btn">Create
              Bill</button></a></div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <!-- <div class="col-md-3">
          <div class="input-group">
            <input type="search" class="form-control" placeholder="Search by Description">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
          </div> -->
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
        <div class="vendordividerline"></div>
        <div id="filter_data">
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
              <?php  //dd($bills); ?>
              @if (count($bills) > 0)
              @foreach ($bills as $value)
            <tr id="row-bill-{{ $value->sale_bill_id }}">
            <td>{{ $value->vendor->purchases_vendor_name }}</td>
            <td>{{ $value->sale_bill_number }}</td>
            <td>{{ \Carbon\Carbon::parse($value->sale_bill_date)->format('M d, Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($value->sale_bill_valid_date)->format('M d, Y') }}</td>
            <td>
            {{ $currencys->find($value->sale_currency_id)->currency_symbol }}{{ $value->sale_bill_due_amount }}
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
              <form method="POST"
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
              <div class="col-md-3">
              <div class="form-group">
              <label>Date</label>
              <div class="input-group date" id="estimatedate"
              data-target-input="nearest">
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
              <span class="form-control" style="width: 20%;">
              @if ($value->sale_currency_id)
          {{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}
        @else
        {{ 'Currency not set' }} <!-- Fallback if currency_id is not set -->
      @endif
              </span>
              <input type="text" name="payment_amount"
              class="form-control amount_input"
              value="{{ $value->sale_bill_due_amount }}"
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
          <option value="{{ $pay->m_id }}">{{ $pay->method_name }}</option>
          <!-- Store ID -->
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
          <option value="{{ $account->chart_acc_id }}">
          {{ $account->chart_acc_name }}</option> <!-- Store ID -->
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
            <a href="{{ route('business.bill.duplicate', $value->sale_bill_id) }}"
            class="dropdown-item">
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
        <tr class="odd">
        <td valign="top" colspan="7" class="dataTables_empty">No records found</td>
        </tr>
      @endif
            </tbody>
            </table>
          </div>
          </div>
        </div>
        </div>
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
    <div class="modal fade" id="delete-vendor-modal-{{ $PurchasVendor->purchases_vendor_id }}" tabindex="-1"
      role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="delete-plan-form"
        action="{{ route('business.purchasvendor.destroy', ['PurchasesVendor' => $PurchasVendor->purchases_vendor_id]) }}"
        method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Vendor</b></p>
          <!-- <p class="company_details_text px-10">Delete Vendor</p> -->
          <p class="company_details_text">Are You Sure You Want to Delete This vendor?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          @csrf
          @method('DELETE')
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
        </form>
      </div>
      </div>
    </div>
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
    </div>
    <!-- ./wrapper -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script>
    $(document).ready(function () {
      var sale_vendor_id = $('#sale_vendor_id').val();
      // alert(sale_vendor_id);
      var defaultStartDate = "";
      var defaultEndDate = "";

      $('#from-datepicker').val(defaultStartDate);

      $('#to-datepicker').val(defaultEndDate);


      var fromdatepicker = flatpickr("#from-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "MM/DD/YYYY",
      altFormat: "MM/DD/YYYY",
      allowInput: true,
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
      allowInput: true,
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
        _token: '{{ csrf_token() }}'
      };



      // alert(start_date);
      // alert(end_date);
      // alert(sale_cus_id);
      // alert(sale_estim_number);
      // console.log('Form Data:', formData); // Debug: Log form data to console


      $.ajax({
        url: '{{ route("business.vendordetails.show", ":id") }}'.replace(':id', sale_vendor_id),
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
      $('#sale_vendor_id, #from-datepicker, #to-datepicker').on('change keyup', function (e) {
      e.preventDefault();
      fetchFilteredData();
      });

      function clearFilters() {
      // Clear filters
      $('#sale_vendor_id').val('').trigger('change');


      const fromDatePicker = flatpickr('#from-datepicker');
      const toDatePicker = flatpickr('#to-datepicker');
      fromDatePicker.clear(); // Clears the "from" datepicker
      toDatePicker.clear();   // Clears the "to" datepicker

      // $('#from-datepicker').flatpickr().clear();  // Clear "from" datepicker
      // $('#to-datepicker').flatpickr().clear();    // Clear "to" datepicker

      fetchFilteredData();
      }


    });

    </script>
    @include('masteradmin.layouts.footerlink')
  @endif
</body>

</html>
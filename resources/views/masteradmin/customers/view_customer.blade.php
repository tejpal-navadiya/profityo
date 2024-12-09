<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profityo | Business Detail</title>
  @include('masteradmin.layouts.headerlink')
  <link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
              <h1 class="m-0">Customer Detail</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Customer</li>
              </ol>
            </div><!-- /.col -->
            <div class="col-auto">
              <ol class="breadcrumb float-sm-right">
                <a href="#" data-toggle="modal" data-target="#deletecustomer-{{ $SalesCustomers->sale_cus_id }}"><button
                    class="add_btn_br"><i class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
                <a href="#"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Send
                    Statement</button></a>
                <a href="{{ route('business.estimates.create') }}"><button class="add_btn_br"><i
                      class="fas fa-solid fa-file-invoice mr-2"></i>Create Estimate</button></a>
                <a href="{{ route('business.invoices.create') }}"><button class="add_btn_br"><i
                      class="fas fa-solid fa-file-invoice mr-2"></i>Create Invoice</button></a>
                <a href="{{ route('business.salescustomers.edit', $SalesCustomers->sale_cus_id) }}"><button
                    class="add_btn_br"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
                <a href="{{ route('business.salescustomers.create') }}"><button class="add_btn">Create Another
                    Customer</button></a>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content px-10">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Customer Information</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <p class="company_business_name">{{ $SalesCustomers->sale_cus_first_name }}
                    {{ $SalesCustomers->sale_cus_last_name }}
                  </p>
                  <p class="company_details_text">{{ $SalesCustomers->sale_cus_email }}</p>
                  <p class="company_details_text">{{ $SalesCustomers->sale_cus_phone }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Billing Information</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <p class="company_business_name">{{ $SalesCustomers->sale_cus_first_name }}
                    {{ $SalesCustomers->sale_cus_last_name }}
                  </p>
                  <p class="company_details_text">{{ $SalesCustomers->sale_bill_address1 }},
                    {{ $SalesCustomers->sale_bill_country_id }}, {{ $SalesCustomers->sale_bill_city_name }}
                    ,{{ $SalesCustomers->sale_bill_zipcode }}
                  </p>
                  <p class="company_details_text">{{ $SalesCustomers->sale_cus_phone }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Shipping Information</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <p class="company_business_name">{{ $SalesCustomers->sale_cus_first_name }}
                    {{ $SalesCustomers->sale_cus_last_name }}
                  </p>
                  <p class="company_details_text">{{ $SalesCustomers->sale_ship_address1 }},
                    {{ $SalesCustomers->sale_ship_country_id }}, {{ $SalesCustomers->sale_ship_city_name }}
                    ,{{ $SalesCustomers->sale_ship_zipcode }}
                  </p>
                  <p class="company_details_text">{{ $SalesCustomers->sale_ship_phone }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="card-header d-flex p-0 justify-content-center tab_panal">
            <ul class="nav nav-pills p-2 tab_box">
              <li class="nav-item"><a class="nav-link active" href="#customeroverview" data-toggle="tab">Overview</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#customerinvoice" data-toggle="tab">Invoices</a></li>
              <li class="nav-item"><a class="nav-link" href="#customeractivity" data-toggle="tab">Activity</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="tab-content px-20">
            <div class="tab-pane active" id="customeroverview">
              <div class="card">
                <div class="col-lg-12 card-body3">
                  <div class="row align-items-center">
                    <div class="col-lg-3 col-invoice-box col-md-6">
                      <div class="invoice_count_box_br1">
                        <div class="invoice_count_box in-primary">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
                                class="invoice_report_icon icon_cr1"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Paid last 12 Months</p>
                              <p class="in_contact_total text_color1">${{ number_format($totalPaidLast12Months, 2) }}</p>
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
                              <p class="in_contact_title">Total Unpaid</p>
                              <p class="in_contact_total text_color4">${{ number_format($totalUnpaid, 2) }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto ml-auto">
                      <p class="estimate_view_title">Last Item Sent</p>
                      <p class="invoiceid_text mb-0">Estimate on Apr 19</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <h3 class="card-title">Unpaid Invoices</h3>
                    </div>
                    <div class="col-auto"><button class="reminder_btn">Send Reminder</button></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body1">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example1" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <!-- <th>Customer</th> -->
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
                      <!-- <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td> -->
                      <td>{{ $value->sale_inv_number }}</td>
                      <td>{{ $value->sale_inv_date }}</td>
                      <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_inv_final_amount }}</td>
                      <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_inv_due_amount }}</td>
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
                action="{{ route('business.customerdetails.paymentsstore', $value->sale_inv_id) }}">
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
                <span class="form-control" style="width: 20%;">
        @if ($value->sale_currency_id)
            {{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}
        @else
            {{ 'Currency not set' }} <!-- Fallback if currency_id is not set -->
        @endif
    </span>
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
                <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds
                From.
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
                <button type="button" class="add_btn_br"
                data-dismiss="modal">Cancel</button>
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
                        <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}"
                        class="dropdown-item">
                        <i class="fas fa-regular fa-eye mr-2"></i> View
                        </a>
                        @if(isset($access['update_invoices']) && $access['update_invoices'])
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
                        @if(isset($access['delete_invoices']) && $access['delete_invoices'])
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
                      id="delete-form1-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
                      @csrf
                      @method('DELETE')
                      <div class="modal-body pad-1 text-center">
                        <i class="fas fa-solid fa-trash delete_icon"></i>
                        <p class="company_business_name px-10"><b>Delete invoice</b></p>
                        <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>

                        <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                        <button type="button" class="delete_btn1 px-15"
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
              </div>
            </div>
            <!-- /.card-header -->

            <!-- /.tab-pane -->
            <div class="tab-pane" id="customerinvoice">
              <div class="card">
                <div class="col-lg-12 card-body3">
                  <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br1">
                        <div class="invoice_count_box in-primary">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
                                class="invoice_report_icon icon_cr1"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Total Unpaid</p>
                              <p class="in_contact_total text_color1">${{ number_format($totalUnpaid, 2) }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br4">
                        <div class="invoice_count_box in-info">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
                                class="invoice_report_icon icon_cr4"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Overdue</p>
                              <p class="in_contact_total text_color4">${{ number_format($overdueTotal, 2) }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br2">
                        <div class="invoice_count_box in-secondary">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
                                class="invoice_report_icon icon_cr2"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Average Time To Pay</p>
                              <p class="in_contact_total text_color2">0 Days</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br3">
                        <div class="invoice_count_box in-success">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="{{url('public/dist/img/invoice_report.svg')}}"
                                class="invoice_report_icon icon_cr3"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Not Yet Due</p>
                              <p class="in_contact_total text_color3">$0.00</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 pad-4">
                  <div class="row justify-content-between">
                    <div class="col-md-3 px-10">
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
                        <div class="input-group date">
                          <x-flatpickr id="to-datepicker" placeholder="To" />
                          <div class="input-group-append">
                            <span class="input-group-text" id="to-calendar-icon">
                              <i class="fa fa-calendar-alt"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 px-10">
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
              </div>
              <div class="card">
                <div class="card-header">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <h3 class="card-title">Invoices</h3>
                    </div>
                    <div class="col-auto"><a href="{{ route('business.invoices.create') }}"><button
                          class="reminder_btn">Create invoice</button></a></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div id="filter_data">
                  <div class="card-body1">
                    <div class="col-md-12 table-responsive pad_table">
                      <table id="example4" class="table table-hover text-nowrap">
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
                          @if (count($allInvoices) > 0)
                          @foreach ($allInvoices as $value)
                      <tr id="invoices-row-all-{{ $value->sale_inv_id }}">
                      <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}
                      </td>
                      <td>{{ $value->sale_inv_number }}</td>
                      <td>{{ $value->sale_inv_date }}</td>
                      <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_inv_final_amount }}</td>
                      <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_inv_due_amount }}</td>
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
              <div class="modal fade" id="recordpaymentpopup2{{ $value->sale_inv_id }}"
              tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
              aria-hidden="true">
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
                action="{{ route('business.customerdetails.paymentsstore', $value->sale_inv_id) }}">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $value->sale_inv_id }}">

                <div class="row pxy-15 px-10">
                <div class="col-md-12">
                <p>Record a Payment you've Already Received, Such As Cash, Check, or
                Bank Payment.</p>
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
                <span class="form-control" style="width: 20%;">
                    @if ($value->sale_currency_id)
                        {{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}
                    @else
                        {{ 'Currency not set' }} <!-- Fallback if currency_id is not set -->
                    @endif
                </span>
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
                <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds
                From.
                </p>
                </div>

                <div class="col-md-12">
                <div class="form-group">
                <label for="recordpaymentmemonotes">Memo / Notes</label>
                <textarea id="recordpaymentmemonotes" class="form-control"
                name="notes" rows="3" placeholder="Enter your text here"></textarea>
                </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="add_btn_br"
                data-dismiss="modal">Cancel</button>
                <button type="submit" class="add_btn">Save</button>
                </div>
                </form>

              </div>
              </div>
              </div>
              </div>


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
          action="{{ route('business.customerdetails.paymentsstore', $value->sale_inv_id) }}">
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
                        <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                        <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}"
                        class="dropdown-item">
                        <i class="fas fa-regular fa-eye mr-2"></i> View
                        </a>
                        @if(isset($access['update_invoices']) && $access['update_invoices'])
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
                        @if(isset($access['delete_invoices']) && $access['delete_invoices'])
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
                        id="delete-form2-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                        <i class="fas fa-solid fa-trash delete_icon"></i>
                        <p class="company_business_name px-10"><b>Delete invoice</b></p>
                        <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>

                        <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                        <button type="button" class="delete_btn2 px-15"
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
                </div>
              </div>
            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane" id="customeractivity">
              <div class="card">
                <div class="card-header">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                      <h3 class="card-title">Activity</h3>
                    </div>
                    <div class="col-auto"><a href="{{ route('business.invoices.create') }}"><button
                          class="reminder_btn">Create invoice</button></a></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 px-10">
                      <div class="input-group">
                        <input type="search" class="form-control" name="log_msg" placeholder="Enter Description #"
                          id="log_msg">
                        <div class="input-group-append" id="log_msg_submit">
                          <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-1024 col-md-6 px-10 d-flex">
                      <div class="input-group date">
                        <x-flatpickr id="from-datepicker-active" placeholder="From" />
                        <div class="input-group-append">
                          <span class="input-group-text" id="from-calendar-icon-active">
                            <i class="fa fa-calendar-alt"></i>
                          </span>
                        </div>
                        <div class="input-group date">
                          <x-flatpickr id="to-datepicker-active" placeholder="To" />
                          <div class="input-group-append">
                            <span class="input-group-text" id="to-calendar-icon-active">
                              <i class="fa fa-calendar-alt"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card">
                  <div class="card-body2">
                    <div class="row">
                      <div class="col-md-12" id="accordion">
                        <div id="filter_data_activity">
                          @foreach($sentLogs as $log)
                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne-{{ $loop->index }}">
                <div class="card-header accordion-button">
                  <div class="row align-items-center">
                  <div class="col-auto">
                    <p class="mb-0">{{ $log->created_at->format('M d') }}</p>
                  </div>
                  <div class="col-auto align-items-center d-flex">
                    <img src="{{url('public/dist/img/send.svg')}}" class="send_icon">
                    <p class="invoiceid_text mar_15 mb-0">{{ $log->log_msg }}</p>
                  </div>
                  <div class="col-auto">
                    <button class="status_btn mar_15">Sent</button>
                  </div>
                  </div>
                </div>
                </a>

                <div id="collapseOne-{{ $loop->index }}" class="collapse" data-parent="#accordion">
                <div class="card-body">
                  <div class="row justify-content-between">
                  <div class="col-auto">
                    <table class="table estimate_detail_table">
                    @if($log->log_type == 1 && $log->estimate)
            <tr>
              <td><strong>Date</strong></td>
              <td>{{ $log->estimate->sale_estim_date }}</td>
            </tr>
            <tr>
              <td><strong>Due Date</strong></td>
              <td>{{ $log->estimate->sale_estim_valid_date }}</td>
            </tr>
            <tr>
              <td><strong>P.O/S.O</strong></td>
              <td>{{ $log->estimate->sale_estim_customer_ref }}</td>
            </tr>
            <tr>
              <td><strong>Items</strong></td>
              <td>{{ $log->estimate->sale_estim_date }}</td>
            </tr>
            <tr>
              <td><strong>Total</strong></td>
              <td>{{ $log->estimate->sale_estim_final_amount }}</td>
            </tr>
          @elseif($log->log_type == 2 && $log->invoice)
      <tr>
        <td><strong>Date</strong></td>
        <td>{{ $log->invoice->sale_inv_date }}</td>
      </tr>
      <tr>
        <td><strong>Due Date</strong></td>
        <td>{{ $log->invoice->sale_inv_valid_date }}</td>
      </tr>
      <tr>
        <td><strong>P.O/S.O</strong></td>
        <td>{{ $log->invoice->sale_inv_customer_ref }}</td>
      </tr>
      <tr>
        <td><strong>Items</strong></td>
        <td>{{ $log->allInvoices->sale_inv_item_qty ?? 'n/a' }}</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td>{{ $log->invoice->sale_inv_final_amount ?? 'n/a' }}</td>
      </tr>
    @else
    <tr>
      <td colspan="2">No related data found.</td>
    </tr>
  @endif
                    </table>
                  </div>
                  <div class="col-auto">
                    <a href="#"><button class="add_btn_br">View related events</button></a>

                    @if($log->log_type == 1)
            <a href="{{ route('business.estimates.view', $log->estimate->sale_estim_id) }}"><button
              class="add_btn">View Estimate</button></a>
          @elseif($log->log_type == 2 && $log->invoice)
      <a href="{{ route('business.invoices.view', $log->invoice->sale_inv_id) }}">
      <button class="add_btn">View Invoice</button>
      </a>
    @endif
                  </div>
                  </div>
                </div>
                </div>
              @endforeach
                        </div>

                      </div>
                    </div>
                  </div>
                </div>



                <!-- <div class="col-md-12" id="accordion">
                      <a class="d-block w-100" data-toggle="collapse" href="#collapsetwo">
                        <div class="card-header accordion-button">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <P class="mb-0">Apr 19</P>
                            </div>
                            <div class="col-auto align-items-center d-flex">
                              <img src="dist/img/send.svg" class="send_icon">
                              <p class="invoiceid_text mar_15 mb-0">Estimate #2 for $13.50</p>
                            </div>
                            <div class="col-auto">
                              <button class="status_btn mar_15">Sent</button>
                            </div>
                          </div>
                        </div>
                      </a>
                      <div id="collapsetwo" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                          <div class="row justify-content-between">
                            <div class="col-auto">
                              <table class="table estimate_detail_table">
                                <div>
                                  <td><strong>Invoice Date</strong></td>
                                  <td>2024-04-04</td>
                                </tr>
                                <tr>
                                  <td><strong>Due Date</strong></td>
                                  <td>Within 30 Days</td>
                                </tr>
                                <tr>
                                  <td><strong>P.O/S.O</strong></td>
                                  <td>adasd</td>
                                </tr>
                                <tr>
                                  <td><strong>Items</strong></td>
                                  <td>1</td>
                                </tr>
                                <tr>
                                  <td><strong>Total</strong></td>
                                  <td>$13.50</td>
                                </tr>
                              </table>
                            </div> -->

              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  </div>
  </div>
  <!-- /.tab-pane -->
  </div>
  <!-- /.tab-content -->
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
              <form>
                <div class="row pxy-15 px-10">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="customer">Customer <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="customer" placeholder="Business Or Person" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_email">Email</label>
                      <input type="email" class="form-control" id="customer_email" placeholder="Enter Email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_phonenumber">Phone</label>
                      <input type="Number" class="form-control" id="customer_phonenumber"
                        placeholder="Enter Phone Number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_firstname">First Name</label>
                      <input type="text" class="form-control" id="customer_firstname" placeholder="First Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_lastname">Last Name</label>
                      <input type="text" class="form-control" id="customer_lastname" placeholder="Last Name">
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="editbilling">
              <form>
                <div class="row pxy-15 px-10">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Currency <span class="text-danger">*</span></label>
                      <select class="form-control select2" style="width: 100%;" required>
                        <option default>Select a Currency...</option>
                        <option>CAD ($) - Canadian dollar</option>
                        <option>USD ($) - United States dollar</option>
                        <option>AED (AED) - UAE dirham</option>
                        <option>AFN (؋) - Afghani</option>
                        <option>ALL (Lek) - Lek</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal_sub_title">Billing Address</div>
                <div class="row pxy-15 px-10">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress1">Address Line 1</label>
                      <input type="text" class="form-control" id="company-businessaddress1"
                        placeholder="Enter a Location">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress2">Address Line 2</label>
                      <input type="text" class="form-control" id="company-businessaddress2"
                        placeholder="Enter a Location">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesscity">City</label>
                      <input type="text" class="form-control" id="company-businesscity" placeholder="Enter A City">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesszipcode">Postal/ZIP Code</label>
                      <input type="text" class="form-control" id="company-businesszipcode"
                        placeholder="Enter a Zip Code">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Country</label>
                      <select class="form-control select2" style="width: 100%;">
                        <option default>Select a Country...</option>
                        <option>USA</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Province/State</label>
                      <select class="form-control select2" style="width: 100%;">
                        <option default>Select a State...</option>
                        <option>Pennsylvania</option>
                      </select>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="editshipping">
              <form>
                <div class="modal_sub_title px-15">Shipping Address</div>
                <div class="row pxy-15 px-10">
                  <div class="col-md-12">
                    <div class="icheck-primary">
                      <input type="radio" id="shippingaddress" name="shipping">
                      <label for="shippingaddress">Same As Billing Address</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer">Ship to Contact <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="customer" placeholder="Business Or Person" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customer_phonenumber">Phone</label>
                      <input type="Number" class="form-control" id="customer_phonenumber"
                        placeholder="Enter Phone Number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress1">Address Line 1</label>
                      <input type="text" class="form-control" id="company-businessaddress1"
                        placeholder="Enter a Location">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress2">Address Line 2</label>
                      <input type="text" class="form-control" id="company-businessaddress2"
                        placeholder="Enter a Location">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesscity">City</label>
                      <input type="text" class="form-control" id="company-businesscity" placeholder="Enter A City">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businesszipcode">Postal/ZIP Code</label>
                      <input type="text" class="form-control" id="company-businesszipcode"
                        placeholder="Enter a Zip Code">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Country</label>
                      <select class="form-control select2" style="width: 100%;">
                        <option default>Select a Country...</option>
                        <option>USA</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Province/State</label>
                      <select class="form-control select2" style="width: 100%;">
                        <option default>Select a State...</option>
                        <option>Pennsylvania</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="deliveryinstructions">Delivery instructions</label>
                      <input type="text" class="form-control" id="deliveryinstructions" placeholder="">
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="editmore">
              <form>
                <div class="row pxy-15 px-10">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customeraccountnumber">Account Number</label>
                      <input type="Number" class="form-control" id="customeraccountnumber" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customerfax">Fax</label>
                      <input type="Number" class="form-control" id="customerfax" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customermobile">Mobile</label>
                      <input type="Number" class="form-control" id="customermobile" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customertollfree">Toll-free</label>
                      <input type="Number" class="form-control" id="customertollfree" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="customerwebsite">Website</label>
                      <input type="text" class="form-control" id="customerwebsite" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="customerinternalnotes">Internal Notes</label>
                      <textarea id="customerinternalnotes" class="form-control" rows="3"
                        placeholder="Notes entered here will not be visible to your customer"></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="modal fade" id="recordpaymentpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
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
              <div class="col-md-12">
                <p>Record a Payment you've Already Received, Such As Cash, Check, or Bank Payment.</p>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date</label>
                  <div class="input-group date" id="estimatedate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder=""
                      data-target="#estimatedate">
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
                  <textarea id="recordpaymentmemonotes" class="form-control" rows="3"
                    placeholder="Enter your text here"></textarea>
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
  <div class="modal fade" id="deletecustomer-{{ $SalesCustomers->sale_cus_id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">

        <form id="delete-form-{{ $SalesCustomers->sale_cus_id }}" data-id="{{ $SalesCustomers->sale_cus_id }}"
          method="POST" action="{{ route('business.salescustomers.destroy', $SalesCustomers->sale_cus_id) }}">
          @csrf
          @method('DELETE')

          <div class="modal-body pad-1 text-center">
            <i class="fas fa-solid fa-trash delete_icon"></i>
            <p class="company_business_name px-10"><b>Delete Customer</b></p>
            <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
            <button type="submit" class="delete_btn px-15" data-id="{{ $SalesCustomers->sale_cus_id }}">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <!-- ./wrapper --> 
  @include('masteradmin.layouts.footerlink')


  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $(document).on('click', '.delete_btn', function () {
      var invoiceId = $(this).data('id'); // Get the customer ID
      var form = $('#delete-form-' + invoiceId);
      var url = "{{ route('business.salescustomers.destroy', ':id') }}"; // Use the named route
      url = url.replace(':id', invoiceId); // Replace with the actual ID

      // Send DELETE request using AJAX
      $.ajax({
        url: url,
        type: 'DELETE', // Use DELETE method
        data: form.serialize(), // Serialize form data
        success: function (response) {
          window.location.href = "{{ route('business.salescustomers.index') }}";
          // if (response.success) {
          //     // Redirect or update the UI dynamically
          //     window.location.href = "{{ route('business.salescustomers.index') }}";
          // } else {
          //     alert('An error occurred: ' + response.message);
          // }
        },
        error: function (xhr) {
          alert('An error occurred while deleting the record.');
        }
      });
    });
  </script>
  <script>
    $(document).ready(function () {
      var defaultStartDate = "";
      var defaultEndDate = "";
      var defaultSaleEstimNumber = "";
      var defaultSaleStatus = "";


      $('#from-datepicker').val(defaultStartDate);

      $('#to-datepicker').val(defaultEndDate);

      $('#sale_inv_number').val(defaultSaleEstimNumber);


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
          sale_status: $('#sale_status').val(),
          _token: '{{ csrf_token() }}'
        };



        // alert(start_date);
        // alert(end_date);
        // alert(sale_cus_id);
        // alert(sale_estim_number);
        // console.log('Form Data:', formData); // Debug: Log form data to console


        $.ajax({
          url: "{{ route('business.customerdetails.show', ['sale_cus_id' => $SalesCustomers->sale_cus_id]) }}",
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
      $(' #sale_status, #sale_inv_number1').on('change keyup', function (e) {
        e.preventDefault();
        fetchFilteredData();
      });

      $('#sale_inv_number_submit').on('click', function (e) {
        e.preventDefault(); // Prevent default button behavior if inside a form
        fetchFilteredData();
      });

      function clearFilters() {

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
  <!-- activity -->
  <script>
    $(document).ready(function () {
      var defaultStartDate = "";
      var defaultEndDate = "";
      var defaultSaleEstimNumber = "";
      // var defaultSaleStatus = "";


      $('#from-datepicker-active').val(defaultStartDate);

      $('#to-datepicker-active').val(defaultEndDate);

      $('#log_msg').val(defaultSaleEstimNumber);


      // $('#sale_status').val(defaultSaleStatus);

      var fromdatepicker = flatpickr("#from-datepicker-active", {
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
      document.getElementById('from-calendar-icon-active').addEventListener('click', function () {
        fromdatepicker.open();
      });

      var todatepicker = flatpickr("#to-datepicker-active", {
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
      document.getElementById('to-calendar-icon-active').addEventListener('click', function () {
        todatepicker.open();
      });


      $('.filter-text').on('click', function () {
        clearFilters();
      });



      // Function to fetch filtered data
      function fetchFilteredData() {
        var formData = {
          start_date_active: $('#from-datepicker-active').val(),
          end_date_active: $('#to-datepicker-active').val(),
          log_msg: $('#log_msg').val(),
          activity_filter: 'activity_filter',
          _token: '{{ csrf_token() }}'
        };



        // alert(start_date);
        // alert(end_date);
        // alert(sale_cus_id);
        // alert(sale_estim_number);
        // console.log('Form Data:', formData); // Debug: Log form data to console


        $.ajax({
          url: "{{ route('business.customerdetails.show', ['sale_cus_id' => $SalesCustomers->sale_cus_id]) }}",
          type: 'GET',
          data: formData,
          success: function (response) {
            // console.log(response);
            $('#filter_data_activity').html(response); // Update the results container with the filtered data
          },
          error: function (xhr) {
            console.error('Error:', xhr);
            alert('An error occurred while fetching data.');
          }
        });
      }

      // // Attach change event handlers to filter inputs
      // $(' #sale_status, #sale_inv_number1').on('change keyup', function (e) {
      //   e.preventDefault();
      //   fetchFilteredData();
      // });

      $('#log_msg_submit').on('click', function (e) {
        e.preventDefault(); // Prevent default button behavior if inside a form
        fetchFilteredData();
      });

      function clearFilters() {

        // Clear datepicker fields
        const fromDatePicker = flatpickr("#from-datepicker-active", {
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

        const todatepicker = flatpickr("#to-datepicker-active", {
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

        $('#log_msg').val('');  // Reset input field
        // $('#sale_status').val('');  // Reset another dropdown/input field

        // Trigger any additional functionality if needed
        fetchFilteredData(); // Example: Fetch data based on the cleared filters
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
  <!-- end -->
</body>

</html>
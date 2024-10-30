@extends('masteradmin.layouts.app')
<title>Dashboard | Profityo</title>
@section('content')
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{url('public/dist/img/logo.png')}}" alt="ProfityoLogo">
  </div>
  <style>.container {
    margin-top: 20px;
}

.section-title {
    font-weight: bold;
    color: #4CAF50;
    margin-bottom: 15px;
}

.table th, .table td {
    vertical-align: middle;
}

.table .text-right {
    text-align: right;
}

.status-btn {
    padding: 4px 10px;
    border-radius: 15px;
    color: white;
}

.sent-status {
    background-color: #00C851;
}

.draft-status {
    background-color: #D980FA;
}

.paid-status {
    background-color: #33b5e5;
}

.statistics-card {
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 8px;
    background-color: #f8f9fa;
}

.statistics-card h6 {
    font-weight: bold;
    color: #4CAF50;
    margin-bottom: 15px;
}

.stats-list {
    list-style-type: none;
    padding: 0;
}

.stats-list li {
    display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 10px;
}

.stats-list li span {
    font-weight: bold;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="dadh_bord_heding">Dashboard</div>
        <!-- Small boxes (Stat box) -->
        <div class="row px-20">
          <div class="col-lg-4 col-md-6 col-mdash-box">
            <!-- small box -->
            <div class="small-box">
              <h2 class="welcome_text">Welcome {{ $masterUser->user_first_name }} {{ $masterUser->user_last_name }}</h2> 
              <!-- <p>Lorem Ipsum is Simply Dummy Text<br>of the Printing and Typesetting<br>Industry.</p> -->
              <img src="{{url('public/dist/img/welcome_img.png')}}" alt="welcome_img" class="welcome_img">
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-md-6 col-mdash-box">
            <!-- small box -->
            <div class="small-box bg-customers">
              <img src="{{url('public/dist/img/customer.png')}}" alt="customer_img" class="small_box_icon">
              <p class="total_text">Total Customers</p>
              <h3 class="customer_total">{{ $totalcustomer }}</h3>
            </div>
          </div>
          <!-- ./col --> 
          <div class="col-lg-2 col-md-6 col-mdash-box">
            <!-- small box -->
            <div class="small-box bg-vendors">
              <img src="{{url('public/dist/img/vendor.png')}}" alt="vendor" class="small_box_icon">
              <p class="total_text">Total Vendors</p>
              <h3 class="customer_total vendor_total">{{ $totalvendor }}</h3>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-md-6 col-mdash-box">
            <!-- small box -->
            <div class="small-box bg-invoices">
              <img src="{{url('public/dist/img/invoice.png')}}" alt="invoice" class="small_box_icon">
              <p class="total_text">Total Invoices</p>
              <h3 class="customer_total invoice_total">{{ $totalInvoices }}</h3>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-md-6 col-mdash-box">
            <!-- small box -->
            <div class="small-box bg-bills">
              <img src="{{url('public/dist/img/bill.png')}}" alt="bill" class="small_box_icon">
              <p class="total_text">Total Bills</p>
              <h3 class="customer_total bill_total">{{ $totalBills }}</h3>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><img src="{{url('public/dist/img/dot.png')}}" class="dot_img"> Account Balance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="col-md-12 table-responsive pad_table">
                  <table class="table table-hover text-nowrap dashboard_table">
                  <thead>
                      <tr>
                          <th>BANK</th>
                          <th>HOLDER NAME</th>
                          <th class="text-right">BALANCE</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($accounts as $payment)
                          <tr>
                          <td>{{ $payment->chart_acc_name ?? 'N/A' }}</td> 
                              <td>{{ $payment->id }}</td>
                              <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                          </tr>
                      @endforeach
                  </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /Account Balance -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><img src="{{url('public/dist/img/dot.png')}}" class="dot_img"> Latest Income</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="col-md-12 table-responsive pad_table">
                  <table class="table table-hover text-nowrap dashboard_table">
                    <thead>
                      <tr>
                        <th>DATE</th>
                        <th>CUSTOMER</th>
                        <th class="text-right">AMOUNT</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Jan 28, 2023</td>
                        <td>Lamar Mitchell</td>
                        <td class="text-right">$100.00</td>
                      </tr>
                      <tr>
                        <td>Jan 20, 2023</td>
                        <td>Nina Aguirre</td>
                        <td class="text-right">$100.00</td>
                      </tr>
                      <tr>
                        <td>Jan 14, 2023</td>
                        <td>Lee Winters</td>
                        <td class="text-right">$75.00</td>
                      </tr>
                      <tr>
                        <td>Jan 10, 2023</td>
                        <td>Whoopi Burks</td>
                        <td class="text-right">$250.00</td>
                      </tr>
                      <tr>
                        <td>Jan 08, 2023</td>
                        <td>Candace Pugh</td>
                        <td class="text-right">$4000.00</td>
                      </tr>
                      <tr>
                        <td>Jan 08, 2023</td>
                        <td>Candace Pugh</td>
                        <td class="text-right">$4000.00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /Latest Income -->
            <div class="card">
            <div class="card-header">
              <h3 class="card-title"><img src="{{url('public/dist/img/dot.png')}}" class="dot_img"> Latest Expense</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <div class="col-md-12 table-responsive pad_table"></div>
                <table class="table table-hover text-nowrap dashboard_table">
                  <thead>
                    <tr>
                      <th>DATE</th>
                      <th>CUSTOMER</th>
                      <th class="text-right">AMOUNT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Jan 28, 2023</td>
                      <td>Lamar Mitchell</td>
                      <td class="text-right">$100.00</td>
                    </tr>
                    <tr>
                      <td>Jan 20, 2023</td>
                      <td>Nina Aguirre</td>
                      <td class="text-right">$100.00</td>
                    </tr>
                    <tr>
                      <td>Jan 14, 2023</td>
                      <td>Lee Winters</td>
                      <td class="text-right">$75.00</td>
                    </tr>
                    <tr>
                      <td>Jan 10, 2023</td>
                      <td>Whoopi Burks</td>
                      <td class="text-right">$250.00</td>
                    </tr>
                    <tr>
                      <td>Jan 08, 2023</td>
                      <td>Candace Pugh</td>
                      <td class="text-right">$4000.00</td>
                    </tr>
                    <tr>
                      <td>Jan 08, 2023</td>
                      <td>Candace Pugh</td>
                      <td class="text-right">$4000.00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <!-- /Latest Income -->
          </div>
          <!-- /.Left col -->
          <div class="col-lg-6 connectedSortable">
          </div>
          <!-- right col -->
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><img src="{{url('public/dist/img/dot.png')}}" class="dot_img"> Recent Invoices</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="col-md-12 table-responsive pad_table">
                  <table class="table table-hover text-nowrap dashboard_table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->sale_inv_id  }}</td> <!-- Invoice number or use $invoice->id if it's the unique identifier -->
                        <td>{{ $invoice->customer->sale_cus_first_name ?? 'N/A' }}</td>  <!-- Assuming customer_name is a field in InvoicesDetails -->
                        <td>{{ $invoice->sale_inv_date->format('M d, Y') }}</td> <!-- Format the date as needed -->
                        <td>{{ $invoice->sale_inv_valid_date->format('M d, Y') }}</td>
                        <td>${{ number_format($invoice->sale_inv_final_amount, 2) }}</td>
                        <td>@php
          $nextStatus = '';
          $nextStatusColor = '';
          if ($invoice->sale_status == 'Draft') {
          $nextStatusColor = '';
          } elseif ($invoice->sale_status == 'Unsent') {
          $nextStatusColor = '';
          } elseif ($invoice->sale_status == 'Sent') {
          $nextStatusColor = '';
          } elseif ($invoice->sale_status == 'Partial') {
          $nextStatusColor = 'overdue_status';
          } elseif ($invoice->sale_status == 'Paid') {
          $nextStatusColor = 'Paid_status';
          }
        @endphp
            <span class="status_btn {{ $nextStatusColor }}">{{ $invoice->sale_status }}</span>
            </td>
                    </tr>
                    @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
          <div class="card">
            <div class="statistics-tabs">
              <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'weekly')">Invoices Weekly Statistics</button>
                <button class="tablinks" onclick="openTab(event, 'monthly')">Invoices Monthly Statistics</button>
              </div>
              <!-- Weekly Stats -->
              <div id="weekly" class="tabcontent">
                  <div class="col-md-12">
                    <ul class="stats-list">
                        <li>Total Invoice Generated <span>{{ $totalWeeklyInvoicesGenerated }}</span></li>
                        <li>Total Paid <span>${{ number_format($totalWeeklyPaid, 2) }}</span></li>
                        <li>Total Due <span>${{ number_format($totalWeeklyDue, 2) }}</span></li>
                    </ul>
                  </div>
              </div>
              <!-- Monthly Stats -->
              <div id="monthly" class="tabcontent" style="display:none;">
                <div class="col-md-12">
                  <ul class="stats-list">
                      <li>Total Invoice Generated <span>{{ $totalMonthlyInvoicesGenerated }}</span></li>
                      <li>Total Paid <span>${{ number_format($totalMonthlyPaid, 2) }}</span></li>
                      <li>Total Due <span>${{ number_format($totalMonthlyDue, 2) }}</span></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><img src="{{url('public/dist/img/dot.png')}}" class="dot_img"> Recent Bill</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="col-md-12 table-responsive pad_table">
                  <table class="table table-hover text-nowrap dashboard_table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>vendor</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($bill as $bills)
                    <tr>
                        <td>{{ $bills->sale_bill_id  }}</td> <!-- billoice number or use $bills->id if it's the unique identifier -->
                        <td>{{ $bills->vendor->purchases_vendor_name ?? 'N/A' }}</td>  <!-- Assuming customer_name is a field in billoicesDetails -->
                        <td>{{ $bills->sale_bill_date->format('M d, Y') }}</td> <!-- Format the date as needed -->
                        <td>{{ $bills->sale_bill_valid_date->format('M d, Y') }}</td>
                        <td>${{ number_format($bills->sale_bill_final_amount, 2) }}</td>
                        <td>@php
            $nextStatus = '';
            $nextStatusColor = '';
            if ($bills->sale_status == 'Draft') {
            $nextStatusColor = '';
            } elseif ($bills->sale_status == 'Unsent') {
            $nextStatusColor = '';
            } elseif ($bills->sale_status == 'Sent') {
            $nextStatusColor = '';
            } elseif ($bills->sale_status == 'Partial') {
            $nextStatusColor = 'overdue_status';
            } elseif ($bills->sale_status == 'Paid') {
            $nextStatusColor = 'Paid_status';
            }
            @endphp
            <span class="status_btn {{ $nextStatusColor }}">{{ $bills->sale_status }}</span>
            </td>
                    </tr>
                    @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-lg-4">
          </div>
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
<p>{{ session('showModal') }}</p>
@if (session()->has('showModal'))
 <!-- Bootstrap Modal -->
    <div class="modal fade show" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="display: block;">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Notice</h5>
              </div>
              <div class="modal-body">
                  <p>{{ session('showModal') }}</p>
              </div>
              <div class="modal-footer">
                  <a href="#" class="btn btn-primary">Purchase Plan</a>
              </div>
          </div>
      </div>
    </div>
@endif
<script>
  function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";  
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";  
    evt.currentTarget.className += " active";
}

// Optionally, you can set the default tab to be open
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.tablinks').click(); // Simulate a click on the first tab
});

</script>
 @endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profityo | Business Detail</title>
    @include('masteradmin.layouts.headerlink')
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
              <a href="#" data-toggle="modal" data-target="#deletecustomer"><button class="add_btn_br"><i class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
              <a href="#"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Send Statement</button></a>
              <a href="#"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Create Estimate</button></a>
              <a href="#"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Create Invoice</button></a>
              <a href="{{ route('business.salescustomers.edit',$SalesCustomers->sale_cus_id) }}"><button class="add_btn_br"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
              <a href="new-customer.html"><button class="add_btn">Create Another Customer</button></a>
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
                <p class="company_business_name">{{ $SalesCustomers->sale_cus_first_name }} {{ $SalesCustomers->sale_cus_last_name }}</p>
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
                <p class="company_business_name">{{ $SalesCustomers->sale_cus_first_name }}  {{ $SalesCustomers->sale_cus_last_name }}</p>
                <p class="company_details_text">{{ $SalesCustomers->sale_bill_address1 }}, {{ $SalesCustomers->sale_bill_country_id }}, {{ $SalesCustomers->sale_bill_city_name }} ,{{ $SalesCustomers->sale_bill_zipcode }}</p>
                <p class="company_details_text">{{ $SalesCustomers->sale_cus_phone }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">billping Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p class="company_business_name">{{ $SalesCustomers->sale_cus_first_name }}  {{ $SalesCustomers->sale_cus_last_name }}</p>
                <p class="company_details_text">{{ $SalesCustomers->sale_ship_address1 }}, {{ $SalesCustomers->sale_ship_country_id }}, {{ $SalesCustomers->sale_ship_city_name }} ,{{ $SalesCustomers->sale_ship_zipcode }}</p>
                <p class="company_details_text">{{ $SalesCustomers->sale_ship_phone }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card-header d-flex p-0 justify-content-center tab_panal">
          <ul class="nav nav-pills p-2 tab_box">
            <li class="nav-item"><a class="nav-link active" href="#customeroverview" data-toggle="tab">Overview</a></li>
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
                            <div class="invoice_icon_box"><img src="dist/img/invoice_report.svg" class="invoice_report_icon icon_cr1"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Paid last 12 Months</p>
                              <p class="in_contact_total text_color1">$0.00</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-invoice-box col-md-6">
                      <div class="invoice_count_box_br4">
                        <div class="invoice_count_box in-info">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="dist/img/invoice_report.svg" class="invoice_report_icon icon_cr4"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Total Unpaid</p>
                              <p class="in_contact_total text_color4">$88.50</p>
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
                    <div class="col-auto"><h3 class="card-title">Unpaid Invoices</h3></div>
                    <div class="col-auto"><button class="reminder_btn">Send Reminder</button></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body1">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example1" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Due</th>
                          <th>Amount Due</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn overdue_status">Overdue</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown align-items-center">
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#recordpaymentpopup">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Record Payment
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn overdue_status">Overdue</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown align-items-center">
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#recordpaymentpopup">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Record Payment
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="customerinvoice">
              <div class="card">
                <div class="col-lg-12 card-body3">
                  <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br1">
                        <div class="invoice_count_box in-primary">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="dist/img/invoice_report.svg" class="invoice_report_icon icon_cr1"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Total Unpaid</p>
                              <p class="in_contact_total text_color1">$88.50</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br4">
                        <div class="invoice_count_box in-info">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="dist/img/invoice_report.svg" class="invoice_report_icon icon_cr4"></div>
                            <div class="mar_15">
                              <p class="in_contact_title">Overdue</p>
                              <p class="in_contact_total text_color4">$88.50</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-invoice-box">
                      <div class="invoice_count_box_br2">
                        <div class="invoice_count_box in-secondary">
                          <div class="in_contact">
                            <div class="invoice_icon_box"><img src="dist/img/invoice_report.svg" class="invoice_report_icon icon_cr2"></div>
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
                            <div class="invoice_icon_box"><img src="dist/img/invoice_report.svg" class="invoice_report_icon icon_cr3"></div>
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
                    <div class="col-md-3 px-10 d-flex">
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
                    <div class="col-md-3 px-10">
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
              </div>
              <div class="card">
                <div class="card-header">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto"><h3 class="card-title">Invoices</h3></div>
                    <div class="col-auto"><a href="new-invoice.html"><button class="reminder_btn">Create invoice</button></a></div>
                  </div>
                </div>
                <!-- /.card-header -->
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
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn Paid_status">Paid</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block invoice_underline">View</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block invoice_underline">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn Paid_status">Paid</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block invoice_underline">View</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn overdue_status">Overdue</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block invoice_underline" data-toggle="modal" data-target="#recordpaymentpopup">Record Payment</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>20 Days Ago</td>
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block invoice_underline">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-invoice.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-invoice.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteinvoice">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="customeractivity">
              <div class="card">
                <div class="card-header">
                  <div class="row justify-content-between align-items-center">
                    <div class="col-auto"><h3 class="card-title">Activity</h3></div>
                    <div class="col-auto"><a href="new-invoice.html"><button class="reminder_btn">Create invoice</button></a></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search by Description">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 d-flex">
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
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body2">
                  <div class="row">
                    <div class="col-md-12" id="accordion">
                      <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
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
                      <div id="collapseOne" class="collapse" data-parent="#accordion">
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
                            </div>
                            <div class="col-auto">
                              <a href="#"><button class="add_btn_br">View related events</button></a>
                              <a href="view-estimate.html"><button class="add_btn">view Estimate</button></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" id="accordion">
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
                            </div>
                            <div class="col-auto">
                              <a href="#"><button class="add_btn_br">View related events</button></a>
                              <a href="view-estimate.html"><button class="add_btn">view Estimate</button></a>
                            </div>
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
  <div class="modal fade" id="editcustor_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                      <input type="Number" class="form-control" id="customer_phonenumber" placeholder="Enter Phone Number">
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
                      <input type="text" class="form-control" id="company-businessaddress1" placeholder="Enter a Location">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress2">Address Line 2</label>
                      <input type="text" class="form-control" id="company-businessaddress2" placeholder="Enter a Location">
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
                      <input type="text" class="form-control" id="company-businesszipcode" placeholder="Enter a Zip Code">
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
                      <input type="Number" class="form-control" id="customer_phonenumber" placeholder="Enter Phone Number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress1">Address Line 1</label>
                      <input type="text" class="form-control" id="company-businessaddress1" placeholder="Enter a Location">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="company-businessaddress2">Address Line 2</label>
                      <input type="text" class="form-control" id="company-businessaddress2" placeholder="Enter a Location">
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
                      <input type="text" class="form-control" id="company-businesszipcode" placeholder="Enter a Zip Code">
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
                      <textarea id="customerinternalnotes" class="form-control" rows="3" placeholder="Notes entered here will not be visible to your customer"></textarea>
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
  <div class="modal fade" id="deletecustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Customer</b></p>
          <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->


    @include('masteradmin.layouts.footerlink')

</body>

</html>
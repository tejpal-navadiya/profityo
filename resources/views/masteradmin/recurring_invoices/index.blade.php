@extends('masteradmin.layouts.app')
<title>Profityo | View All Recurring Invoices</title>
<?php //dd($access); ?>
@if(isset($access['view_recurring_invoices']) && $access['view_recurring_invoices'] == 1) 
@section('content')

<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Recurring Invoices</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Recurring Invoices</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
            @if(isset($access['add_recurring_invoices']) && $access['add_recurring_invoices'] == 1) 
              <a href="{{ route('business.recurring_invoices.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Create A Recurring Invoice</button></a>
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
        <div class="col-lg-12 px-20 fillter_box">
          <div class="row align-items-center justify-content-between">
            <div class="col-auto">
              <p class="m-0 filter-text"><i class="fas fa-solid fa-filter"></i>Filters</p>
            </div><!-- /.col -->
            <div class="col-auto">
              <p class="m-0 float-sm-right filter-text">Clear Filters<i class="fas fa-regular fa-circle-xmark"></i></p>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-12 px-10">
              <select id="sale_cus_id" class="form-control select2" style="width: 100%;" name="sale_cus_id">
                <option value="" default>All customers</option>
                @foreach($salecustomer as $value)
                  <option value="{{ $value->sale_cus_id }}">{{ $value->sale_cus_business_name }} </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div id="filter_data">
          <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
            <ul class="nav nav-pills p-2 tab_box">
              <li class="nav-item"><a class="nav-link active" href="#activerecurringinvoice" data-toggle="tab">Active <span class="badge badge-toes">{{ count($activereInvoices) }}</span></a></li>
              <li class="nav-item"><a class="nav-link" href="#draftrecurringinvoice" data-toggle="tab">Draft <span class="badge badge-toes">{{ count($draftreInvoices) }}</span></a></li>
              <li class="nav-item"><a class="nav-link" href="#allrecurringinvoice" data-toggle="tab">All Recurring Invoices</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="tab-content">
                <div class="tab-pane active" id="activerecurringinvoice">
                  <div class="col-md-12 pad_table">
                    <table id="example1" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Schedule</th>
                          <th>Previous Invoice</th>
                          <th>Next Invoice</th>
                          <th>Status</th>
                          <th>Invoice Amount</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($activereInvoices) > 0)
                        @foreach ($activereInvoices as $value)
                        <tr id="invoices-row-active-{{ $value->sale_re_inv_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>Repeat Monthly on The 1st<br>First invoice: 2024-05-01, Ends: 2024-05-01</td>
                          <td>-</td>
                          <td>{{ \Carbon\Carbon::parse($value->sale_re_inv_date)->format('M d, Y') }}</td>
                          <td><span class="status_btn active_status">{{ $value->sale_status }}</span></td>
                          <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_re_inv_final_amount }}</td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown">
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                @if(isset($access['view_recurring_invoices']) && $access['view_recurring_invoices'] == 1) 
                                  <a href="{{ route('business.recurring_invoices.view', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_recurring_invoices']) && $access['update_recurring_invoices'] == 1) 
                                  <a href="{{ route('business.recurring_invoices.edit', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.recurring_invoices.duplicate', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        @endforeach
                      @else
                       
                      @endif
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="draftrecurringinvoice">
                  <div class="col-md-12 pad_table">
                    <table id="example5" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Schedule</th>
                          <th>Previous Invoice</th>
                          <th>Next Invoice</th>
                          <th>Status</th>
                          <th>Invoice Amount</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($draftreInvoices) > 0)
                        @foreach ($draftreInvoices as $value)
                        <tr id="invoices-row-draft-{{ $value->sale_re_inv_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>Repeat Monthly on The 1st<br>First invoice: 2024-05-01, Ends: 2024-05-01</td>
                          <td>-</td>
                          <td>{{ \Carbon\Carbon::parse($value->sale_re_inv_date)->format('M d, Y') }}</td>
                          <td><span class="status_btn active_status">{{ $value->sale_status }}</span></td>
                          <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_re_inv_final_amount }}</td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown">
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                @if(isset($access['view_recurring_invoices']) && $access['view_recurring_invoices'] == 1) 
                                  <a href="{{ route('business.recurring_invoices.view', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_recurring_invoices']) && $access['update_recurring_invoices'] == 1) 
                                  <a href="{{ route('business.recurring_invoices.edit', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.recurring_invoices.duplicate', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
                        @endforeach
                      @else
                       
                      @endif
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="allrecurringinvoice">
                  <div class="col-md-12 pad_table">
                    <table id="example4" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Schedule</th>
                          <th>Previous Invoice</th>
                          <th>Next Invoice</th>
                          <th>Status</th>
                          <th>Invoice Amount</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($allreInvoices) > 0)
                        @foreach ($allreInvoices as $value)
                        <tr id="invoices-row-all-{{ $value->sale_re_inv_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>Repeat Monthly on The 1st<br>First invoice: 2024-05-01, Ends: 2024-05-01</td>
                          <td>-</td>
                          <td>{{ \Carbon\Carbon::parse($value->sale_re_inv_date)->format('M d, Y') }}</td>
                          <td><span class="status_btn active_status">{{ $value->sale_status }}</span></td>
                          <td>{{ $currencys->firstWhere('id', $value->sale_currency_id)->currency_symbol ?? '' }}{{ $value->sale_re_inv_final_amount }}</td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown">
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                @if(isset($access['view_recurring_invoices']) && $access['view_recurring_invoices'] == 1) 
                                  <a href="{{ route('business.recurring_invoices.view', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_recurring_invoices']) && $access['update_recurring_invoices'] == 1) 
                                  <a href="{{ route('business.recurring_invoices.edit', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.recurring_invoices.duplicate', $value->sale_re_inv_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>
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
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var defaultSaleCusId = "";  
  
       
        $('#sale_cus_id').val(defaultSaleCusId);
        $('.filter-text').on('click', function() {
                clearFilters();
            });
   
    // Function to fetch filtered data
    function fetchFilteredData() {
        var formData = {
            sale_cus_id: $('#sale_cus_id').val(),
            _token: '{{ csrf_token() }}'
        };
       
        // console.log(formData);
        $.ajax({
            url: '{{ route('business.recurring_invoices.index') }}',
            type: 'GET',
            data: formData,
            success: function(response) {
              // console.log(response);
                $('#filter_data').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('An error occurred while fetching data.');
            }
        });
    }
    // Attach change event handlers to filter inputs
    $('#sale_cus_id').on('change keyup', function(e) {
      e.preventDefault(); 
      fetchFilteredData();
    });
    function clearFilters() {
          $('#sale_cus_id').val('').trigger('change');
            fetchFilteredData(); // Example: Fetch data based on the cleared filters
            }
});
</script>
@endsection
@endif

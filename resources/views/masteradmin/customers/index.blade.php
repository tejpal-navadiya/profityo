@extends('masteradmin.layouts.app')
<title>Profityo | Sales Customers</title>
@if(isset($access['view_customers']) && $access['view_customers']) 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Customers</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Customers</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#"><button class="add_btn_br"><i class="fas fa-download add_plus_icon"></i>Import From CSV</button></a>
              @if(isset($access['add_customers']) && $access['add_customers']) 
              <a href="{{ route('business.salescustomers.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Add A Customer</button></a>
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
        <!-- Main row -->
        @if(Session::has('sales-customers-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('sales-customers-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('sales-customers-add');
            @endphp
          @endif
          @if(Session::has('sales-customers-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('sales-customers-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('sales-customers-delete');
            @endphp
          @endif
        <div class="card px-20">
          <div class="card-body1">
            <div class="col-md-12 pad_table">
              <table id="example1" class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <!-- <th>Balance</th>  -->
                    <th>Balance | Overdue</th>
                    <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @if (count($SalesCustomers) > 0)
                @foreach ($SalesCustomers as $value)
                  <tr>
                  <td>{{ $value->sale_cus_business_name }}</td>
                  <td>{{ $value->sale_cus_email }}</td>
                  <td>{{ $value->sale_cus_phone }}</td>
                  <!-- <td>{{ $value->tax_name }}</td> -->
                    <td><span class="overdue_text">$75.00 Overdue</span></td>
                    <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
                        <li class="nav-item dropdown align-items-center">
                          <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                            <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('business.customerdetails.show', $value->sale_cus_id) }}" class="dropdown-item">
                              <i class="fas fa-regular fa-eye mr-2"></i> View
                            </a>
                            @if(isset($access['update_customers']) && $access['update_customers']) 
                            <a href="{{ route('business.salescustomers.edit',$value->sale_cus_id) }}" class="dropdown-item">
                              <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                            </a>
                            @endif
                            <a href="{{ route('business.invoices.create') }}" class="dropdown-item">
                              <i class="fas fa-solid fa-file-invoice mr-2"></i> Create Invoice
                            </a>
                            <a href="#" class="dropdown-item">
                              <i class="fas fa-regular fa-paper-plane mr-2"></i> Send Statement
                            </a>
                            @if(isset($access['delete_customers']) && $access['delete_customers']) 
                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deletecustomer-{{ $value->sale_cus_id }}">
                              <i class="fas fa-solid fa-trash mr-2"></i> Delete
                            </a>
                            @endif
                          </div>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <div class="modal fade" id="deletecustomer-{{ $value->sale_cus_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.salescustomers.destroy', ['SalesCustomers' => $value->sale_cus_id]) }}" id="delete-form-{{ $value->sale_cus_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete Customer</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                         
                            <input type="hidden" name="sale_cus_id" id="customer-id">
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="delete_btn px-15">Delete</button>
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

                  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here --> 
  </aside>
  <!-- /.control-sidebar -->
  <!-- <div class="modal fade" id="deletesalestaxes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Sales Tax</b></p>
          <p class="company_details_text px-10">Are You Sure You Want to Delete This Sales Tax?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- ./wrapper -->


@endsection
@endif
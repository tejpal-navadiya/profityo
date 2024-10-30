@extends('masteradmin.layouts.app')
<title>Profityo | Transactions</title>
@if(isset($access['view_vendors']) && $access['view_vendors'])
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Transactions</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Transactions</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <button class="more_btn dropdown px-10">
                <a class="add_btn_br" data-toggle="dropdown" href="#"><span class="dropdown-toggle">More</span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="#" class="dropdown-item">Add Journal Transaction</a>
                  <a href="#" class="dropdown-item">Connect Your Bank</a>
                  <a href="#" class="dropdown-item">Upload A Bank Statement</a>
                </div>
              </button>
              <button class="more_btn dropdown px-10">
                <a class="add_btn_br" data-toggle="dropdown" href="#"><span class="dropdown-toggle">Receipts</span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="#" class="dropdown-item">Upload Receipt</a>
                  <a href="#" class="dropdown-item">Scan Receipt</a>
                </div>
              </button>
              <a href="add-income.html"><button class="add_btn mar_10"><i class="fas fa-plus add_plus_icon"></i>Add Income</button></a>
              <a href="add-expense.html"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Add Expense</button></a>
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
          <div class="row align-items-center justify-content-between">
          <div class="col-md-3">
            <form action="{{ route('transactions.filter') }}" method="GET">
                <select name="payment_account" class="form-control select2" style="width: 100%;" onchange="this.form.submit()">
                <option value="">All Account (Total: ${{ number_format($totalPaymentAmount, 2) }})</option>
                @foreach($accounts as $account)
                <option value="{{ $account->chart_acc_id }}" {{ request()->payment_account == $account->chart_acc_id ? 'selected' : '' }}>
                {{ $account->chart_acc_name }}(Total: ${{ number_format($totalPaymentAmount, 2) }})
                    </option>
                @endforeach
                </select>
            </form>
            </div>
            <div class="col-auto d-flex align-items-center">
              <a href="#" data-toggle="modal" data-target="#transactionsfilter"><span class="m-0 filter-text"><i class="fas fa-solid fa-filter"></i>Filters</span></a>
              <button class="more_btn dropdown mar_15">
                <a class="filter-text" data-toggle="dropdown" href="#"><i class="fas fa-solid fa-sort mr-1"></i>Sort</a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="#" class="dropdown-item">Newest To Oldest</a>
                  <a href="#" class="dropdown-item">Oldest To Newest</a>
                </div>
              </button>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="card px-20">
          <div class="card-header">
              <!-- Check all button -->
              <span class="checkbox-toggle mb-0"><i class="far fa-square mr-2"></i>Select All</span>
              <button type="button" class="selectall_icon_btn">
                <i class="far fa-trash-alt"></i>
              </button>
              <button type="button" class="selectall_icon_btn">
                <i class="fas fa-pen-to-square"></i>
              </button>
              <button type="button" class="selectall_icon_btn">
                <img src="dist/img/merge.svg">
              </button>
              <button type="button" class="selectall_icon_btn">
                <i class="fas fa-check"></i>
              </button>
              <!-- /.float-right -->
          </div>
          <div class="card-body1">
            <div class="col-md-12 table-responsive mailbox-messages pad_table">
              <table id="example1" class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th class="sorting_disabled" data-orderable="false">
                      <div class="icheck-primary">
                        <input type="checkbox" value="" id="check1">
                        <label for="check1"></label>
                      </div>
                    </th>
                    <th style="width: 200px;">Date</th>
                    <th style="width: 300px;">Description</th>
                    <th>Account</th>
                    <th>Category</th>
                    <th style="width: 150px;">Amount</th>
                    <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($RecordPayment as $payment)
                <tr>
                  <td>
                    <div class="icheck-primary">
                    <input type="checkbox" value="{{ $payment->record_payment_id  }}" id="check{{ $payment->record_payment_id  }}">
                    <label for="check{{ $payment->record_payment_id  }}"></label>
                    </div>
                  </td>
                  <td>
    <div class="input-group date" id="transactionsdate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" 
               placeholder="mm/dd/yyyy" 
               value="{{ \Carbon\Carbon::parse($payment->payment_date)->format('m/d/Y') }}" 
               data-target="#transactionsdate">
        <div class="input-group-append" data-target="#transactionsdate" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
        </div>
    </div>
</td>

<td><input type="text" class="form-control" placeholder="Write a Description" value="{{ $payment->description }}"></td>
<td>
  <select class="form-control select2" style="width: 100%;" name="payment_account">
    <option>Select an Account</option>
    @foreach($accounts as $account)
        <option value="{{ $account->chart_acc_id }}" {{ $payment->payment_account == $account->chart_acc_id ? 'selected' : '' }}>
            {{ $account->chart_acc_name }}
        </option>
    @endforeach
  </select>
</td>


                  <td>
                    <select class="form-control select2" style="width: 100%;">
                      <option>Uncategorized Income</option>
                    </select>
                  </td>
                  <td><input type="number" class="form-control" placeholder="$0.00" value="{{ $payment->payment_amount }}"></td>                  <td>
                    <ul class="navbar-nav ml-auto float-sm-right">
                      <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link" href="#">
                          <span class="selectall_icon_btn"><i class="fas fa-check"></i></span>
                        </a>
                        <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                          <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a href="{{ route('business.transactions.edit') }}" class="dropdown-item">
                            <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit More Details
                          </a>
                          <a href="#" class="dropdown-item">
                            <i class="fas fa-solid fa-upload mr-2"></i> Upload Receipt
                          </a>
                          <a href="#" class="dropdown-item">
                            <i class="fas fa-regular fa-copy mr-2"></i> Copy
                          </a>
                          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deletetransaction">
                            <i class="fas fa-solid fa-trash mr-2"></i> Delete
                          </a>
                        </div>
                      </li>
                    </ul>
                  </td>
                </tr>
                <div class="modal fade" id="deleteTransaction{{ $payment->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this payment?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                @endforeach
                </tbody>
              </table>
              <!-- /.table -->
            </div>
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
<div class="modal fade" id="deletetransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Transaction</b></p>
          <p class="company_details_text px-10">Are You Sure You Want To Delete This Transaction? This Action Can't Be Undone.</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="transactionsfilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Filters</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control select2" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;">
                    <option>Uncategorized</option>
                    <option>Transfers</option>
                    <option>Payments</option>
                    <option>Refunds</option>
                    <option>Consulting Income</option>
                    <option>Sales</option>
                    <option>Uncategorized Income</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control form-select" data-placeholder="Select a Status" style="width: 100%;">
                    <option>Reviewed</option>
                    <option>Not Reviewed</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control select2" multiple="multiple" data-placeholder="Select a Type" style="width: 100%;">
                    <option>Deposit</option>
                    <option>Withdrawal</option>
                    <option>Journal</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Receipt</label>
                  <select class="form-control form-select" data-placeholder="Choose Option..." style="width: 100%;">
                    <option>From Scan</option>
                    <option>Any Receipt Attached</option>
                    <option>No Receipts Attached</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Transaction Date Range</label>
                  <select class="form-control form-select" data-placeholder="Choose a Date Range" style="width: 100%;">
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label>Custom Range From & To</label>
                <div class="form-group d-flex">
                  <div class="input-group date" id="fromdate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder="From" data-target="#fromdate">
                    <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                  <div class="input-group date" id="todate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder="To" data-target="#todate">
                    <div class="input-group-append" data-target="#todate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
                <div class="form-group">
                  <label>last Modified Date</label>
                  <select class="form-control form-select" data-placeholder="Choose a Date Range" style="width: 100%;">
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label>last Modified Date From & To</label>
                <div class="form-group d-flex">
                  <div class="input-group date" id="fromdate1" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder="From" data-target="#fromdate1">
                    <div class="input-group-append" data-target="#fromdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                  <div class="input-group date" id="todate1" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder="To" data-target="#todate1">
                    <div class="input-group-append" data-target="#todate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Wave Auto-Updates</label>
                  <select class="form-control select2" multiple="multiple" data-placeholder="Choose an Option" style="width: 100%;">
                    <option>Categorizations</option>
                    <option>Merges</option>
                    <option>Scanned Receipts</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Apply</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#add_bank_account').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var vendorId = button.data('vendor-id'); // Extract info from data-* attributes
            
            var modal = $(this);
            modal.find('#purchases_vendor_id').val(vendorId); // Set the vendor ID in the hidden input
        });
    });
</script>

@endsection
@endif
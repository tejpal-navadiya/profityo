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
        <a href="#" data-toggle="modal" data-target="#transactionsAddIncome"><button class="add_btn mar_10"><i
            class="fas fa-plus add_plus_icon"></i>Add Income</button></a>
        <a href="#" data-toggle="modal" data-target="#transactionsAddexpense"><button class="add_btn"><i
            class="fas fa-plus add_plus_icon"></i>Add Expense</button></a>
        </ol>
      </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
    <div class="container-fluid">
    @if(Session::has('Transaction-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('Transaction-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('Transaction-add');
            @endphp
            @endif
            @if(Session::has('Transaction-add-expense'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('Transaction-add-expense') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('Transaction-add-expense');
            @endphp
          @endif
          @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

      <!-- Small boxes (Stat box) -->
      <div class="col-lg-12 fillter_box">
      <div class="row align-items-center justify-content-between">
        <div class="col-md-3">
        <form action="{{ route('transactions.filter') }}" method="GET">
          <select name="payment_account" class="form-control select2" style="width: 100%;"
          onchange="this.form.submit()">
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
        <a href="#" data-toggle="modal" data-target="#transactionsfilter"><span class="m-0 filter-text"><i
            class="fas fa-solid fa-filter"></i>Filters</span></a>
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
        <img src="https://profityo.app/public/dist/img/merge.svg">
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
          <tr data-payment-id="{{ $payment->record_payment_id }}">

        <td>
        <div class="icheck-primary">
          <input type="checkbox" value="{{ $payment->record_payment_id  }}"
          id="check{{ $payment->record_payment_id  }}">
          <label for="check{{ $payment->record_payment_id  }}"></label>
        </div>
        </td>
        <td>
        <div class="input-group date" id="transactionsdate" data-target-input="nearest">
          <input type="text" name="payment_date" class="form-control datetimepicker-input" placeholder="mm/dd/yyyy"
          value="{{ \Carbon\Carbon::parse($payment->payment_date)->format('m/d/Y') }}"
          data-target="#transactionsdate">
          <div class="input-group-append" data-target="#transactionsdate" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
          </div>
        </div>
        </td>

        <td><input type="text" class="form-control" name="description" placeholder="Write a Description"
          value="{{ $payment->description }}"></td>
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
        <select id="category" name="category" class="form-control select2" style="width: 100%;">
    @foreach ($tabs as $tab)
        <optgroup label="{{ $tab->chart_menu_title }}">
            <option value="">Uncategorized Income</option>
            @foreach ($subMenus[$tab->chart_menu_id] ?? [] as $submenu)
                <option value="{{ $submenu->chart_menu_id }}" 
                    {{ (string)$payment->category === (string)$submenu->chart_menu_id ? 'selected' : '' }}>
                    {{ $submenu->chart_menu_title }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
</select>

        </td>
        <td><input type="number" name="payment_amount" class="form-control" placeholder="$0.00"
          value="{{ $payment->payment_amount }}"></td>
        <td>
        <ul class="navbar-nav ml-auto float-sm-right">
          <li class="nav-item dropdown d-flex align-items-center">
          <a class="nav-link" href="#">
          <span class="selectall_icon_btn"><i class="fas fa-check"></i></span>
          </a>
          <a class="nav-link user_nav" data-toggle="dropdown" href="#">
          <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('business.transactions.edit',$payment->record_payment_id ) }}" class="dropdown-item">
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
  <div class="modal fade" id="deletetransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body pad-1 text-center">
      <i class="fas fa-solid fa-trash delete_icon"></i>
      <p class="company_business_name px-10"><b>Delete Transaction</b></p>
      <p class="company_details_text px-10">Are You Sure You Want To Delete This Transaction? This Action Can't Be
        Undone.</p>
      <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
      <button type="submit" class="delete_btn px-15">Delete</button>
      </div>
    </div>
    </div>
  </div>
  <div class="modal fade" id="transactionsfilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
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
          <select class="form-control select2" multiple="multiple" data-placeholder="Select a Category"
            style="width: 100%;">
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
          <select class="form-control select2" multiple="multiple" data-placeholder="Select a Type"
            style="width: 100%;">
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
            <input type="text" class="form-control datetimepicker-input" placeholder="From"
            data-target="#fromdate">
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
            <input type="text" class="form-control datetimepicker-input" placeholder="From"
            data-target="#fromdate1">
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
          <select class="form-control select2" multiple="multiple" data-placeholder="Choose an Option"
            style="width: 100%;">
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

  <div class="modal fade" id="transactionsAddIncome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Add Income</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <!-- @if($errors->any())
      <div class="alert alert-danger">
      <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
      </ul>
      </div>
    @endif -->


      <form method="POST" action="{{ route('transactions.storeIncome') }}">
        @csrf
        <div class="row pxy-15 px-10">
        <div class="col-md-6">
          <div class="form-group">
            <label>Date<span class="text-danger">*</span></label>
            <div class="input-group">
              <x-flatpickr 
                id="from-datepicker" 
                name="payment_date" 
                placeholder="Select a date" 
                class="form-control"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <i class="fa fa-calendar-alt"></i>
                </div>
              </div>
            </div>
            @error('payment_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Description</label>
          <textarea id="description" class="form-control" name="description" rows="1"
            placeholder="Write a description"></textarea>
          </div>
        </div>
        <!-- <div class="col-md-6">
          <div class="form-group">
            <label>Account</label>
            <select class="form-control select2" multiple="multiple" data-placeholder="Select a Type" style="width: 100%;">
            <option>Deposit</option>
            <option>Withdrawal</option>
            <option>Journal</option>
            </select>
          </div>
          </div> -->
        <div class="col-md-6">
          <div class="form-group">
          <label>Account <span class="text-danger">*</span></label>
          <select class="form-control form-select" name="payment_account" placeholder="Enter your text here">
            <option>Select a Payment Account...</option>
            @foreach($accounts as $account)
        <option value="{{ $account->chart_acc_id }}">{{ $account->chart_acc_name }}</option> <!-- Store ID -->
      @endforeach
          </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Type</label>
          <select class="form-control form-select" name='type' data-placeholder="Choose Option..."
            style="width: 100%;">
            <option value="1">Deposit</option>
            <option value="2">Withdrawal</option>
          </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Amount</label>
          <input type="text" id="payment_amount" class="form-control" name="payment_amount" rows="1"
            placeholder="Write a amount" />

          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Category</label>
          <select id="account" data-id="" name="category" class="form-control">
            @foreach ($tabs as $tab)
        <optgroup label="{{ $tab->chart_menu_title }}">
        @foreach ($subMenus[$tab->chart_menu_id] ?? [] as $submenu)
      <option value="{{ $submenu->chart_menu_id }}">
        {{ $submenu->chart_menu_title }}
      </option>
    @endforeach
        </optgroup>
      @endforeach
          </select>
          </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
          <label for="editDescription">Notes</label>
          <textarea id="editDescription" class="form-control" name="notes" rows="3"
          placeholder="">{{ $account->note }}</textarea>

          <!-- <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $account->sale_acc_desc }}</textarea> -->
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
          <label for="editDescription">Receipt</label>
          <textarea id="editDescription" class="form-control" name="recipt" rows="3"
          placeholder="">{{ $account->recipt }}</textarea>

          <!-- <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $account->sale_acc_desc }}</textarea> -->
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

  <div class="modal fade" id="transactionsAddexpense" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Add Expense</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{ route('transactions.storeExpens') }}">
        @csrf
        <div class="row pxy-15 px-10">
        <div class="col-md-6">
          <div class="form-group">
            <label>Date<span class="text-danger">*</span></label>
            <div class="input-group">
              <x-flatpickr 
                id="from-datepicker" 
                name="payment_date" 
                placeholder="Select a date" 
                class="form-control"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <i class="fa fa-calendar-alt"></i>
                </div>
              </div>
            </div>
            @error('payment_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Description</label>
          <textarea id="description" class="form-control" name="description" rows="1"
            placeholder="Write a description">{{ $account->sale_acc_desc }}</textarea>

          </div>
        </div>
        <!-- <div class="col-md-6">
          <div class="form-group">
            <label>Account</label>
            <select class="form-control select2" multiple="multiple" data-placeholder="Select a Type" style="width: 100%;">
            <option>Deposit</option>
            <option>Withdrawal</option>
            <option>Journal</option>
            </select>
          </div>
          </div> -->
        <div class="col-md-6">
          <div class="form-group">
          <label>Account <span class="text-danger">*</span></label>
          <select class="form-control form-select" name="payment_account" placeholder="Enter your text here">
            <option>Select a Payment Account...</option>
            @foreach($accounts as $account)
        <option value="{{ $account->chart_acc_id }}">{{ $account->chart_acc_name }}</option> <!-- Store ID -->
      @endforeach
          </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Type</label>
          <select class="form-control form-select" name='type' data-placeholder="Choose Option..."
            style="width: 100%;">
            <option value="1">Deposit</option>
            <option value="2">Withdrawal</option>
          </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Amount</label>
          <input type="text" id="payment_amount" class="form-control" name="payment_amount" rows="1"
            placeholder="Write a amount" />

          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <label>Category</label>
          <select id="account" data-id="" name="category" class="form-control">
            @foreach ($tabs as $tab)
        <optgroup label="{{ $tab->chart_menu_title }}">
        @foreach ($subMenus[$tab->chart_menu_id] ?? [] as $submenu)
      <option value="{{ $submenu->chart_menu_id }}">
        {{ $submenu->chart_menu_title }}
      </option>
    @endforeach
        </optgroup>
      @endforeach
          </select>
          </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
          <label for="editDescription">Notes</label>
          <textarea id="editDescription" class="form-control" name="notes" rows="3"
          placeholder="">{{ $account->note }}</textarea>

          <!-- <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $account->sale_acc_desc }}</textarea> -->
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
          <label for="editDescription">Receipt</label>
          <textarea id="editDescription" class="form-control" name="recipt" rows="3"
          placeholder="">{{ $account->recipt }}</textarea>

          <!-- <textarea id="editDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash">{{ $account->sale_acc_desc }}</textarea> -->
        </div>
        </div>


      </div>
      <div class="modal-footer">
      <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
      <button type="submit" class="add_btn">save</button>
      </div>
      </form>
    </div>
    </div>
  </div>
  </div>
  <!-- ./wrapper -->
  
  @endsection
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
    $(document).ready(function () {
    $('#add_bank_account').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var vendorId = button.data('vendor-id'); // Extract info from data-* attributes

      var modal = $(this);
      modal.find('#purchases_vendor_id').val(vendorId); // Set the vendor ID in the hidden input
    });
    });
  </script>
  <script>
document.addEventListener('DOMContentLoaded', function() {

        var fromdatepicker = flatpickr("#from-datepicker", {
            locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "d/m/Y",
            allowInput: true,
            onChange: calculateDays
        });

        var todatepicker = flatpickr("#to-datepicker", {
            locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "d/m/Y",
            allowInput: true,
            onChange: calculateDays
        });

        document.getElementById('from-calendar-icon').addEventListener('click', function() {
            fromdatepicker.open(); 
        });

        document.getElementById('to-calendar-icon').addEventListener('click', function() {
            todatepicker.open(); 
        });

        function calculateDays() {
        var sdate = fromdatepicker.input.value;  
        var edate = todatepicker.input.value;  
        var totalDays = 0;   

        if(sdate && edate) {
            var startDate = new Date(sdate);
            var endDate = new Date(edate);

            var timeDifference = endDate.getTime() - startDate.getTime();

            var totalDays = timeDifference / (1000 * 3600 * 24); 

            if (totalDays < 0) {
            document.getElementById("total-days").innerText = "Invalid date range"; 
            document.getElementById("hidden-total-days").value = ''; 

          } else {
              document.getElementById("total-days").innerText = totalDays; 
              document.getElementById("hidden-total-days").value = totalDays; 
          }

        }

      }
});

    </script>
   <!-- <script>
    $(document).ready(function() {
        // Listen for changes in the inputs and send AJAX to update the record
        $('input[type="text"], input[type="number"], select').on('change', function() {
            var paymentId = $(this).closest('tr').data('payment-id');
            var paymentAccount = $(this).closest('tr').find('select[name="payment_account"]').val();
            var paymentAmount = $(this).closest('tr').find('input[name="payment_amount"]').val();
            var paymentDate = $(this).closest('tr').find('input[name="payment_date"]').val();
            var description = $(this).closest('tr').find('input[name="description"]').val();
            var category = $(this).closest('tr').find('select[name="category"]').val();

            // Send AJAX request to update the payment
            $.ajax({
                url: '{{ route('transactions.updateTransection', ['paymentId' => '__paymentId__']) }}'.replace('__paymentId__', paymentId),
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    payment_account: paymentAccount,
                    payment_amount: paymentAmount,
                    payment_date: paymentDate,
                    description: description,
                    category: category
                },
                success: function(response) {
                    // Handle the success response here
                    console.log('Transaction updated successfully');
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.log('Error: ' + error);
                }
            });
        });
    });
</script> -->
<!-- <script src="path/to/jquery.min.js"></script>
<script src="path/to/jquery-jvectormap.min.js"></script>
<link rel="stylesheet" href="path/to/jquery-jvectormap.css"> -->

<script>
$(document).ready(function() {
    $('input, select').on('change', function() {
        var paymentId = $(this).closest('tr').data('payment-id');
        var paymentAccount = $(this).closest('tr').find('select[name="payment_account"]').val();
        var paymentAmount = $(this).closest('tr').find('input[name="payment_amount"]').val();
        var paymentDate = $(this).closest('tr').find('input[name="payment_date"]').val();
        var description = $(this).closest('tr').find('input[name="description"]').val();
        var category = $(this).closest('tr').find('select[name="category"]').val();

        // // Debugging: Log values to the console
        // console.log({
        //     paymentId,
        //     paymentAccount,
        //     paymentAmount,
        //     paymentDate,
        //     description,
        //     category,
        // });

        // Send AJAX request to update the payment
        $.ajax({
            url: '{{ route('transactions.updateTransection', ['paymentId' => '__paymentId__']) }}'.replace('__paymentId__', paymentId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                payment_account: paymentAccount,
                payment_amount: paymentAmount,
                payment_date: paymentDate,
                description: description,
                category: category,
            },
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            },
        });
    });
});
</script>
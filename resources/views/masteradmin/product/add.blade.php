@extends('masteradmin.layouts.app')
<title>Profityo | New Product Or Service</title>
@if((isset($access['add_product_services_sales']) && $access['add_product_services_sales'] == 1) )
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
        <div class="col-auto">
          <h1 class="m-0">New Product Or Service</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">New Product Or Service</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
            <a href="{{route('business.salesproduct.index')}}" class="add_btn_br">Cancel</a>
            <button type="submit" form="pro-Form" class="add_btn">Save</button>
            </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content px-10">
    <div class="container-fluid">
      <!-- card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Create New Product Or Service</h3>
        </div>
        <!-- /.card-header -->
        <form id="pro-Form" method="POST" action="{{ route('business.salesproduct.store') }}">
          @csrf
          <div class="card-body">
            <p>Products and services that you buy from vendors are used as items on Bills to record those purchases, and
              the ones that you sell to customers are used as items on Invoices to record those sales.</p>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sale_product_name">Item Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('sale_product_name') is-invalid @enderror"
                    name="sale_product_name" id="sale_product_name" placeholder="Name of the Product or Service"
                    value="{{ old('sale_product_name') }}">
                  @error('sale_product_name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Price</label>
                  <div class="d-flex">
                    <input type="number" class="form-control form-controltext" name="sale_product_price"
                      aria-describedby="inputGroupPrepend" min="0" placeholder="0.00" value="{{ old('sale_product_price') }}">
                    <select class="form-select form-selectcurrency" name="sale_product_currency_id"
                      id="sale_product_currency_id">
                      <!-- <option value="">Select</option> --> 
                      @foreach($Country as $curr)
              <option value="{{ $curr->id }}">{{ $curr->currency_symbol }}</option>
            @endforeach
                    </select>

                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tax</label>
                  <select class="form-control select2" name="sale_product_tax" id="sale_product_tax">
                    <option value="">Select Tax</option>
                     @foreach($SalesTax as $salesTax)
                   <option value="{{ $salesTax->tax_id }}">{{ $salesTax->tax_name }}</option>
          @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" id="sale_product_sell" name="sale_product_sell" type="checkbox"
                    value="on" {{ old('sale_product_sell') ? 'checked' : '' }}>
                  <label class="form-check-label"><strong>Sell This</strong> (Allow this Product or Service to be Added
                    to Invoices.)</label>
                </div>
                <div class="form-group" id="income_account_group">
                  <label>Income Account <span class="text-danger">*</span></label>
                  <select class="form-select form-control" name="sale_product_income_account"
                    id="sale_product_income_account">
                    <option value="">Select Consulting Income</option>
                    @foreach($IncomeAccounts as $ca)
            <option value="{{ $ca->chart_acc_id }}">{{ $ca->chart_acc_name }}</option>
          @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" id="sale_product_buy" name="sale_product_buy" type="checkbox"
                    value="on" {{ old('sale_product_buy') ? 'checked' : '' }}>
                  <label class="form-check-label"><strong>Buy This</strong> (Allow this Product or Service to be Added
                    to Bills.)</label>
                </div>
                <div class="form-group" id="expense_account_group">
                  <label>Expense Account <span class="text-danger">*</span></label>
                  <select class="form-select form-control" name="sale_product_expense_account"
                    id="sale_product_expense_account">
                    <option value="">Insurance Vehicles</option>
                    @foreach($ExpenseAccounts as $car)
            <option value="{{ $car->chart_acc_id }}">{{ $car->chart_acc_name }}</option>
          @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="sale_product_desc">Description</label>
                  <textarea id="sale_product_desc" name="sale_product_desc"
                    class="form-control @error('sale_product_desc') is-invalid @enderror" rows="3"
                    placeholder="Enter your text here"></textarea>
                  @error('sale_product_desc')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="row py-20">
            <div class="col-md-12 text-center">
              <a href="{{route('business.salesproduct.index')}}" class="add_btn_br">Cancel</a>
              <a href="#"><button class="add_btn">Save</button></a>
            </div>
          </div><!-- /.col -->
      </div>
      </form>
      <!-- /.card -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sellCheckbox = document.getElementById('sale_product_sell');
    const buyCheckbox = document.getElementById('sale_product_buy');
    const incomeAccountGroup = document.getElementById('income_account_group');
    const expenseAccountGroup = document.getElementById('expense_account_group');

    function toggleVisibility() {
      incomeAccountGroup.style.display = sellCheckbox.checked ? 'block' : 'none';
      expenseAccountGroup.style.display = buyCheckbox.checked ? 'block' : 'none';
    }

    toggleVisibility();

    sellCheckbox.addEventListener('change', toggleVisibility);
    buyCheckbox.addEventListener('change', toggleVisibility);
  });
</script>


@endsection
@endif
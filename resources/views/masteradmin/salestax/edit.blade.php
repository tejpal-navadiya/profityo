@extends('masteradmin.layouts.app')
<title>Profityo | Update Sales Taxes</title>
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
        <div class="col-auto">
          <h1 class="m-0">Update Sales Taxes</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Update Sales Taxes</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
          <a href="{{route('business.salestax.index')}}"><button class="add_btn_br">Cancel</button></a>
          <button type="submit" form="items-form" class="add_btn">Save</button>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content px-10">
    <div class="container-fluid">
      @if(Session::has('salestax-edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('salestax-edit') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('salestax-edit');
      @endphp
    @endif
      <!-- card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">New Sales Taxes</h3>
        </div>
        <!-- /.card-header -->
        <form id="items-form" method="POST" action="{{ route('business.salestax.update', ['SalesTax' => $SalesTaxe->tax_id]) }}">
          @csrf
          @method('Patch')
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="taxname">Tax Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('tax_name') is-invalid @enderror" id=taxname
                    name="tax_name" placeholder="Tax Name" value="{{ $SalesTaxe->tax_name }}">
                  @error('tax_name')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="textabbreviation">Abbreviation <span class="text-danger">*</span></label>
                  <input type="text" class="form-control  @error('tax_abbreviation') is-invalid @enderror"
                    id="textabbreviation" name="tax_abbreviation" placeholder="Abbreviation"
                    value="{{ $SalesTaxe->tax_abbreviation }}">
                  @error('tax_abbreviation')
              <div class="invalid-feedback">{{ $message }}</div>
             @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="taxnumber">Your Tax Number</label>
                  <input type="number" class="form-control  @error('tax_number') is-invalid @enderror" id="taxnumber"
                    name="tax_number" placeholder="Your Tax Number" value="{{ $SalesTaxe->tax_number }}">
                  @error('tax_number')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="tax_number_invoices" value="on"
                    @if($SalesTaxe->tax_number_invoices == 'on') checked @endif>
                  <label class="form-check-label">Show Tax Number on Invoices</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="tax_recoverable" value="on"
                    @if($SalesTaxe->tax_recoverable == 'on') checked @endif>
                  <label class="form-check-label">This Tax is Recoverable</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="tax_compound" value="on"
                    @if($SalesTaxe->tax_compound == 'on') checked @endif>
                  <label class="form-check-label">This is a Compound Tax</label>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="taxdescription">Description</label>
                  <textarea id="taxdescription" class="form-control  @error('tax_desc') is-invalid @enderror" rows="3"
                    name="tax_desc" placeholder="Enter your text here">{{ $SalesTaxe->tax_desc }}</textarea>
                  @error('tax_desc')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="textrate">Tax Rate (%) <span class="text-danger">*</span></label>
                  <input type="number" name="tax_rate" class="form-control  @error('tax_rate') is-invalid @enderror"
                    id="textrate" placeholder="0.000" value="{{ $SalesTaxe->tax_rate }}">
                  @error('tax_rate')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                </div>
              </div>
            </div>
            <div class="row py-20 px-10">
              <div class="col-md-12 text-center">
                <a href="{{route('business.salestax.index')}}" class="add_btn_br">Cancel</a>
                <button type="submit" class="add_btn">Save</button>
              </div>
            </div>
        </form>
      </div>
    </div>
    <!-- /.card -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@endsection
@extends('masteradmin.layouts.app')
<title>Profityo | Edit Transaction</title>
@if(isset($access['update_invoices']) && $access['update_invoices'] == 1) 
@section('content')
<link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Edit Transaction</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Edit Transaction</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#"><button class="add_btn_br">Cancel</button></a>
              <a href="#"><button class="add_btn">Save</button></a>
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
            <div class="row align-items-center justify-content-between">
              <div class="col-auto"><h3 class="card-title">Edit Transaction</h3></div>
              <div class="col-auto">
                <button type="button" class="selectall_icon_btn" data-toggle="modal" data-target="#deletetransaction">
                  <i class="far fa-trash-alt"></i>
                </button>
                <button type="button" class="selectall_icon_btn">
                  <i class="fas fa-regular fa-copy"></i>
                </button>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
       

  <div class="row"> 
  <form action="{{ route('business.transaction.update', $payment->record_payment_id) }}" method="POST">

    @csrf
    @method('POST')

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Date<span class="text-danger">*</span></label>
                <div class="input-group">
                    <x-flatpickr 
                        id="from-datepicker" 
                        name="payment_date" 
                        placeholder="Select a date" 
                        class="form-control"
                        value="{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}"
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

        <div class="col-md-4">
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <textarea id="description" class="form-control" name="description" rows="1"
                placeholder="Write a description">{{ $payment->description }}</textarea>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Account</label>
                <select class="form-control form-select" name="payment_account" placeholder="Enter your text here">
                    <option>Select a Payment Account...</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->chart_acc_id }}" {{ $payment->payment_account == $account->chart_acc_id ? 'selected' : '' }}>
                            {{ $account->chart_acc_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Type</label>
                <select class="form-control form-select" name="type" data-placeholder="Choose Option..." style="width: 100%;">
                    <option value="1" {{ $payment->type == 1 ? 'selected' : '' }}>Deposit</option>
                    <option value="2" {{ $payment->type == 2 ? 'selected' : '' }}>Withdrawal</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Amount</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="payment_amount" value="{{ $payment->payment_amount }}" placeholder="0.00">
                    <div class="input-group-append">
                        <span class="input-group-text">$</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" class="form-control">
                    @foreach ($tabs as $tab)
                        <optgroup label="{{ $tab->chart_menu_title }}">
                            @foreach ($subMenus[$tab->chart_menu_id] ?? [] as $submenu)
                                <option value="{{ $submenu->chart_menu_id }}" {{ (string)$payment->category === (string)$submenu->chart_menu_id ? 'selected' : '' }}>
                                    {{ $submenu->chart_menu_title }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-auto">
            <h3 class="card-title card-title_2" data-toggle="modal" data-target="#salestax">Include Sales Tax</h3>
        </div>
        <div class="col-auto">
            <span class="card-title card-title_2 pxy-10">•</span>
        </div>
        <div class="col-auto">
            <h3 class="card-title card-title_2">Add Customer</h3>
        </div>
        <div class="col-auto">
            <a href="#" data-toggle="modal" data-target="#split-transaction">
                <button type="button" class="add_btn_br mar_15">Split Transaction</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="inputDescription">Notes</label>
                <textarea id="inputDescription" class="form-control" name="notes" rows="3" placeholder="Write a note here...">{{ $payment->notes }}</textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="business_logo_uplod_box text-center">
                <img src="https://profityo.app/public/dist/img/upload_icon.png" class="upload_icon_img mb-2">
                <p class="upload_text">Drag Your File Here Or <span class="link_text">Select a File</span> To Upload</p>
                <p class="upload_text">Files Must be 6MB or Smaller, and in one of These Formats: JPG, JPEG, GIF, TIFF, TIF, BMP, PNG, PDF, or HEIC</p>
            </div>
        </div>
    </div>

    <div class="row py-20">
        <div class="col-md-12 text-center">
            <a href="#"><button type="button" class="add_btn_br">Cancel</button></a>
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

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>

<script>
  $(document).ready(function () {
    $('.select2').select2();
    $('#country').change(function () {
      var countryId = $(this).val();
      // alert(countryId);
      if (countryId) {
        $.ajax({
          url: '{{ env('APP_URL') }}{{ config('global.businessAdminURL') }}/states/' + countryId,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('#state').empty();
            $('#state').append('<option value="">Select a State...</option>');
            $.each(data, function (key, value) {
              $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          }
        });
      } else {
        $('#state').empty();
        $('#state').append('<option value="">Select a State...</option>');
      }
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
@endsection
@endif
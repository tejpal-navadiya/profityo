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
              <div class="col-md-4">
                <div class="form-group">
                  <label for="itemname">Date</label>
                  <div class="input-group date" id="date1" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder="2024-04-29" data-target="#date1">
                    <div class="input-group-append" data-target="#date1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="inputDescription">Description</label>
                  <textarea id="inputDescription" class="form-control" rows="1" placeholder="Enter your text here"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Account</label>
                  <select class="form-select form-control">
                    <option selected>Cash on Hand</option>
                    <option>INR for Cash (INR)</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-select form-control">
                    <option selected>Withdrawal</option>
                    <option>Deposit</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Amount</label>
                  <div class="d-flex">
                    <input type="text" class="form-control form-controltext" aria-describedby="inputGroupPrepend" placeholder="0.00">
                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-select form-control">
                    <option selected>Uncategorized Income</option>
                    <option>Sales Discounts</option>
                    <option>Sales</option>
                    <option>Program Income - Program Service Fees</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- /.row -->
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
                <a href="#" data-toggle="modal" data-target="#split-transaction"><button class="add_btn_br mar_15">Split Transaction</button></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputDescription">Notes</label>
                  <textarea id="inputDescription" class="form-control" rows="3" placeholder="Write a note here..."></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="business_logo_uplod_box">
                  <img src="dist/img/upload_icon.png" class="upload_icon_img">
                  <p class="upload_text">Drag Your File Here Or <span class="link_text">Select a File</span> To Upload</p>
                  <p class="upload_text">Files Must be 6MB or Smaller, and in one of These Formats: JPG, JPEG, GIF, TIFF, TIF, BMP, PNG, PDF, or HEIC</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row py-20">
            <div class="col-md-12 text-center">
              <a href="#"><button class="add_btn_br">Cancel</button></a>
              <a href="#"><button class="add_btn">Save</button></a>
            </div>
          </div><!-- /.col -->
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

@endsection
@endif
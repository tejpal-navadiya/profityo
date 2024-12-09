@extends('masteradmin.layouts.app')
<title>Profityo | Edit Sales Customers</title>
@if(isset($access['update_customers']) && $access['update_customers']) 
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0">Edit Sales Customers</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('business.home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Sales Customers</li>
                    </ol>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('business.salescustomers.index')}}"><button class="add_btn_br">Cancel</button></a>
                        <button type="submit" form="cust-Form" class="add_btn">Save</button>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content px-10">
      <div class="container-fluid">
        <!-- card -->
        @if(Session::has('sales-customers-edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('sales-customers-edit') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('sales-customers-edit');
      @endphp
    @endif
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Basic Information</h3>
          </div>
          <!-- /.card-header -->
          <form id="cust-Form" method="POST" action="{{ route('business.salescustomers.update', ['SalesCustomers' => $SalesCustomerse->sale_cus_id]) }}">
          @csrf
          @method('Patch')
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="customertitle">Customer <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('sale_cus_business_name') is-invalid @enderror" name="sale_cus_business_name" id="customertitle" placeholder="Business Or Person" value="{{ $SalesCustomerse->sale_cus_business_name }}">
                  @error('sale_cus_business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                </div>
              </div>
            </div>
            <div class="modal_sub_title">Primary Contact</div>
           <div id="contact_fields_container">
            <div class="row pad-5">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customerfirstname">First Name</label>
                  <input type="text" class="form-control @error('sale_cus_first_name') is-invalid @enderror" name="sale_cus_first_name" id="customerfirstname" placeholder="Enter First Name" value="{{ $SalesCustomerse->sale_cus_first_name }}">
                  @error('sale_cus_first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customerlastname">Last Name</label>
                  <input type="text" class="form-control @error('sale_cus_last_name') is-invalid @enderror" name="sale_cus_last_name" id="customerlastname" placeholder="Enter Last Name" value="{{ $SalesCustomerse->sale_cus_last_name }}">
                  @error('sale_cus_last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customeremail">Email</label>
                  <input type="email" class="form-control @error('sale_cus_email') is-invalid @enderror" name="sale_cus_email" id="customeremail" placeholder="Enter Email" value="{{ $SalesCustomerse->sale_cus_email }}">
                  @error('sale_cus_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customerphonenumber">Phone Number</label>
                  <div class="d-flex">
                    <input type="number" class="form-control @error('sale_cus_phone') is-invalid @enderror" name="sale_cus_phone" id="customerphonenumber" placeholder="Enter Phone Number" value="{{ $SalesCustomerse->sale_cus_phone }}">
                    @error('sale_cus_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                   @enderror  
                    <!-- <button class="add_phone_btn"><i class="fas fa-plus add_plus_icon"></i>Add Phone</button> -->
                  </div>
                </div>
              </div>
             
              <div class="col-md-12">
              <button type="button" id="add" class="add_contactbtn"><i class="fas fa-plus add_plus_icon"></i>Add Contact</button>
              </div>
              <div class="col-md-12" id="dynamic_field">
                @foreach($customerContact as $item)
                <div class="item-row row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contactname">Name</label>
                      <div class="d-flex">
                      <input type="text" class="form-control" id="contactname" name="items[][cus_con_name]" placeholder="Enter Name" value="{{ $item->cus_con_name ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contactemail">Email</label>
                      <div class="d-flex">
                      <input type="email" id="contactemail" class="form-control" name="items[][cus_con_email]" placeholder="Enter Email" value="{{ $item->cus_con_email ?? '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contactphone">Phone Number</label>
                      <div class="d-flex">
                        <input type="text" name="items[][cus_con_phone]" class="form-control" aria-describedby="inputGroupPrepend" placeholder="Enter Phone" id="contactphone" value="{{ $item->cus_con_phone ?? '' }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <i class="fa fa-trash delete-item"> Remove Contact </i>
                  </div>
              
                </div>
                @endforeach
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customeraccountnumber">Account Number</label>
                  <input type="number" class="form-control" name="sale_cus_account_number" id="customeraccountnumber" placeholder="Enter Account Number" value="{{ $SalesCustomerse->sale_cus_account_number }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customerwebsite">Website</label>
                  <input type="text" class="form-control" name="sale_cus_website" id="customerwebsite" placeholder="Enter Website" value="{{ $SalesCustomerse->sale_cus_website }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="customernote">Notes</label>
                  <input type="text" class="form-control" name="sale_cus_notes" id="customernote" placeholder="Enter Notes" value="{{ $SalesCustomerse->sale_cus_notes }}">
                </div>
              </div>
            </div>
            <div class="modal_sub_title">Billing</div>
            <div class="row pad-5">
              <div class="col-md-12">
                <div class="form-group">
               <label>Currency</label>
                    <select class="form-control from-select select2 @error('sale_bill_currency_id') is-invalid @enderror" name="sale_bill_currency_id" style="width: 100%;">
                      <option value="">Select a Currency</option>
                      @foreach($Country as $cur)
                          <option value="{{ $cur->id }}" @if($cur->id == $SalesCustomerse->sale_bill_currency_id) selected @endif>
                              {{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}
                          </option>
                      @endforeach
                    </select>
                  <label>Invoices for this customer will default to this currency.</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bill_address1">Address Line 1</label>
                  <input type="text" class="form-control" name="sale_bill_address1" id="bill_address1" placeholder="Enter a Address" value="{{ $SalesCustomerse->sale_bill_address1 }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bill_address2">Address Line 2</label>
                  <input type="text" class="form-control" name="sale_bill_address2" id="bill_address2" placeholder="Enter a Address" value="{{ $SalesCustomerse->sale_bill_address2 }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                <label>Country</label>
                    <select class="form-control from-select select2 @error('sale_bill_country_id') is-invalid @enderror" name="sale_bill_country_id" id="bill_country" style="width: 100%;">
                    <option value="">Select Country</option>
                        @foreach($Country as $con)
                            <option value="{{ $con->id }}" @if($con->id == $SalesCustomerse->sale_bill_country_id) selected @endif>
                                {{ $con->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bill_city">City</label>
                  <input type="text" class="form-control" name="sale_bill_city_name" id="bill_city" placeholder="Enter A City" value="{{ $SalesCustomerse->sale_bill_city_name }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bill_zipcode">Postal/ZIP Code</label>
                  <input type="text" class="form-control" name="sale_bill_zipcode" id="bill_zipcode" placeholder="Enter a Zip Code" value="{{ $SalesCustomerse->sale_bill_zipcode }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                <label>Province/State</label>
                  <select class="form-control from-select select2 @error('sale_bill_state_id') is-invalid @enderror" name="sale_bill_state_id" id="bill_state" style="width: 100%;">
                  <option value="">Select State</option>
                        <!-- @foreach($State as $states)
                            <option value="{{ $states->id }}">{{ $states->name }}</option>
                        @endforeach -->
                        @foreach($State as $states)
                            <option value="{{ $states->id }}" @if($states->id == $SalesCustomerse->sale_bill_state_id) selected @endif>
                                {{ $states->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
            <div class="modal_sub_title d-flex justify-content-between">Shipping
              <div class="form-check d-flex">
                <input class="form-check-input" id="same_address_checkbox" name="sale_same_address" type="checkbox" value="on"
                @if($SalesCustomerse->sale_same_address == 'on') checked @endif>
                <label class="form-check-label">Same As Billing Address</label>
              </div>
            </div>
            <div class="row pad-5">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="ship_to">Ship To</label> 
                  <input type="text" class="form-control" name="sale_ship_shipto" id="ship_to" placeholder="Name" value="{{ $SalesCustomerse->sale_ship_shipto }}">
                  <label>Name of Business or Person.</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ship_address1">Address Line 1</label>
                  <input type="text" class="form-control" name="sale_ship_address1" id="ship_address1" placeholder="Enter a Address" value="{{ $SalesCustomerse->sale_ship_address1 }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ship_address2">Address Line 2</label>
                  <input type="text" class="form-control" name="sale_ship_address2" id="ship_address2" placeholder="Enter a Address" value="{{ $SalesCustomerse->sale_ship_address2 }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Country</label>
                  <select class="form-control from-select select2 @error('sale_ship_country_id') is-invalid @enderror" name="sale_ship_country_id" id="ship_country" style="width: 100%;">
                  <option value="">Select Country</option>
                        <!-- @foreach($Country as $cont)
                            <option value="{{ $cont->sale_ship_country_id }}">{{ $cont->name }}</option>
                        @endforeach -->
                        @foreach($Country as $cont)
                            <option value="{{ $cont->id }}" @if($cont->id == $SalesCustomerse->sale_ship_country_id) selected @endif>
                                {{ $cont->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ship_city">City</label>
                  <input type="text" class="form-control" name="sale_ship_city_name" id="ship_city" placeholder="Enter A City" value="{{ $SalesCustomerse->sale_ship_city_name }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ship_zipcode">Postal/ZIP Code</label>
                  <input type="text" class="form-control" name="sale_ship_zipcode" id="ship_zipcode" placeholder="Enter a Zip Code" value="{{ $SalesCustomerse->sale_ship_zipcode }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                <label>Province/State</label>
                  <select class="form-control from-select select2 @error('sale_ship_state_id') is-invalid @enderror" name="sale_ship_state_id" id="ship_state" style="width: 100%;">
                  <option value="">Select State</option>
                        <!-- @foreach($State as $states)
                            <option value="{{ $states->sale_ship_state_id }}">{{ $states->name }}</option>
                        @endforeach -->
                        @foreach($ship_state as $statest)
                            <option value="{{ $statest->id }}" @if($statest->id == $SalesCustomerse->sale_ship_state_id) selected @endif>
                                {{ $statest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="ship_phone">Phone</label>
                  <input type="Number" class="form-control" name="sale_ship_phone" id="ship_phone" placeholder="Enter Phone Number" value="{{ $SalesCustomerse->sale_ship_phone }}">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="delivery_instructions">Delivery instructions</label>
                  <input type="text" class="form-control" name="sale_ship_delivery_desc" id="delivery_instructions" placeholder="Delivery instructions" value="{{ $SalesCustomerse->sale_ship_delivery_desc }}">
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="row py-20 px-10">
            <div class="col-md-12 text-center">
              <a href="{{route('business.salescustomers.index')}}" class="add_btn_br">Cancel</a>
             <button type="submit" class="add_btn">Save</button>
            </div>
          </div><!-- /.col -->
      </form>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bill_country').change(function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: '{{ url('business/getstates') }}/' + country_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#bill_state').empty();
                        $('#bill_state').append('<option value="">Select State</option>');
                        $.each(data, function(key, value) {
                            $('#bill_state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#bill_state').empty();
                $('#bill_state').append('<option value="">Select State</option>');
            }
        });

        $('#ship_country').change(function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                  url: '{{ url('business/getstates') }}/' + country_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#ship_state').empty();
                        $('#ship_state').append('<option value="">Select State</option>');
                        $.each(data, function(key, value) {
                            $('#ship_state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#ship_state').empty();
                $('#ship_state').append('<option value="">Select State</option>');
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#bill_country').change(function() {
        var country_id = $(this).val();
        if (country_id) {
            $.ajax({
                url: '{{ url('business/productgetstates') }}/' + country_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#bill_state').empty();
                    $('#bill_state').append('<option value="">Select State</option>');
                    $.each(data, function(key, value) {
                        $('#bill_state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        } else {
            $('#bill_state').empty();
            $('#bill_state').append('<option value="">Select State</option>');
        }
    });

    $('#ship_country').change(function() {
        var country_id = $(this).val();
        if (country_id) {
            $.ajax({
                url: '{{ url('business/productgetstates') }}/' + country_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#ship_state').empty();
                    $('#ship_state').append('<option value="">Select State</option>');
                    $.each(data, function(key, value) {
                        $('#ship_state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        } else {
            $('#ship_state').empty();
            $('#ship_state').append('<option value="">Select State</option>');
        }
    });

    // Handle "Same as Billing Address" functionality
    $('#same_address_checkbox').change(function() {
        if ($(this).is(':checked')) {
            // Copy address fields
            $('#ship_address1').val($('#bill_address1').val());
            $('#ship_address2').val($('#bill_address2').val());
            $('#ship_city').val($('#bill_city').val());
            $('#ship_zipcode').val($('#bill_zipcode').val());
            $('#ship_country').val($('#bill_country').val()).trigger('change');

            // Copy the state after the country dropdown is populated
            setTimeout(function() {
                $('#ship_state').val($('#bill_state').val()).trigger('change');
            }, 500);
        } else {
            // Clear shipping address fields if unchecked
            $('#ship_address1, #ship_address2, #ship_city, #ship_zipcode, #ship_phone').val('');
            $('#ship_country, #ship_state').val('').trigger('change');
        }
    });
});
</script>

<script>
  
    $(document).ready(function () {
    let rowCount = 1;
    
    $('#add').click(function () {
      // alert('add');
      rowCount++;
      $('#dynamic_field').append(`
       <div class="item-row row align-items-end" id="row${rowCount}">
        <div class="col-md-3">
          <div class="form-group">
            <label for="contactname">Name</label>
            <div class="d-flex">
             <input type="text" class="form-control" id="contactname" name="items[][cus_con_name]" placeholder="Enter Name">
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="contactemail">Email</label>
            <div class="d-flex">
             <input type="email" id="contactemail" class="form-control" name="items[][cus_con_email]" placeholder="Enter Email" >
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="contactphone">Phone Number</label>
            <div class="d-flex">
              <input type="text" name="items[][cus_con_phone]" class="form-control" aria-describedby="inputGroupPrepend" placeholder="Enter Phone" id="contactphone">
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <button type="button" id="${rowCount}" class="remove_contact_btn delete-item"><i class="fa fa-trash add_plus_icon"></i>Remove Contact</button>
          </div>
        </div>
      
      </div>
      `);

    });

    $(document).on('click', '.delete-item', function () {
      
      var rowId = $(this).attr("id");
      $('#row' + rowId).remove();
    });

    $(document).on('click', '.delete-item', function () {
      $(this).closest('.item-row').remove();
    });

    });


  </script>

@endsection
@endif
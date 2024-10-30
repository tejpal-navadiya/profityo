@extends('masteradmin.layouts.app')
<title>Profityo | New Product Or Service</title>
@if(isset($access['add_vendors']) && $access['add_vendors'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">New Vendor</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">New Vendor</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
            <a href="{{route('business.purchasvendor.index')}}" class="add_btn_br">Cancel</a>
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
            <h3 class="card-title">Basic Information</h3>
          </div>
         
          <!-- /.card-header -->
          <form method="POST" action="{{ route('business.purchasvendor.store') }}">
          @csrf
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendorname">Vendor Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('purchases_vendor_name') is-invalid @enderror" id="purchases_vendor_name" name="purchases_vendor_name" placeholder="Vendor Name"  value="{{ old('purchases_vendor_name') }}">
                  @error('purchases_vendor_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                    <label for="vendorname">Type</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check d-flex">
                                   <input class="form-check-input mr-2" type="radio" name="type" value="Vendor" {{ old('type') == 'Vendor' ? 'checked' : '' }} id="regularType">
                                <!-- <input class="form-check-input mr-2" type="radio" name="vendor_type" value="Regular" {{ old('vendor_type') == 'on' ? 'checked' : '' }} id="regularType"> -->
                                <label class="form-check-label">
                                    <strong>Regular</strong> (Companies That Provide Goods and Services to your Business (E.G. Internet and Utility Providers).)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check d-flex">
                            <input class="form-check-input mr-2" type="radio" name="type" value="1099-NEC Contractor" {{ old('type') == '1099-NEC Contractor' ? 'checked' : '' }} id="contractorType">
                                <!-- <input class="form-check-input mr-2" type="radio" name="vendor_type" value="1099-NEC Contractor" {{ old('vendor_type') == '1099-NEC Contractor' ? 'checked' : '' }} id="contractorType"> -->
                                <label class="form-check-label">
                                    <strong>1099-NEC Contractor</strong> (Contractors that Perform a Service for Which you Pay them and Provide a 1099-NEC Form.)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            <div>
            <div id="vendorregular">
              <div class="modal_sub_title">Primary Contact</div>
              <div class="row pad-5">
              <div class="col-md-6" id="contractorFields" style="display: none;">
                <div class="form-group">
                    <label for="vendorfirstname">Contractor Type</label>
                      <select class="form-control select2" name="purchases_contractor_type" style="width: 100%;" value="{{ old('purchases_contractor_type') }}">
                      <option value="">Select Contractor Type</option>
                      <option>Individual</option>
                      <option>Business</option>
                    </select>
                    <!-- <input type="text" class="form-control" id="vendorfirstname" name="purchases_vendor_contractor_type" placeholder="Enter First Name" value=""> -->
                </div>
            </div>

            <div class="col-md-6" id="ssnField" style="display: none;">
                <div class="form-group">
                    <label for="vendorsocialsecuritynumber">Social Security Number</label>
                    <input type="text" class="form-control" id="purchases_vendor_security_number" name="purchases_vendor_security_number" value="" placeholder="Enter Number">
                </div>
            </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorfirstname">First Name</label>
                    <input type="text" class="form-control" id="vendorfirstname" name="purchases_vendor_first_name" placeholder="Enter First Name" value="{{ old('purchases_vendor_first_name') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorlastname">Last Name</label>
                    <input type="text" class="form-control" id="vendorlastname" name="purchases_vendor_last_name" placeholder="Enter Last Name" value="{{ old('purchases_vendor_last_name') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendoremail">Email</label>
                    <input type="email" class="form-control" id="vendoremail" name="purchases_vendor_email" placeholder="Enter Email" value="{{ old('purchases_vendor_email') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendoraddress1">Address Line 1</label>
                    <input type="text" class="form-control" id="vendoraddress1" name="purchases_vendor_address1" placeholder="Enter a Location" value="{{ old('purchases_vendor_address1') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendoraddress2">Address Line 2</label>
                    <input type="text" class="form-control" id="vendoraddress2" name="purchases_vendor_address2" placeholder="Enter a Location" value="{{ old('purchases_vendor_address2') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Country</label>
                    <select class="form-control from-select select2 @error('purchases_vendor_country_id') is-invalid @enderror" name="purchases_vendor_country_id" id="country" style="width: 100%;">
                  <option value="">Select Country</option>
                        @foreach($Country as $con)
                            <option value="{{ $con->id }}">{{ $con->name }}</option>
                        @endforeach
                    </select>
                  
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorcity">City</label>
                    <input type="text" class="form-control" id="vendorcity" name="purchases_vendor_city_name" placeholder="Enter A City" value="{{ old('purchases_vendor_city_name') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorzipcode">Postal/ZIP Code</label>
                    <input type="text" class="form-control" id="vendorzipcode" name="purchases_vendor_zipcode" placeholder="Enter a Zip Code" value="{{ old('purchases_vendor_zipcode') }}">
                  </div>
                </div>
                <!-- <div class="col-md-4">
                  <div class="form-group">
                    <label>Province/State</label>
                    <select class="form-control from-select select2 @error('purchases_vendor_state_id') is-invalid @enderror" name="purchases_vendor_state_id" id="state" style="width: 100%;">
                  <option value="">Select State</option>
                        @foreach($States as $states)
                            <option value="{{ $states->id }}">{{ $states->name }}</option>
                        @endforeach
                    </select>
                  
                  </div>
                </div> -->
                <div class="col-md-4">
                <div class="form-group">
                <label for="purchases_vendor_state_id">Province/State</label>
                  <select class="form-control from-select select2" name="purchases_vendor_state_id" id="state" style="width: 100%;">
                      <option value="">Select State</option>
                      <!-- States will be populated here dynamically -->
                  </select>

                </div>
              </div>
           
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Currency</label>
                    <select class="form-control from-select select2 @error('purchases_vendor_currency_id') is-invalid @enderror" name="purchases_vendor_currency_id" style="width: 100%;">
                      <option value="">Select a Currency</option>
                      @foreach($Country as $cur)
                          <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                      @endforeach
                    </select>
                   
                  </div>
                </div>
              </div>
              <div class="modal_sub_title">Additional Information</div>
              <div class="row pad-5">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendoraccountnumber">Account Number</label>
                    <input type="number" class="form-control" id="vendoraccountnumber" name="purchases_vendor_account_number" placeholder="Enter Account Number" value="{{ old('purchases_vendor_account_number') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorphonenumber">Phone Number</label>
                    <input type="number" class="form-control" id="vendorphonenumber" name="purchases_vendor_phone" placeholder="Enter Phone Number" value="{{ old('purchases_vendor_phone') }}">
                  </div>
                </div>
                <!-- <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorphonenumber">Fax</label>
                    <input type="number" class="form-control" id="vendorphonenumber" name="purchases_vendor_fax" placeholder="Enter Fax" value="{{ old('purchases_vendor_fax') }}">
                  </div>
                </div> -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorphonenumber">Mobile</label>
                    <input type="number" class="form-control" id="vendorphonenumber" name="purchases_vendor_mobile" placeholder="Enter Mobile" value="{{ old('purchases_vendor_mobile') }}">
                  </div>
                </div>
                <!-- <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorphonenumber">Toll free</label>
                    <input type="number" class="form-control" id="vendorphonenumber" name="purchases_vendor_toll_free" placeholder="Enter Toll free" value="{{ old('purchases_vendor_toll_free') }}">
                  </div>
                </div> -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vendorwebsite">Website</label>
                    <input type="text" class="form-control" id="vendorwebsite" name="purchases_vendor_website" placeholder="Enter Website" value="{{ old('purchases_vendor_website') }}">
                  </div>
                </div>
              </div>
            </div>
         
            <div class="row py-20 px-10">
              <div class="col-md-12 text-center">
                <a href="{{route('business.purchasvendor.index')}}" class="add_btn_br">Cancel</a>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#country').change(function() {
        var country_id = $(this).val();
        if (country_id) {
            $.ajax({
                url: '{{ url('business/vendorgetstates') }}/' + country_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#state').empty();
                    $('#state').append('<option value="">Select State</option>');
                    $.each(data, function(key, value) {
                        $('#state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        } else {
            $('#state').empty();
            $('#state').append('<option value="">Select State</option>');
        }
    });
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get references to the radio buttons and the fields
    var contractorRadio = document.getElementById('contractorType');
    var regularRadio = document.getElementById('regularType');
    var contractorFields = document.getElementById('contractorFields');
    var ssnField = document.getElementById('ssnField');

    // Function to toggle visibility
    function toggleFields() {
        if (contractorRadio.checked) {
            contractorFields.style.display = 'block';
            ssnField.style.display = 'block';
        } else {
            contractorFields.style.display = 'none';
            ssnField.style.display = 'none';
        }
    }

    // Initial toggle based on the default checked state
    toggleFields();

    // Add event listeners to radio buttons
    contractorRadio.addEventListener('change', toggleFields);
    regularRadio.addEventListener('change', toggleFields);
});
</script>


@endsection
@endif
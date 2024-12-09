@extends('masteradmin.layouts.app')
<title>Business Profile | Profityo</title>
@if(isset($access['business_profile']) && $access['business_profile']) 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center">
          <div class="col-sm-12">
            <h1 class="m-0">{{ __('Personal Information') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __('Business Profile') }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div class="profile nav flex-column nav-tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="vert-tabs-businessinformation-tab" data-toggle="pill" href="#vert-tabs-businessinformation" role="tab" aria-controls="vert-tabs-businessinformation" aria-selected="true">Business Profile<i class="fas fa-angle-right right"></i></a>

              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="tab-content" id="vert-tabs-tabContent">
              <div class="tab-pane text-left fade show active" id="vert-tabs-businessinformation" role="tabpanel" aria-labelledby="vert-tabs-businessinformation-tab">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{ __('Business Profile') }}</h3>
                  </div>
                  @if(Session::has('business-update'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                      {{ Session::get('business-update') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                      @php
                      Session::forget('business-update');
                      @endphp
                  @endif
                  <!-- /.card-header -->
                  <form method="post" action="{{ route('business.business.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                  @csrf
                  @method('patch')
                    <div class="card-body2">
                      <div class="row pad-5">
                        <div class="col-md-12">
                          <div class="form-group">
                            <x-input-label for="bus_company_name" :value="__('Business Name')" /><span class="text-danger">*</span>
                            <x-text-input type="text" class="form-control" id="bus_company_name" placeholder="Enter Business Name" name="bus_company_name"  autofocus autocomplete="bus_company_name" :value="old('bus_company_name', $BusinessDetails->bus_company_name ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('bus_company_name')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="bus_address1" :value="__('Address Line 1')" />
                            <x-text-input type="text" class="form-control" id="bus_address1" placeholder="Enter A Address Line 1" name="bus_address1"  autofocus autocomplete="bus_address1" :value="old('bus_address1', $BusinessDetails->bus_address1 ?? '')"/>
                            <x-input-error class="mt-2" :messages="$errors->get('bus_address1')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="bus_address2" :value="__('Address Line 2')" />
                            <x-text-input type="text" class="form-control" id="bus_address2" placeholder="Enter A Address Line 2" name="bus_address2"  autofocus autocomplete="bus_address2" :value="old('bus_address2', $BusinessDetails->bus_address2 ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('bus_address2')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="country" :value="__('Country')" /><span class="text-danger">*</span>
                            <select class="form-control select2" style="width: 100%;" id="country" name="country_id" >
                              <option default>Select a Country...</option>
                              @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $BusinessDetails->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }} ({{ $country->iso2 }})</option>
                              @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country_id')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="state" :value="__('Province/State')" /><span class="text-danger">*</span>
                            <select class="form-control select2" style="width: 100%;" id="state" name="state_id" >
                              <option default>Select a State...</option>
                              @foreach($states as $state)
                                  <option value="{{ $state->id }}" {{ $state->id == old('state_id', $BusinessDetails -> state_id ) ? 'selected' : '' }}>
                                      {{ $state->name }}
                                  </option>
                              @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('state_id')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="city_name" :value="__('City')" />
                            <x-text-input type="text" class="form-control" id="city_name" placeholder="Enter A City" name="city_name"  autofocus autocomplete="city_name" :value="old('city_name', $BusinessDetails->city_name ?? '')"/>
                            <x-input-error class="mt-2" :messages="$errors->get('city_name')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="zipcode" :value="__('Postal/ZIP Code')" />
                            <x-text-input type="text" class="form-control" id="zipcode" placeholder="Enter a Zip Code"  name="zipcode"  autofocus autocomplete="zipcode" :value="old('zipcode', $BusinessDetails->zipcode ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('zipcode')"  />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="bus_phone" :value="__('Phone')" />
                            <x-text-input type="text" class="form-control" id="bus_phone" placeholder="Enter a Phone" name="bus_phone"  autofocus autocomplete="bus_phone" :value="old('bus_phone', $BusinessDetails->bus_phone ?? '')"/>
                            <x-input-error class="mt-2" :messages="$errors->get('bus_phone')" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="bus_mobile" :value="__('Mobile')" />
                            <x-text-input type="text" class="form-control" id="bus_mobile" placeholder="Enter a Mobile" name="bus_mobile"  autofocus autocomplete="bus_mobile" :value="old('bus_mobile', $BusinessDetails->bus_mobile ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('bus_mobile')"  />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <x-input-label for="bus_website" :value="__('Website')" />
                            <x-text-input type="text" class="form-control" id="bus_website" placeholder="Enter a Website" name="bus_website"  autofocus autocomplete="bus_website" :value="old('bus_website', $BusinessDetails->bus_website ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('bus_website')"  />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="currency">Business Currency </label>
                            <h5 for="currency">
                            @if ($currency)
                              <h5 for="currency">{{ $currency->currency }} - {{ $currency->currency_name }}</h5>
                            @else
                              <h5 for="currency">No currency information available</h5>
                            @endif
                            </h5>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Business Profile Image</label>
                            <div>
                              <input type="file" name="image" accept="image/*" class="add_btn fileinput-button">
                              <span>Please upload a valid image file. Size of image should not be more than 2MB.</span>
                              @if ($BusinessDetails->bus_image ?? '')
                                <a href="{{ url(env('IMAGE_URL').'storage/app/masteradmin/business_profile/' . $BusinessDetails->bus_image) }}" target="_blank">
                                    <div title="{{ $BusinessDetails->bus_image }}" class="ptm pbm">{{ $BusinessDetails->bus_image }}</div>
                                </a>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row py-20 px-10">
                        <div class="col-md-12 text-center">
                          <button type="submit" class="add_btn">{{ __('Save Changes') }}</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              
            </div>
          </div>
          <!-- /.col -->
        </div>
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


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
      $('.select2').select2();
      $('#country').change(function() {
          var countryId = $(this).val();
          // alert(countryId);
          if (countryId) {
              $.ajax({
                  url : '{{ env('APP_URL') }}{{ config('global.businessAdminURL') }}/states/' + countryId,
                  type: 'GET',
                  dataType: 'json',
                  success: function(data) {
                      $('#state').empty();
                      $('#state').append('<option value="">Select a State...</option>');
                      $.each(data, function(key, value) {
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
@endif
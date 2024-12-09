@extends('masteradmin.layouts.app')
<title>Profityo | Edit Product Or Service</title>
@if(isset($access['update_product_services_purchases']) && $access['update_product_services_purchases'])
  @section('content')
  <link rel="stylesheet" href="{{ url(path: 'public/vendor/flatpickr/css/flatpickr.css') }}">

  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="m-0">Edit Employee</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Employee</li>
        </ol>
      </div><!-- /.col -->
      <div class="col-auto">
        <ol class="breadcrumb float-sm-right">
        <a href="{{ route('business.employee.index') }}"><button class="add_btn_br">Cancel</button></a>
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

      <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
      <ul class="nav nav-pills p-2 tab_box">
        <li class="nav-item"><a class="nav-link active" href="#personalinformation" data-toggle="tab">Personal
          Information</a></li>
        <li class="nav-item"><a class="nav-link" href="#compensation" data-toggle="tab">Compensation</a></li>
        <li class="nav-item"><a class="nav-link" href="#compensation" data-toggle="tab">Vacation</a></li>
        <li class="nav-item"><a class="nav-link" href="#taxdetails" data-toggle="tab">Tax Details</a></li>
        <li class="nav-item"><a class="nav-link" href="#compensation" data-toggle="tab">Benefits & Deductions</a></li>
        <li class="nav-item"><a class="nav-link" href="#compensation" data-toggle="tab">Employee Files</a></li>
        <li class="nav-item"><a class="nav-link" href="#employmentstatus" data-toggle="tab">Employment Status</a></li>
      </ul>
      </div><!-- /.card-header -->

      <div class="tab-content">
      <div class="tab-pane active" id="personalinformation">
        <div class="card px-20">
        <div class="card-header">
          <h3 class="card-title">Personal Information</h3>
        </div>
    

        <class="card-body2">
          <div class="row pad-5">
          <div class="col-md-4">
            <form id="items-form" action="{{ route('business.employee.update', $employee->emp_id) }}" method="POST">
            @csrf
            @method('Patch')
            <div class="form-group">
              <label for="employeefirstname">First Name</label>
              <input type="text" class="form-control" id="employeefirstname" name="emp_first_name"
              value="{{ old('emp_first_name', $employee->emp_first_name) }}" placeholder="Enter First Name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label for="employeelastname">Last Name</label>
            <input type="text" class="form-control" id="employeelastname" name="emp_last_name"
              value="{{ old('emp_last_name', $employee->emp_last_name) }}" placeholder="Enter Last Name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label for="employeesecuritynumber">Social Security Number <span
              class="text-danger">*</span></label>
            <input type="text" class="form-control" id="employeesecuritynumber"
              name="emp_social_security_number"
              value="{{ old('emp_social_security_number', $employee->emp_social_security_number) }}"
              placeholder="Enter Social Security Number">

              @error('emp_social_security_number')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
            <label for="employeeaddress">Address Line 1</label>
            <input type="text" class="form-control" id="emp_address" name="emp_hopy_address"
              value="{{ old('emp_hopy_address', $employee->emp_hopy_address) }}" placeholder="Enter Address">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label>State</label>
            <select class="form-control" id="state_id" name="state_id">
              <option value="">Select State</option>
              @foreach($State as $state)
          <option value="{{ $state->id }}" {{ (old('state_id', $employee->state_id) == $state->id) ? 'selected' : '' }}>
          {{ $state->name }}
          </option>
        @endforeach
            </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
            <label for="employeecity">City</label>
            <input type="text" class="form-control" id="city_name" name="city_name"
              value="{{ old('city_name', $employee->city_name) }}" placeholder="Enter City">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label for="employeezipcode">Postal/ZIP Code</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode"
              value="{{ old('zipcode', $employee->zipcode) }}" placeholder="Enter Zipcode">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label>Date of Birth <span class="text-danger">*</span></label>

            <div class="input-group date" id="estimatedate" data-target-input="nearest">

              <input type="hidden" id="from-datepicker-hidden" value="{{ $employee->emp_dob }}" />

              @php
        $saleEstimDate = \Carbon\Carbon::parse($employee->emp_dob)->format('m/d/Y');
        @endphp

              <x-flatpickr id="from-datepicker" name="emp_dob" placeholder="Select a date"
              :value="$saleEstimDate" />
              <div class="input-group-append">
              <div class="input-group-text" id="from-calendar-icon">
                <i class="fa fa-calendar-alt"></i>
              </div>
              </div>
              <span class="error-message" id="error_sale_estim_date" style="color: red;"></span>
            </div>

            </div>
          </div>
        
          <div class="col-md-4">
            <div class="form-group">
            <label for="employeeemail">Email</label>
            <input type="email" class="form-control" id="emp_email" name="emp_email"
              value="{{ old('emp_email', $employee->emp_email) }}" placeholder="Enter Email">
            </div>
          </div>
          </div>
          <div class="modal_sub_title">Work Information</div>
<div class="row pad-5">
    <!-- Work Location -->
    <div class="col-md-4">
        <div class="form-group">
            <label>Work Location <span class="text-danger">*</span></label>
            <select class="form-control" id="emp_work_location" name="emp_work_location">
                <option value="">Select Work Location</option>
                <option value="1" {{ (old('emp_work_location', $employee->emp_work_location) == '1') ? 'selected' : '' }}>Employee always works from business location</option>
                <option value="2" {{ (old('emp_work_location', $employee->emp_work_location) == '2') ? 'selected' : '' }}>Employee always works from home</option>
            </select>
            @error('emp_work_location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Wage Type -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="emp_wage_type">Wage Type</label>
            <select id="emp_wage_type" name="emp_wage_type" class="form-control">
                <option value="Hourly" {{ old('emp_wage_type', $employee->emp_wage_type) == 'Hourly' ? 'selected' : '' }}>Hourly</option>
                <option value="Annual" {{ old('emp_wage_type', $employee->emp_wage_type) == 'Annual' ? 'selected' : '' }}>Annual</option>
            </select>
        </div>

        <!-- Work Hours (Visible only when Wage Type is Annual) -->
        <div id="work-hours-container" class="form-group" style="display: {{ old('emp_wage_type', $employee->emp_wage_type) == 'Annual' ? 'block' : 'none' }}">
            <label for="emp_work_hours">Work Hours Per Week</label>
            <input type="number" id="emp_work_hours" name="emp_work_hours" class="form-control"
                   value="{{ old('emp_work_hours', $employee->emp_work_hours ?? '') }}">
        </div>
    </div>

    <!-- Wage Amount -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="emp_wage_amount">Wages Amount <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="emp_wage_amount" name="emp_wage_amount"
                   value="{{ old('emp_wage_amount', $employee->emp_wage_amount) }}" placeholder="Enter Wage Amount">
            @error('emp_wage_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Vacation Policy -->
<div class="row pad-5">
    <div class="col-md-4">
        <div class="form-group">
            <label>Vacation Policy <span class="text-danger">*</span></label>
            <select class="form-control" name="emp_vacation_policy" id="emp_vacation_policy">
                @foreach($vacation as $policy)
                    <option value="{{ $policy->v_id }}" {{ old('emp_vacation_policy', $employee->emp_vacation_policy) == $policy->v_id ? 'selected' : '' }}>
                        {{ $policy->name }}
                    </option>
                @endforeach
            </select>
            @error('emp_vacation_policy')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Vacation Accrual Rate (Visible only when Vacation Policy requires it) -->
    <div class="col-md-4" id="accrual_rate_container" style="display: {{ old('emp_vacation_policy', $employee->emp_vacation_policy) == '2' ? 'block' : 'none' }}">
        <div class="form-group">
            <label>Vacation Accrual Rate</label>
            <input type="number" class="form-control" name="emp_vacation_accural_rate" id="emp_vacation_accural_rate"
                   value="{{ old('emp_vacation_accural_rate', $employee->emp_vacation_accural_rate) }}">
        </div>
        e.g. 4% of regular hours on a 40 hour/week payroll period translates to 80 hours/year.
    </div>
</div>

<!-- Direct Deposit -->
<div class="row pad-5">
    <div class="col-md-4">
        <div class="form-group">
            <label>Direct Deposit <span class="text-danger">*</span></label>
            <div>
                <label class="radio-inline">
                    <input type="radio" name="emp_direct_deposit" id="radioYes" value="1" {{ old('emp_direct_deposit', $employee->emp_direct_deposit) == '1' ? 'checked' : '' }}> Yes
                </label>
                <small id="message1" class="text-muted d-block">This requires employee bank information.</small>
                <label class="radio-inline">
                    <input type="radio" name="emp_direct_deposit" id="radioNo" value="0" {{ old('emp_direct_deposit', $employee->emp_direct_deposit) == '0' ? 'checked' : '' }}> No
                </label>
                <small id="message2" class="text-muted d-block">You can change this setting at any time.</small>
            </div>
            @error('emp_direct_deposit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>


<!-- Save and Cancel Buttons -->
<div class="row py-20 px-10">
    <div class="col-md-12 text-center">
        <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
        <button class="add_btn">Save</button>
    </div>
</div>

          </form>
        </div>

        <!-- </div> -->
      </div>
      <!-- /.tab-pane -->
      <!-- <div class="tab-pane" id="compensation">
      <div class="card px-20">
      <div class="card-header">
        <h3 class="card-title">Compensation</h3>
      </div>
      <div class="card-body">
        <div class="row align-items-center justify-content-between">
        <div class="col-auto d-flex">
        <p id="Salary" class="font_18 mb-0">${{$employee->emp_wage_amount}}/{{$employee->emp_wage_type}}</p>
        <button id="toggleBtn" onclick="toggleSalary()" class="hide_show_btn">Hide</button>
        </div>



        <div class="col-auto">
        <button id="edit_salary" class="reminder_btn">Change Salary</button>
        </div>
        </div>

        <div class="editsalarybox mt-3">
        <form action="{{ route('employees.storeCompensation', $employee->emp_id) }}" method="POST">
        @csrf
        @method('Patch')
        <input type="hidden" name="emp_id" value="{{ $employee->emp_id }}">
        <div class="row mt-3">
        <div class="col-md-4">
          <div class="form-group">
          <label for="emp_comp_salary_amount">Salary Amount <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="salaryamount" name="emp_comp_salary_amount"
          placeholder="0.00">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
          <label for="emp_comp_salary_type">Salary Type <span class="text-danger">*</span></label>
          <select class="form-control" id="emp_comp_salary_type" name="emp_comp_salary_type">
          <option value="">Select</option>
          <option value="Hourly">Hourly</option>
          <option value="Annual">Annual</option>
          </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
          <label for="emp_comp_effective_date">Effective Date <span class="text-danger">*</span></label>

          <div class="input-group date" id="estimatevaliddate" data-target-input="nearest">

          <x-flatpickr id="d-datepicker" name="emp_comp_effective_date" placeholder="Select a date" />
          <div class="input-group-append">
          <div class="input-group-text" id="d-calendar-icon">
            <i class="fa fa-calendar-alt"></i>
          </div>
          </div>
          </div>

          </div>
        </div>
        </div>
        <div class="row py-20 px-10">
        <div class="col-md-12 text-center">
          <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
          <button type="submit" class="add_btn">Save</button>
        </div>
        </div>
        </form>
        </div>
      </div>
      </div>
      </div> -->
      <div class="tab-pane" id="compensation">
        <div class="card px-20">
        <div class="card-header">
          <h3 class="card-title">Compensation</h3>
        </div>
        <div class="card-body">
          <div class="row align-items-center justify-content-between">
          <div class="col-auto d-flex">
            <p id="Salary" class="font_18 mb-0">
            ${{$employee->emp_wage_amount}}/{{$employee->emp_wage_type}}
            </p>
            <button id="toggleBtn" onclick="toggleSalary()" class="hide_show_btn">Hide</button>
          </div>
          <div class="col-auto">
            <button id="edit_salary" class="reminder_btn" onclick="toggleSalaryForm()">Change Salary</button>
          </div>
          </div>

          <!-- Form is hidden by default -->
          <div class="editsalarybox mt-3" style="display: none;">
          <form action="{{ route('employees.storeCompensation', $employee->emp_id) }}" method="POST">
                        @csrf
                        @method('Patch')
                        <input type="hidden" name="emp_id" value="{{ $employee->emp_id }}">

                        <div class="row mt-3">
                        <div class="col-md-4">
                          <div class="form-group">
                          <label for="emp_comp_salary_amount">Salary Amount <span class="text-danger">*</span></label>
                          <input type="number" class="form-control @error('emp_comp_salary_amount') is-invalid @enderror"
                            id="salaryamount" name="emp_comp_salary_amount" placeholder="0.00"    value="{{ old('emp_comp_salary_amount', $EmployeeComperisation->emp_comp_salary_amount ?? '') }}">
                          @error('emp_comp_salary_amount')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                          <label for="emp_comp_salary_type">Salary Type <span class="text-danger">*</span></label>
                          <select class="form-control @error('emp_comp_salary_type') is-invalid @enderror"
                            id="emp_comp_salary_type" name="emp_comp_salary_type">
                            <option value="">Select</option>
                            <option value="Hourly"  {{ old('emp_comp_salary_type', $EmployeeComperisation->emp_comp_salary_type ?? '') == 'Hourly' ? 'selected' : '' }}>Hourly</option>
                            <option value="Annual"  {{ old('emp_comp_salary_type', $EmployeeComperisation->emp_comp_salary_type ?? '') == 'Annual' ? 'selected' : '' }}>Annual</option>
                          </select>
                          @error('emp_comp_salary_type')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group @error('emp_comp_effective_date') is-invalid @enderror">
                          <label for="emp_comp_effective_date">Effective Date </label>
                          <!-- <div class="input-group date" id="estimatevaliddate" data-target-input="nearest">
                            <x-flatpickr id="d-datepicker" name="emp_comp_effective_date" placeholder="Select a date" />
                            <div class="input-group-append">
                            <div class="input-group-text" id="d-calendar-icon">
                              <i class="fa fa-calendar-alt"></i>
                            </div>
                            </div>
                            @error('emp_comp_effective_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                          </div>
                          </div>
                        </div> -->
                        <div class="input-group date" id="estimatedate" data-target-input="nearest">

<input type="hidden" id="effective-datepicker-hidden" value="{{ $EmployeeComperisation->emp_comp_effective_date ?? ''}}" />

@php
$saleEstimDate = \Carbon\Carbon::parse($EmployeeComperisation->emp_comp_effective_date ?? '')->format('m/d/Y');
@endphp

<x-flatpickr id="effective-datepicker" name="emp_comp_effective_date" placeholder="Select a date"
:value="$saleEstimDate" />
<div class="input-group-append">
<div class="input-group-text" id="effective-calendar-icon">
  <i class="fa fa-calendar-alt"></i>
</div>
</div>
<span class="error-message" id="error_sale_estim_date" style="color: red;"></span>
</div>

</div>
</div>


                        <div class="col-md-4" id="hours_per_week" style="display: none;">
                          <div class="form-group">
                          <label for="average_hours_per_week">Average Hours Per Week</label>
                          <input type="number" class="form-control @error('average_hours_per_week') is-invalid @enderror"
                            id="average_hours_per_week" name="average_hours_per_week" value="{{ old('average_hours_per_week', $EmployeeComperisation->average_hours_per_week ?? '') }}" placeholder="0.00">
                          @error('average_hours_per_week')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                          </div>
                          Salaried employees work for 44, 40 or 37.5 hours per week.

                        </div>
                        <!-- </div> -->
                        </div>

                        <div class="row py-20 px-10">
                        <div class="col-md-12 text-center">
                          <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
                          <button type="submit" class="add_btn">Save</button>
                        </div>
                        </div>
          </form>
          </div>
          <div class="card px-20">
        <div class="card-body1">
        <div class="tab-content">
          <!-- Active Employees Tab -->
          <div class="tab-pane active" id="activeemployee">
          <div class="col-md-12 table-responsive pad_table">
            <table id="example1" class="table table-hover text-nowrap">
            <thead>
              <tr>
              <th>Ammount</th>
              <th>Effective Date</th>
              <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
              </tr>
            </thead>
            <tbody>
            @foreach($EmployeeComperisationLIST as $employee)
                <tr>
                    <td>{{ $employee->emp_comp_salary_amount }}</td>
                    <td>{{ $employee->emp_comp_effective_date }}</td>
                    <td class="text-right">
                        <a href="{{ route('business.employee.edit', $employee->emp_id) }}">
                            <i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
            </table>
          </div>
          </div>

          </div>
        </div>
        </div>
      </div>
    </div>
    </div>

          <!-- Tax Details Tab -->

          <!-- /.tab-pane -->
          <div class="tab-pane" id="taxdetails">
          <div class="card px-20">
            <!-- card -->
            <form action="{{ route('employees.storeTaxDetails', $employee->emp_id) }}" method="POST">
            @csrf
            <div class="tab-pane" id="taxdetails">
              <div class="card px-20">
              <!-- card -->
              <div class="card-header">
                <h3 class="card-title">Federal Tax Details</h3>
              </div>
              <div class="card-body2">
                <div class="row pad-5">
                <div class="col-md-4">
                  <div class="form-group @error('emp_tax_deductions') is-invalid @enderror">
                  <label>Deductions <span class="text-danger">*</span></label>
                  <div class="d-flex">
                    <input type="number" name="emp_tax_deductions" class="form-control form-controltext"
                    placeholder="0.00"
                    value="{{ old('emp_tax_deductions', $taxDetails->emp_tax_deductions ?? '') }}">

                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                  </div>
                  @error('emp_tax_deductions')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group @error('emp_tax_dependent_amount') is-invalid @enderror">
                  <label>Dependent Amount <span class="text-danger">*</span></label>
                  <div class="d-flex">
                    <input type="number" name="emp_tax_dependent_amount"
                    value="{{ old('emp_tax_deductions', $taxDetails->emp_tax_deductions ?? '') }}"
                    class="form-control form-controltext" placeholder="0.00">

                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                  </div>
                  @error('emp_tax_dependent_amount')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group ">
                  <label>Filing Status <span class="text-danger">*</span></label>
                  <select name="emp_tax_filing_status"
                    class="form-control @error('emp_tax_filing_status') is-invalid @enderror">
                    <option value="">Select</option>
                    <option value="Single or Married filing separately" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Single or Married filing separately' ? 'selected' : '' }}>Single or Married filing separately</option>
                    <option value="Married filing jointly or Qualifying surviving spouse" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Married filing jointly or Qualifying surviving spouse' ? 'selected' : '' }}>Married filing
                    jointly or Qualifying surviving spouse</option>
                    <option value="Head of household" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Head of household' ? 'selected' : '' }}>
                    Head of household</option>
                    <option value="Nonresident Alien" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Nonresident Alien' ? 'selected' : '' }}>
                    Nonresident Alien</option>
                  </select>

                  @error('emp_tax_filing_status')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group @error('emp_tax_nra_amount') is-invalid @enderror">
                  <label>NRA Exemption Amount <span class="text-danger">*</span></label>
                  <div class="d-flex">
                    <input type="number" name="emp_tax_nra_amount"
                    value="{{ old('emp_tax_nra_amount', $taxDetails->emp_tax_nra_amount ?? '') }}"
                    class="form-control form-controltext" placeholder="0.00">

                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                  </div>
                  @error('emp_tax_nra_amount')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group @error('emp_tax_other_income') is-invalid @enderror">
                  <label>Other Income <span class="text-danger">*</span></label>
                  <div class="d-flex">
                    <input type="number" name="emp_tax_other_income"
                    value="{{ old('emp_tax_other_income', $taxDetails->emp_tax_other_income ?? '') }}"
                    class="form-control form-controltext" placeholder="0.00">

                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                  </div>
                  @error('emp_tax_other_income')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group @error('emp_tax_job') is-invalid @enderror">
                  <label>Multiple Jobs <span class="text-danger">*</span></label>

                  <select name="emp_tax_job"
                    class="form-control @error('emp_tax_job') is-invalid @enderror">
                    <option value="">Select</option>
                    <option value="Yes" {{ old('emp_tax_job', $taxDetails->emp_tax_job ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ old('emp_tax_job', $taxDetails->emp_tax_job ?? '') == 'No' ? 'selected' : '' }}>No</option>
                    <!-- <option value="Head of household" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Head of household' ? 'selected' : '' }}>Head of household</option> -->
                    <!-- <option value="Nonresident Alien" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Nonresident Alien' ? 'selected' : '' }}>Nonresident Alien</option> -->
                  </select>

                  @error('emp_tax_job')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                </div>
                <div class="modal_sub_title">State Tax Details</div>
                <div class="row pad-5">
                <div class="col-md-4">
                  <div class="form-group">
                  <label>Additional California State Tax to be withheld per pay period</label>
                  <div class="d-flex">
                    <input type="number" name="emp_tax_california_state_tax"
                    value="{{ old('emp_tax_california_state_tax', $taxDetails->emp_tax_california_state_tax ?? '') }}"
                    class="form-control form-controltext" placeholder="">
                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <label>Filing Status <span class="text-danger">*</span></label>
                  <select name="emp_tax_filing_status"
                    class="form-control @error('emp_tax_filing_status') is-invalid @enderror">
                    <option value="">Select</option>
                    <option value="Single or Married filing separately" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Single or Married filing separately' ? 'selected' : '' }}>Single or Married filing separately</option>
                    <option value="Married filing jointly or Qualifying surviving spouse" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Married filing jointly or Qualifying surviving spouse' ? 'selected' : '' }}>Married filing
                    jointly or Qualifying surviving spouse</option>
                    <option value="Head of household" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Head of household' ? 'selected' : '' }}>
                    Head of household</option>
                    <option value="Nonresident Alien" {{ old('emp_tax_filing_status', $taxDetails->emp_tax_filing_status ?? '') == 'Nonresident Alien' ? 'selected' : '' }}>
                    Nonresident Alien</option>
                  </select>

                  @error('emp_tax_california_filing_status')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <label>Total Allowances (California) <span class="text-danger">*</span></label>
                  <input type="number" name="emp_tax_california_total_allowances"
                    value="{{ old('emp_tax_california_total_allowances', $taxDetails->emp_tax_california_total_allowances ?? '') }}"
                    class="form-control @error('emp_tax_california_total_allowances') is-invalid @enderror"
                    placeholder="0.00">
                  @error('emp_tax_california_total_allowances')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <label>Non-resident Employee</label>
                  <div class="form-check">
                    <!-- <input name="emp_tax_non_resident_emp"  value="{{ old('emp_tax_non_resident_emp', $taxDetails->emp_tax_non_resident_emp ?? '') }}" class="form-check-input" type="checkbox"> -->
                    <input name="emp_tax_non_resident_emp" class="form-check-input" type="checkbox" {{ old('emp_tax_non_resident_emp', $taxDetails->emp_tax_non_resident_emp ?? false) ? 'checked' : '' }}>
                    <!-- <input name="emp_tax_california_state" class="form-check-input" type="checkbox" {{ old('emp_tax_california_state', $taxDetails->emp_tax_california_state ?? false) ? 'checked' : '' }}> -->
                    <!-- <input name="emp_tax_california_sdi" class="form-check-input" type="checkbox" {{ old('emp_tax_california_sdi', $taxDetails->emp_tax_california_sdi ?? false) ? 'checked' : '' }}> -->

                    <label class="form-check-label">Employee Has a Nonresident Certificate on File</label>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <label>California State Tax</label>
                  <div class="form-check">
                    <input name="emp_tax_california_state" class="form-check-input" type="checkbox" {{ old('emp_tax_california_state', $taxDetails->emp_tax_california_state ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label">Employee is Exempt</label>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <label>California SDI</label>
                  <div class="form-check">
                    <input name="emp_tax_california_sdi" class="form-check-input" type="checkbox" {{ old('emp_tax_california_sdi', $taxDetails->emp_tax_california_sdi ?? false) ? 'checked' : '' }}>

                    <label class="form-check-label">Employee is Exempt</label>
                  </div>
                  </div>
                </div>
                </div>
                <div class="row py-20 px-10">
                <div class="col-md-12 text-center">
                  <a href="{{ route('business.employee.index') }}" type="button"
                  class="add_btn_br">Cancel</a>
                  <button type="submit" class="add_btn">Save</button>
                </div>
                </div>
              </div>
              <!-- /.card -->
              </div>
            </div>
            </form>
          </div>
          </div>



          <div class="tab-pane" id="employmentstatus">
          <div class="card px-20">
            <div class="card-header">
            <h3 class="card-title">Status : <span>{{ $employee->emp_status == 1 ? 'Active' : '' }}</span></h3>
            </div>
            <div class="card-body">
            <div class="row align-items-center justify-content-between">
              <div class="col-auto d-flex">
              <p class="mb-0 mr-2 font_18">Active Since :</p>
              <p class="mb-0 font_18">{{$employee->created_at}}</p>
              </div>
              <div class="col-auto d-flex">
              <p class="mb-0 mr-2 font_18">Wage Type :</p>
              <p class="mb-0 font_18">{{$employee->emp_wage_type}}</p>
              </div>
            </div>
            </div>
          </div>
          <div class="card px-20">
            <div class="card-header">
            <h3 class="card-title">Status : <span>{{ $employee->emp_status == 1 ? 'Active' : '' }}</span></h3>
            </div>
            <div class="card-body2">
            <div class="card-box">
              <div class="row align-items-center justify-content-between">
              <div class="col-auto">
                <p class="mb-0 font_18">For Employee Resignations or Dismissals</p>
              </div>
              <div class="col-auto">
                <button class="add_btn" data-toggle="modal" data-target="#startoffboarding">Start
                Offboarding</button>
              </div>
              </div>
            </div>
            <div class="card-box">
              <div class="row align-items-center justify-content-between">
              <div class="col-auto">
                <p class="mb-0 font_18">For Employees You're Taking Off Active Payroll</p>
              </div>
              <div class="col-auto">
                <button class="add_btn" data-toggle="modal" data-target="#placeonleave">Place On
                Leave</button>
              </div>
              </div>
            </div>
            <div class="card-box">
              <div class="row align-items-center justify-content-between">

              <div class="col-auto">
                <p class="mb-0 font_18">Only For Employees Who Have Not Worked Hours Yet</p>
              </div>
              <div class="col-auto">
                <button class="delete_btn" data-toggle="modal"
                data-target="#deleteemployee-{{ $employee->emp_id }}">Delete</button>
              </div>
              </div>
            </div>
            </div>
          </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
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
  <div class="modal fade" id="startoffboarding" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Start Offboarding</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('employee.offboarding.store', $employee->emp_id) }}" method="POST">
        @csrf
        <div class="row pxy-15 px-10">
        <div class="col-md-12">
          <div class="form-group">
          <label>Why Is This Employment Ending?</label>
          <select class="form-control" name="emp_off_ending" id="emp_off_ending" style="width: 100%;">
            <option default>Select Type</option>
            <option>Resignation</option>
            <option>Dismissal With Cause</option>
            <option>Dismissal Without Cause</option>
            <option>Other</option>
          </select>
          </div>
        </div>
        <!-- <div class="col-md-6">
        <div class="form-group">
        <label for="vendor">Last Day Of Work <span class="text-danger">*</span></label>
        <div class="input-group date" id="lastdate" data-target-input="nearest">
        <input type="text" name="emp_off_last_work_date" class="form-control datetimepicker-input" placeholder="" data-target="#lastdate">
        <!-- <input type="date" name="emp_off_last_work_date" class="form-control" required> --

        <div class="input-group-append" data-target="#lastdate" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
        </div>
        </div>
        </div>
      </div> -->
        <div class="col-md-6">
          <div class="form-group @error('emp_off_last_work_date') is-invalid @enderror">
          <label for="vendor">Last Day Of Work <span class="text-danger">*</span></label>

          <div class="input-group date" id="lastdate" data-target-input="nearest">

            <x-flatpickr id="d-datepicker" name="emp_off_last_work_date" placeholder="Select a date" />
            <div class="input-group-append">
            <div class="input-group-text" id="d-calendar-icon">
              <i class="fa fa-calendar-alt"></i>
            </div>
            </div>
          
          </div>
          @error('emp_off_last_work_date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>
        </div>
        <!-- </div> -->
        <!-- <div class="col-md-6">
        <div class="form-group">
        <label for="vendor">Date Of Notice <span class="text-danger">*</span></label>
        <div class="input-group date" id="noticedate" data-target-input="nearest">
        <input type="text" name="emp_off_notice_date" class="form-control datetimepicker-input" placeholder="" data-target="#noticedate">
        <div class="input-group-append" data-target="#noticedate" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
        </div>
        </div>
        </div>
      </div>
      </div> -->

        <!-- </div> -->
        <div class="col-md-6">
          <div class="form-group @error('emp_off_notice_date') is-invalid @enderror">
          <label for="vendor">Date Of Notice <span class="text-danger">*</span></label>

          <div class="input-group date" id="noticedate" data-target-input="nearest">

            <x-flatpickr id="d-datepicker" name="emp_off_notice_date" placeholder="Select a date" />
            <div class="input-group-append">
            <div class="input-group-text" id="d-calendar-icon">
              <i class="fa fa-calendar-alt"></i>
            </div>
            </div>
          
          </div>
          @error('emp_off_notice_date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
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
  </div>
  <!-- <div class="modal fade" id="placeonleave" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Place On Leave</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <form>
      <div class="row pxy-15 px-10">
      <div class="col-md-6">
        <div class="form-group">
        <label for="vendor">Start Date <span class="text-danger">*</span></label>
        <div class="input-group date" id="leavestartdate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" placeholder=""
        data-target="#leavestartdate">
        <div class="input-group-append" data-target="#leavestartdate" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
        </div>
        </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
        <label for="vendor">End Date <span class="text-danger">*</span></label>
        <div class="input-group date" id="leaveenddate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" placeholder=""
        data-target="#leaveenddate">
        <div class="input-group-append" data-target="#leaveenddate" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
        </div>
        </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" rows="3" placeholder=""></textarea>
        </div>
      </div>
      </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
      <button type="submit" class="add_btn">Save</button>
      </div>
    </div>
    </div>
    </div> -->
  <!-- Updated modal form -->
  <div class="modal fade" id="placeonleave" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Place On Leave</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <!-- Form to submit data -->
      <form action="{{ route('employee.offboarding.leave', ['emp_id' => $employee->emp_id]) }}" method="POST">
        @csrf
        <div class="row pxy-15 px-10">
        <div class="col-md-6">
          <div class="form-group">
          <!-- <label for="leavestartdate">Start Date <span class="text-danger">*</span></label> -->
          <label for="vendor">Start Date <span class="text-danger">*</span></label>

          <div class="input-group date" id="emp_lev_start_date" data-target-input="nearest">

            <x-flatpickr id="d-datepicker" name="emp_lev_start_date" placeholder="Select a date" />
            <div class="input-group-append">
            <div class="input-group-text" id="d-calendar-icon">
              <i class="fa fa-calendar-alt"></i>
            </div>
            </div>
          </div>
          @error('emp_lev_start_date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
          <!-- <label for="leaveenddate">End Date <span class="text-danger">*</span></label> -->
          <label for="vendor">End Date <span class="text-danger">*</span></label>

          <div class="input-group date" id="emp_lev_end_date" data-target-input="nearest">

            <x-flatpickr id="d-datepicker" name="emp_lev_end_date" placeholder="Select a date" />
            <div class="input-group-append">
            <div class="input-group-text" id="d-calendar-icon">
              <i class="fa fa-calendar-alt"></i>
            </div>
            </div>
          </div>
          @error('emp_lev_end_date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
          <label for="description">Description</label>
          <textarea name="emp_lev_desc" class="form-control" rows="3" placeholder="Description"></textarea>
          </div>
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





  <div class="modal fade" id="deleteemployee-{{ $employee->emp_id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body pad-1 text-center">
      <i class="fas fa-solid fa-trash delete_icon"></i>
      <p class="company_business_name px-10"><b>Delete Employee</b></p>
      <p class="company_details_text px-10">
        Are You Sure You Want To Delete This Employee? The Information You Have
        Set Up Will Be Deleted Immediately And You Won't Be Able To Undo This.
      </p>

      <!-- Delete Form -->
      <form action="{{ route('business.employee.destroy', $employee->emp_id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
        <button type="submit" class="delete_btn px-15">Delete</button>
      </form>
      </div>
    </div>
    </div>
  </div>

  </div>
  <!-- ./wrapper -->
  <!-- /.content-wrapper -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioYes = document.getElementById('radioYes');
        const radioNo = document.getElementById('radioNo');
        const message1 = document.getElementById('message1');
        const message2 = document.getElementById('message2');

        // Function to adjust the position of messages
        function adjustMessages() {
            if (radioYes.checked) {
                // Show message2 under message1
                message1.insertAdjacentElement('afterend', message2);
            } else if (radioNo.checked) {
                // Restore message2 under radioNo
                radioNo.parentElement.insertAdjacentElement('afterend', message2);
            }
        }

        // Initialize message positioning on page load
        adjustMessages();

        // Add event listeners for radio button changes
        radioYes.addEventListener('change', adjustMessages);
        radioNo.addEventListener('change', adjustMessages);
    });
</script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const wageTypeSelect = document.getElementById('emp_wage_type');
        const workHoursContainer = document.getElementById('work-hours-container');
        const workHoursInput = document.getElementById('emp_work_hours');

        function toggleWorkHoursField() {
            if (wageTypeSelect.value === 'Annual') {
                workHoursContainer.style.display = 'block';
                workHoursInput.setAttribute('required', 'required');
            } else {
                workHoursContainer.style.display = 'none';
                workHoursInput.removeAttribute('required');
            }
        }

        // Initialize on page load
        toggleWorkHoursField();

        // Listen for changes in the wage type dropdown
        wageTypeSelect.addEventListener('change', toggleWorkHoursField);
    });
</script>

  <script>
    function toggleSalary() {
    const salaryElement = document.getElementById('Salary');
    const toggleBtn = document.getElementById('toggleBtn');

    // Check if the salary is currently visible
    if (salaryElement.innerText === "$••••••••/{{$employee->emp_wage_type}}") {
      // If salary is hidden, show it and change the button text to "Hide"
      salaryElement.innerText = "${{$employee->emp_wage_amount}}/{{$employee->emp_wage_type}}";
      toggleBtn.innerText = "Hide";
    } else {
      // If salary is visible, hide it and change the button text to "Show"
      salaryElement.innerText = "$••••••••/{{$employee->emp_wage_type}}";
      toggleBtn.innerText = "Show";
    }
    }


    document.addEventListener('DOMContentLoaded', function () {

    var fromdatepicker = flatpickr("#d-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "m/d/Y",
      altFormat: "d/m/Y",
      allowInput: true,
    });



    document.getElementById('d-calendar-icon').addEventListener('click', function () {
      fromdatepicker.open();
    });

    




    });
  </script>

  <style>
    .hide_show_btn {
    z-index: 9999;
    /* Ensure buttons are above other elements */
    cursor: pointer;
    /* Ensure buttons show pointer on hover */
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    var fromInput = document.getElementById('from-datepicker-hidden');
    var effective = document.getElementById('effective-datepicker-hidden');
    // var toInput = document.getElementById('to-datepicker-hidden');
// alert(effective);
    // console.log('From Input Value:', fromInput ? fromInput.value : 'No value');
    // console.log('To Input Value:', toInput ? toInput.value : 'No value');

    if (fromInput) {
      var fromdatepicker = flatpickr("#from-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "m/d/Y",
      altFormat: "m/d/Y",
      allowInput: true,
      defaultDate: fromInput.value || null,
      });

    
    // var toInput = document.getElementById('to-datepicker-hidden');
 
    // console.log('From Input Value:', fromInput ? fromInput.value : 'No value');
    // console.log('To Input Value:', toInput ? toInput.value : 'No value');


      // var todatepicker = flatpickr("#to-datepicker", {
      //   locale: 'en',
      //     altInput: true,
      //     dateFormat: "m/d/Y",
      //     altFormat: "m/d/Y",
      //     allowInput: true,
      //     defaultDate: toInput.value || null,
      // });

      document.getElementById('from-calendar-icon').addEventListener('click', function () {
      fromdatepicker.open();
      });

    
      // document.getElementById('to-calendar-icon').addEventListener('click', function() {
      //     todatepicker.open(); 
      // });


    } else {
      console.error('Hidden input elements not found or have no value');
    }

    if (effective) {
      var effectivedatepicker = flatpickr("#effective-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "m/d/Y",
      altFormat: "m/d/Y",
      allowInput: true,
      defaultDate: effective.value || null,
      });

      document.getElementById('effective-calendar-icon').addEventListener('click', function () {
        effectivedatepicker.open();
      });

    }

    });


  </script>
  <script>
    function toggleSalaryForm() {
    var form = document.querySelector('.editsalarybox');
    var isHidden = form.style.display === 'none';

    // Toggle display
    form.style.display = isHidden ? 'block' : 'none';
    }
  </script>
  <script>
    document.getElementById('emp_comp_salary_type').addEventListener('change', function () {
    var salaryType = this.value;
    var hoursField = document.getElementById('hours_per_week');

    if (salaryType === 'Annual') {
      hoursField.style.display = 'block';  // Show the hours per week field
    } else {
      hoursField.style.display = 'none';   // Hide the hours per week field
    }
    });
  </script>
<script>
  document.addEventListener('DOMContentLoaded', function() {

// Get references to the elements
var wageTypeSelect = document.getElementById('emp_wage_type');
var workHoursContainer = document.getElementById('work-hours-container');
var vacationPolicySelect = document.getElementById('emp_vacation_policy');
var accrualRateContainer = document.getElementById('accrual_rate_container');

// Function to toggle work hours visibility based on wage type
function toggleWorkHoursField() {
    if (wageTypeSelect.value === 'Annual') {
        workHoursContainer.style.display = 'block';
    } else {
        workHoursContainer.style.display = 'none';
    }
}

// Function to toggle accrual rate visibility based on vacation policy
function toggleAccrualRateField() {
    if (vacationPolicySelect.value === '2') {  // Change condition as needed
        accrualRateContainer.style.display = 'block';  // Show the accrual rate field
    } else {
        accrualRateContainer.style.display = 'none';  // Hide the accrual rate field
    }
}

// Initialize visibility on page load
toggleWorkHoursField();
toggleAccrualRateField();

// Listen for changes in wage type
wageTypeSelect.addEventListener('change', toggleWorkHoursField);

// Listen for changes in vacation policy
vacationPolicySelect.addEventListener('change', toggleAccrualRateField);
});

</script>
  @endsection
@endif
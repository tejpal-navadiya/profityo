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
        <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
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
    <div class="content px-10">
    <div class="container-fluid">

      <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
      @php
    $activeTab = session('activeTab', 'personalinformation'); // Default to 'personalinformation'
@endphp

<ul class="nav nav-pills p-2 tab_box">
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'personalinformation' ? 'active' : '' }}" href="#personalinformation" data-toggle="tab">
            Personal Information
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'compensation' ? 'active' : '' }}" href="#compensation" data-toggle="tab">
            Compensation
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'vacation' ? 'active' : '' }}" href="#vacation" data-toggle="tab">
            Vacation
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'taxdetails' ? 'active' : '' }}" href="#taxdetails" data-toggle="tab">
            Tax Details
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'benefits' ? 'active' : '' }}" href="#benefits" data-toggle="tab">
            Benefits & Deductions
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'empfiles' ? 'active' : '' }}" href="#empfiles" data-toggle="tab">
            Employee Files
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $activeTab == 'employmentstatus' ? 'active' : '' }}" href="#employmentstatus" data-toggle="tab">
            Employment Status
        </a>
    </li>
</ul>

      </div><!-- /.card-header -->

      <div class="tab-content">
      <div class="tab-pane {{ $activeTab == 'personalinformation' ? 'active' : '' }}" id="personalinformation">
        <div class="card px-20">
        <div class="card-header">
          <h3 class="card-title">Personal Information</h3>
        </div>


        <class="card-body2">
          <div class="row pad-5">
          <div class="col-md-4">
            <form id="items-form" action="{{ route('business.employee.update', $employee->emp_id) }}"
            method="POST">
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
              value="{{ old( 'emp_social_security_number', $employee->emp_social_security_number ? '***-**-****' : '') }}"
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
     
      <div class="tab-pane {{ $activeTab == 'compensation' ? 'active' : '' }}" id="compensation">
        <div class="card px-20">
          <div class="card-header">
            <h3 class="card-title">Compensation</h3>
          </div>
          <div class="card-body">
            <div class="row align-items-center justify-content-between">
              <div class="col-auto d-flex">
                <!-- Salary displayed as a paragraph -->
                <p id="Salary-{{ $employee->id }}" class="font_18 mb-0">
                    ${{$employee->emp_wage_amount}}/{{$employee->emp_wage_type}}
                </p>
                <!-- Button for showing/hiding salary -->
                <button id="toggleBtn-{{ $employee->id }}" onclick="toggleSalary('{{ $employee->id }}', '{{ $employee->emp_wage_amount }}', '{{ $employee->emp_wage_type }}')" class="hide_show_btn">
                    Hide
                </button>
              </div>


              <div class="col-auto">
                <button id="edit_salary" class="reminder_btn" onclick="toggleSalaryForm()">Change Salary</button>
              </div>
            </div>
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
                        id="salaryamount" name="emp_comp_salary_amount" placeholder="0.00"
                        value="{{ old('emp_comp_salary_amount', $EmployeeComperisation->emp_comp_salary_amount ?? '') }}">
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
                        <option value="Hourly" {{ old('emp_comp_salary_type', $EmployeeComperisation->emp_comp_salary_type ?? '') == 'Hourly' ? 'selected' : '' }}>Hourly
                        </option>
                        <option value="Annual" {{ old('emp_comp_salary_type', $EmployeeComperisation->emp_comp_salary_type ?? '') == 'Annual' ? 'selected' : '' }}>Annual
                        </option>
                      </select>
                      @error('emp_comp_salary_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group @error('emp_comp_effective_date') is-invalid @enderror">
                    <label for="emp_comp_effective_date">Effective Date </label>

                    <div class="input-group date" id="estimatedate" data-target-input="nearest">

                      <input type="hidden" id="effective-datepicker-hidden"
                      value="{{ $EmployeeVacation->emp_comp_effective_date ?? ''}}" />

                      @php
                        $saleEstimDate = \Carbon\Carbon::parse($EmployeeVacation->emp_comp_effective_date ?? '')->format('m/d/Y');
                        @endphp

                      <x-flatpickr id="effective-datepicker" name="emp_comp_effective_date"
                      placeholder="Select a date" :value="$saleEstimDate" />
                      <div class="input-group-append">
                      <div class="input-group-text" id="effective-calendar-icon">
                        <i class="fa fa-calendar-alt"></i>
                      </div>
                      </div>
                    
                    </div>
                    @error('emp_comp_effective_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="emp_comp_effective_date">Effective Date</label>
                      <div class="input-group date" id="estimatedate" data-target-input="nearest">
                        <input type="hidden" id="effective-datepicker-hidden"
                              value="{{ $EmployeeComperisation->emp_comp_effective_date ?? '' }}" />

                          @php
                              $saleEstimDate = $EmployeeComperisation 
                                  ? \Carbon\Carbon::parse($EmployeeComperisation->emp_comp_effective_date)->format('m/d/Y') 
                                  : '';
                          @endphp

                        <x-flatpickr id="effective-datepicker" name="emp_comp_effective_date"
                                    placeholder="Select a date" :value="$saleEstimDate" />
                        <div class="input-group-append">
                            <div class="input-group-text" id="effective-calendar-icon">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                        </div>
                      </div>
                      @error('emp_comp_effective_date')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-4" id="hours_per_week" style="display: none;">
                    <div class="form-group">
                      <label for="average_hours_per_week">Average Hours Per Week</label>
                        <input type="number" class="form-control @error('average_hours_per_week') is-invalid @enderror"
                          id="average_hours_per_week" name="average_hours_per_week"
                          value="{{ old('average_hours_per_week', $EmployeeComperisation->average_hours_per_week ?? '') }}"
                          placeholder="0.00">
                        @error('average_hours_per_week')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    Salaried employees work for 44, 40 or 37.5 hours per week.

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
        <div class="card px-20">
          <div class="card-body1">
            <div class="tab-content">
              <div class="tab-pane active" id="activeemployee">
                <div class="col-md-12 table-responsive pad_table">
                <table id="example1" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Amount</th>
                      <th>Effective Date</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($EmployeeComperisationLIST as $employee)
                      <tr>
                        <td id="SalaryTd-{{ $employee->id }}" data-hidden="{{ $employee->emp_comp_salary_amount }}">
                          ${{ $employee->emp_comp_salary_amount }}
                        </td>         
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

      <!-- Vacation -->
      
      <div class="tab-pane {{ $activeTab == 'vacation' ? 'active' : '' }}" id="vacation">
        <div class="card px-20">
          <div class="card-header">
            <h3 class="card-title">Vacation</h3>
          </div>
          <div class="card-body">
            <div class="row align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <p class="font-weight-bold mb-0 me-2">
                    Vacation balance: {{ number_format($Employeevacationbalance->balance ?? 0.0, 2) }}
                </p>
                <!-- Edit Button to Trigger Modal -->
                <a data-toggle="modal" data-target="#editVacationBalanceModal">
                <!-- <a href="#" class="text-primary" data-bs-toggle="modal"  data-bs-target="#editVacationBalanceModal"> -->
                <i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                <!-- Vacation Balance Modal -->
                <div class="modal fade" id="editVacationBalanceModal" tabindex="-1" aria-labelledby="editVacationBalanceModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <!-- Modal Header -->
                      <div class="modal-header">
                          <h5 class="modal-title" id="editVacationBalanceModalLabel">Edit Vacation Balance</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <!-- Modal Body -->
                      <div class="modal-body">
                        <div class="pad-1">
                          <div class="alert alert-warning d-flex align-items-center mb-0" role="alert">
                            <i class="fas fa-exclamation-triangle danger-icon-e"></i>
                            Ensure that you're meeting the minimum vacation time requirements in your jurisdiction when editing the balance.
                          </div>
                        </div>
                        <!-- Form Start -->
                        <form action="{{ route('employees.storeVacationbalance', $employee->emp_id) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          
                          <!-- Vacation Balance Input -->
                          <div class="row px-3">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="vacationBalance">Vacation Balance:</label>
                                <div class="input-group">
                                  <input type="text" class="form-control form-controltext" id="vacationBalance" name="balance" value=" {{ number_format($Employeevacationbalance->balance ?? 0.0, 2) }}" required>
                                  <span class="input-group-text form-selectcurrency">hrs</span>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Info Text -->
                          <div class="pad-1">
                            <p class="text-muted mb-0">The balance will be effective as soon as you save changes.</p>
                          </div>

                          <!-- Modal Footer -->
                          <div class="modal-footer">
                            <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="add_btn">Save</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end vacation -->
              </div>
              <div class="col-auto">
                <button id="vacation_policy" class="reminder_btn" onclick="toggleVacationForm()">Change Vacation
                Policy</button>
              </div>
            </div>
            <!-- Form is hidden by default -->
            <div class="editvacationbox mt-3" style="display: none;">
              <form action="{{ route('employees.storeVacation', $employee->emp_id) }}" method="POST">
                @csrf
                @method('Patch')
                <input type="hidden" name="emp_id" value="{{ $employee->emp_id }}">

                <!-- Three fields in one row -->
                <div class="row mt-3">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Vacation Policy <span class="text-danger">*</span></label>
                      <select class="form-control" name="emp_vacation_policy" id="emp_vacation_policy2">
                        @foreach($vacation as $policy)
                          <option value="{{ $policy->v_id }}" {{ old('emp_vacation_policy', $EmployeeVacation->emp_vacation_policy) == $policy->v_id ? 'selected' : '' }}>
                          {{ $policy->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('emp_vacation_policy')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group @error('emp_comp_effective_date') is-invalid @enderror">
                      <label for="emp_comp_effective_date">Effective Date</label>
                      <div class="input-group date" id="estimatedate" data-target-input="nearest">
                          <input type="hidden" id="effective-datepicker-hidden"
                          value="{{ $EmployeeVacation->emp_comp_effective_date ?? ''}}" />
                                @php
                          $saleEstimDate = \Carbon\Carbon::parse($EmployeeVacation->emp_comp_effective_date ?? '')->format('m/d/Y');
                          @endphp 
                          <x-flatpickr id="effective-datepicker" name="emp_comp_effective_date"
                          placeholder="Select a date" :value="$saleEstimDate" />
                          <div class="input-group-append">
                            <div class="input-group-text" id="effective-calendar-icon">
                              <i class="fa fa-calendar-alt"></i>
                            </div>
                          </div>
                        <span class="error-message" id="error_sale_estim_date" style="color: red;"></span>
                      </div>
                    </div>
                  </div>

                  <!-- <div class="col-md-4" id="accrual_rate2_container"
                    style="display: {{ old('emp_vacation_policy', $EmployeeVacation->emp_vacation_policy) == '2' ? 'block' : 'none' }};">
                    <div class="form-group">
                    <label>Vacation Accrual Rate</label>
                    <input type="number" min="0" class="form-control" name="emp_vacation_accural_rate"
                      id="emp_vacation_accural_rate"
                      value="{{ old('emp_vacation_accural_rate', $EmployeeVacation->emp_vacation_accural_rate) }}">
                    <small class="form-text text-muted">
                      e.g. 4% of regular hours on a 40 hour/week payroll period translates to 80 hours/year.
                    </small>
                    </div>
                  </div> -->
                  <div class="col-md-4" id="accrual_rate_container">
                    <div class="form-group">
                      <label>Vacation Accrual Rate</label>
                      <div class="input-group">
                          <input type="number" min="0" class="form-control" name="emp_vacation_accural_rate"
                        id="emp_vacation_accural_rate"
                        value="{{ old('emp_vacation_accural_rate', $EmployeeVacation->emp_vacation_accural_rate) }}">
                          <div class="input-group-append">
                              <div class="input-group-text"><i class="fa fa-percent"></i></div>
                          </div>
                      </div>
                      <small id="accrual_message" class="form-text text-muted">e.g. 4% of regular hours on a 40 hour/week payroll period translates to 80 hours/year.</small>
                    </div>
                  </div>
                </div>
                <!-- Buttons below fields -->
                <div class="row mt-4">
                  <div class="col-md-12 text-center">
                    <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
                    <button type="submit" class="add_btn">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card px-20">
          <div class="card-body2">
            <div class="tab-content">
              <!-- Active Employees Tab -->
              <div class="tab-pane active" id="activeemployee">
                <div class="col-md-12 table-responsive pad_table">
                  <!-- <table id="example1" class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                      <th>Policy</th>
                      <th>Effective Date</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                                @foreach($EmployeeVacationIST as $vacation)
                          <tr>
                          <td>
                            @if($vacation->emp_vacation_accural_rate)
                        {{ $vacation->emp_vacation_accural_rate }}% of hours are accrued each pay period
                        @if($vacation->status == 1 && \Carbon\Carbon::parse($vacation->emp_comp_effective_date)->isToday())
                      <button class="btn btn-success btn-sm">Active</button>
                          @endif
                            @else
                          Not given vacation hours
                        @endif
                          </td>

                          <td>{{ \Carbon\Carbon::parse($vacation->emp_comp_effective_date)->format('m/d/Y') }}</td>
                          <td class="text-right">
                            <a href="{{ route('business.employee.edit', $vacation->emp_id) }}">
                            <i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i>
                            </a>
                          </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table> -->
                  <table id="example1" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Policy</th>
                            <th>Effective Date</th>
                            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          // Sort the vacation records by effective date in descending order
                          $sortedVacations = $EmployeeVacationIST->sortByDesc(function($vacation) {
                              return \Carbon\Carbon::parse($vacation->emp_comp_effective_date);
                          });

                          // Check if there are any records for today
                          $hasTodayRecord = $EmployeeVacationIST->contains(function($vacation) {
                              return \Carbon\Carbon::parse($vacation->emp_comp_effective_date)->isToday();
                          });

                          // Get the most recent past date record
                          $mostRecentPastRecord = $sortedVacations->firstWhere(function($vacation) {
                              return \Carbon\Carbon::parse($vacation->emp_comp_effective_date)->isPast();
                          });
                      @endphp

                      @foreach($sortedVacations as $index => $vacation)
                          <tr>
                              <td>
                                  @if($vacation->emp_vacation_accural_rate)
                                      {{ $vacation->emp_vacation_accural_rate }}% of hours are accrued each pay period

                                      {{-- Check if there's a record for today --}}
                                      @if($hasTodayRecord)
                                          {{-- Check if it's today's date, and set status accordingly --}}
                                          @if(\Carbon\Carbon::parse($vacation->emp_comp_effective_date)->isToday())
                                              <button class="btn btn-success btn-sm">Active</button>
                                          @else
                                          
                                          @endif
                                      @else
                                          {{-- No records for today, mark the most recent past date as active --}}
                                          @if(\Carbon\Carbon::parse($vacation->emp_comp_effective_date)->isPast())
                                              @if($vacation == $mostRecentPastRecord && $vacation->status == 1)
                                                  <button class="btn btn-success btn-sm">Active</button>
                                              @else
                                                
                                              @endif
                                          @endif
                                      @endif
                                  @else
                                      Not given vacation hours
                                  @endif
                              </td>
                              <td>{{ \Carbon\Carbon::parse($vacation->emp_comp_effective_date)->format('m/d/Y') }}</td>
                              <td class="text-right">
                                  <a href="{{ route('business.employee.edit', $vacation->emp_id) }}">
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
      <!-- Tax Details Tab -->

      <!-- /.tab-pane -->
       <!-- Tax Details Tab -->

      <!-- /.tab-pane -->
      <div class="tab-pane {{ $activeTab == 'taxdetails' ? 'active' : '' }}" id="taxdetails">
        <div class="card px-20">
        <!-- card -->
        <form action="{{ route('employees.storeTaxDetails', $employee->emp_id) }}" method="POST">
          @csrf
          <div class="tab-pane" id="taxdetails">
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
                    placeholder="0.00" min="0"
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
                    class="form-control form-controltext" min="0" placeholder="0.00">

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
                    class="form-control form-controltext" min="0" placeholder="0.00">

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
                    class="form-control form-controltext" min="0" placeholder="0.00">

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

                  <select name="emp_tax_job" class="form-control @error('emp_tax_job') is-invalid @enderror">
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
                      class="form-control form-controltext" placeholder="" min="0">
                    <div class="form-control form-selectcurrency" style="width: auto;">$</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Filing Status <span class="text-danger">*</span></label>
                    <select name="emp_tax_california_filing_status"
                    class="form-control @error('emp_tax_california_filing_status') is-invalid @enderror">
                    <option value="">Select</option>
                    <option value="Single or Head of Household" {{ old('emp_tax_california_filing_status', $taxDetails->emp_tax_california_filing_status ?? '') == 'Single or Head of Household' ? 'selected' : '' }}>Single or Head of Household</option>
                    <option value="Married" {{ old('emp_tax_california_filing_status', $taxDetails->emp_tax_california_filing_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Married but use single rate" {{ old('emp_tax_california_filing_status', $taxDetails->emp_tax_california_filing_status ?? '') == 'Married but use single rate' ? 'selected' : '' }}>
                      Married but use single rate</option>
                    <!-- <option value="Nonresident Alien" {{ old('emp_tax_california_filing_status', $taxDetails->emp_tax_california_filing_status ?? '') == 'Nonresident Alien' ? 'selected' : '' }}>
                      Nonresident Alien</option> -->
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
                    placeholder="0.00" min="0">
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
                <a href="{{ route('business.employee.index') }}" type="button" class="add_btn_br">Cancel</a>
                <button type="submit" class="add_btn">Save</button>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </form>
        </div>
      </div>
      <!-- Benefits & Deductions Section -->
      <div class="tab-pane {{ $activeTab == 'benefits' ? 'active' : '' }}" id="benefits">
        <div class="card px-20">
        <div class="card-header">
          <h3 class="card-title">Benefits & Deductions</h3>
        </div>
        <div class="card-body">
          <!-- Header with Action Buttons -->
          <div class="row align-items-center justify-content-between">
          <div class="col-auto d-flex">
            <p id="Salary" class="font_18 mb-0"></p>
            <!-- <button id="toggleBtn" onclick="toggleSalary()" class="hide_show_btn"> -->
            Benefits & Deductions
            <!-- </button> -->
          </div>
          <div class="col-auto">
            <button id="add_pay" class="reminder_btn" onclick="togglePayForm()">Add to Pay</button>
            <button id="deduction" class="reminder_btn" onclick="toggleDeductionForm()">Deduct from Pay</button>
          </div>
          </div>

          <!-- Hidden Form -->
          <div class="editpaybox mt-3" style="display: none;">
          <form action="{{ route('employees.storeBenefit', $employee->emp_id) }}" method="POST">
          <input type="hidden" name="type" id="type" value='1'>
            @csrf
            @method('Patch')
            <input type="hidden" name="emp_id" value="{{ $employee->emp_id }}">

            <!-- Form Fields -->
            <div class="row mt-3">
            <div class="col-md-4">
              <div class="form-group">
              <label>Add <span class="text-danger">*</span></label>
              <select id="pay_cat_id" name="emp_pay_category" class="form-control" onchange="updateDescription()">
                <option value="">Select</option>
                @foreach ($tabs as $tab)
                          <optgroup label="{{ $tab->p_menu_title }}">
                          @foreach ($subMenus[$tab->pay_cat_id] ?? [] as $submenu)
                        <option value="{{ $submenu->pay_cat_id }}"
                        data-description="{{ $submenu->p_menu_description }}">
                        {{ $submenu->p_menu_title }}
                        </option>
                      @endforeach
                          </optgroup>
                        @endforeach
                </select>

              <!-- Description will appear here -->
                      <div id="description" class="mt-2" style="font-size: 14px; color: #666;"></div>

                      @error('emp_pay_category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
              <label for="pay_stub_label">Pay stub label<span class="text-danger">*</span></label>
              <input type="text" id="pay_stub_label" name="pay_stub_label" class="form-control"
              value="{{ old('pay_stub_label') }}" placeholder="Enter value" />
              @error('pay_stub_label')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-4" id="amount">
              <div class="form-group">
                  <label>Amount<span class="text-danger">*</span></label>
                  <input type="number" min="0" class="form-control" name="amount" id="amount" value="{{ old('amount') }}">
                  @error('amount')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
          </div>

            <div class="col-md-2">
              <div class="form-group">
              <label>Occure <span class="text-danger">*</span></label>

              <select class="form-control" name="occure" id="occure2">
                <option>Select</option>
                @foreach($occure as $policy)
          <option value="{{ $policy->occur_id }}" {{ old('occure') == $policy->occur_id ? 'selected' : '' }}>{{ $policy->name }}</option>

        @endforeach
              </select>
              @error('occure')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            </div>

            <!-- Form Buttons -->
            <div class="row mt-4">
            <div class="col-md-12 text-center">
              <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
              <button type="submit" class="add_btn">Save</button>
            </div>
            </div>
          </form>
          </div>
          <!-- deduction -->

          <!-- Hidden Form -->
          <div class="editdeductionbox mt-3" style="display: none;">
          <form action="{{ route('employees.storeBenefit', $employee->emp_id) }}" method="POST">
            <input type="hidden" name="type" id="type" value='2'>
            @csrf
            @method('Patch')
            <input type="hidden" name="emp_id" value="{{ $employee->emp_id }}">

            <!-- Form Fields -->
            <div class="row mt-3">
            <div class="col-md-4">
              <div class="form-group">
              <label>Deduct <span class="text-danger">*</span></label>
              <select id="pay_cat_id2" name="emp_pay_category" class="form-control"
                onchange="updateDeductDescription()">
                 <option value="">Select</option>
                    @foreach ($tabs2 as $tab2)
                      <optgroup label="{{ $tab2->de_menu_title }}">
                          @foreach ($subMenus2[$tab2->de_cat_id] ?? [] as $submenu2)
                            <option value="{{ $submenu2->de_cat_id }}"
                            data-description="{{ $submenu2->de_menu_description }}">
                            {{ $submenu2->de_menu_title }}
                            </option>
                          @endforeach
                    </optgroup>
                  @endforeach
              </select>

              <!-- Description will appear here -->
              <div id="description2" class="mt-2" style="font-size: 14px; color: #666;"></div>

               @error('emp_pay_category')
                <div class="invalid-feedback">{{ $message }}</div>
               @enderror
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
              <label for="pay_stub_label">Pay stub label<span class="text-danger">*</span></label>
              <input type="text" id="pay_stub_label" name="pay_stub_label" class="form-control"
              value="{{ old('pay_stub_label') }}" placeholder="Enter value" />
              @error('pay_stub_label')
                <div class="invalid-feedback">{{ $message }}</div>
               @enderror
              </div>
            </div>

            <div class="col-md-4" id="amount">
              <div class="form-group">
                  <label>Amount<span class="text-danger">*</span></label>
                  <input type="number" min="0" class="form-control" name="amount" id="amount" value="{{ old('amount') }}">
                  @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
               @enderror
                </div>
          </div>

            <div class="col-md-2">
              <div class="form-group">
              <label>Occure <span class="text-danger">*</span></label>

              <select class="form-control" name="occure" id="occure2">
                <option>Select</option>
                @foreach($occure as $policy)
                 <option value="{{ $policy->occur_id }}" {{ old('occure') == $policy->occur_id ? 'selected' : '' }}>{{ $policy->name }}</option>
               @endforeach
              </select>
              @error('occure')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
              </div>
            </div>
            </div>
            <!-- Form Buttons -->
            <div class="row mt-4">
            <div class="col-md-12 text-center">
              <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
              <button type="submit" class="add_btn">Save</button>
            </div>
            </div>
          </form>
          </div>
          @if(Session::has('benefit_delete_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('benefit_delete_success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('benefit_delete_success');
            @endphp
          @endif

          <!--  -->
          <!-- Active Section -->
          <h5 class="mt-3">Active</h5>
          <div class="table-responsive pad_table">
          <!-- <table id="example1" class="table table-hover text-nowrap">
            <thead>
            <tr>
              <th>Benefits & Deductions</th>
              <th>Amount</th>
              <th>Frequency</th>
              <th class="text-right">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($employeeBenefits as $data)
            <tr>
                <td>{{ $data->pay_stub_label }}<br>     
                <small class="text-muted">
                @if ($data->type == 1)
                    {{ $data->category->p_menu_title ?? 'N/A' }}
                @elseif ($data->type == 2)
                    {{ $data->deductcategory->de_menu_title ?? 'N/A' }}
                @else
                    N/A
                @endif
            </small>      
                <!-- <small class="text-muted">{{ $data->category->p_menu_title}}</small> --
                </td>
                <td>(${{ $data->amount }})</td>
                <td>{{ $data->occures->name }}</td>
                <td class="text-right">
                <a data-toggle="modal" data-target="#delete-role-modal-{{ $data->emp_benefit_id  }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                </td>
            </tr>
            <div class="modal fade" id="delete-role-modal-{{ $data->emp_benefit_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <form id="delete-plan-form" action="{{ route('business.employee.benefitdestroy', ['emp_benefit_id' => $data->emp_benefit_id]) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <div class="modal-body pad-1 text-center">
                                        <i class="fas fa-solid fa-trash delete_icon"></i>
                                        <p class="company_business_name px-10"><b>This action cannot be reverted</b></p>
                                        <p class="company_details_text px-10"> You are permanently removing this deduction.</p>
                                        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete_btn px-15">Delete</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
          
        @endforeach
            </tbody>
          </table> -->
          <table id="example1" class="table table-hover text-nowrap">
      <thead>
          <tr>
              <th>Benefits & Deductions</th>
              <th>Amount</th>
              <th>Frequency</th>
              <th class="text-right">Actions</th>
          </tr>
      </thead>
    <tbody>
        <!-- Active Section -->
        <tr>
            <th colspan="4">Active</th>
        </tr>
        @foreach ($employeeBenefits as $data)
            @if ($data->created_at->toDateString() >= now()->toDateString())
                <tr>
                    <td>{{ $data->pay_stub_label }}<br>
                        <small class="text-muted">
                            @if ($data->type == 1)
                                {{ $data->category->p_menu_title ?? 'N/A' }}
                            @elseif ($data->type == 2)
                                {{ $data->deductcategory->de_menu_title ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </small>
                    </td>
                    <td>(${{ $data->amount }})</td>
                    <td>{{ $data->occures->name }}</td>
                    <td class="text-right">
                        <!-- Delete Button -->
                        <a data-toggle="modal" data-target="#delete-role-modal-{{ $data->emp_benefit_id }}">
                            <i class="fas fa-solid fa-trash delete_icon_grid"></i>
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach

        <!-- Expired Section -->
        <tr>
            <th colspan="4">Expired</th>
        </tr>
        @php
            $expiredBenefits = $employeeBenefits->filter(function ($data) {
                return $data->created_at->toDateString() < now()->toDateString();
            });
        @endphp

        @if ($expiredBenefits->isEmpty())
            <tr>
                <td colspan="4">
                    <p>There are no expired benefits or deductions for this employee</p>
                </td>
            </tr>
        @else
            @foreach ($expiredBenefits as $data)
                <tr>
                    <td>{{ $data->pay_stub_label }}<br>
                        <small class="text-muted">
                            @if ($data->type == 1)
                                {{ $data->category->p_menu_title ?? 'N/A' }}
                            @elseif ($data->type == 2)
                                {{ $data->deductcategory->de_menu_title ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </small>
                    </td>
                    <td>(${{ $data->amount }})</td>
                    <td>{{ $data->occures->name }}</td>
                    <td class="text-right">
                        <!-- Delete Button -->
                        <a data-toggle="modal" data-target="#delete-role-modal-{{ $data->emp_benefit_id }}">
                            <i class="fas fa-solid fa-trash delete_icon_grid"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<!-- Delete Confirmation Modals -->
@foreach ($employeeBenefits as $data)
<div class="modal fade" id="delete-role-modal-{{ $data->emp_benefit_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('business.employee.benefitdestroy', ['emp_benefit_id' => $data->emp_benefit_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body pad-1 text-center">
                    <i class="fas fa-solid fa-trash delete_icon"></i>
                    <p class="company_business_name px-10"><b>This action cannot be reverted</b></p>
                    <p class="company_details_text px-10">You are permanently removing this deduction.</p>
                    <!-- Cancel and Delete Buttons -->
                    <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="delete_btn px-15">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

          </div>

          <!-- Expired Section -->
          <!-- <h5 class="mt-4">Expired</h5>
          <p>There are no expired benefits or deductions for this employee</p> -->
        </div>
        </div>
      </div>
      <!-- end benefit -->
<!-- empfiles -->
      <div class="tab-pane {{ $activeTab == 'empfiles' ? 'active' : '' }}" id="empfiles">

        <div class="card px-20">
        <div class="card-header">
          <h3 class="card-title">Employee File</h3>
        </div>
        <div class="card-body">
          <div class="row align-items-center justify-content-between">
          <div class="col-auto d-flex">
            <p id="Salary" class="font_18 mb-0">

            </p>
            <a>Upload History
            </a>
          </div>
          <div class="col-auto">
            <button id="emp_file" class="reminder_btn" onclick="togglefileForm()">Upload File</button>
          </div>
          </div>

          <!-- Form is hidden by default -->
          <div class="editfilebox mt-3" style="display: none;">
          <form action="{{ route('employee.file.store', $employee->emp_id) }}" method="POST" enctype="multipart/form-data">
          @csrf
            <!-- @method('POST') -->
            <input type="hidden" name="emp_id" value="{{ $employee->emp_id }}">

            <!-- Three fields in one row -->
            <!-- <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="doc_file">File name
                    </label>
                    <div>
                        <input type="file" name="image" id="image" accept="image/*" class="add_btn fileinput-button">
                        <span>25 MB file size limit</span>
                    </div>
                </div>
            </div> -->
            <div class="row mt-3">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="doc_file">File name</label>
                      <div>
                          <input type="file" name="image" id="image" class="add_btn fileinput-button">
                          <span>25 MB file size limit</span>
                      </div>
                  </div>
              </div>


            <!-- Description Input -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="2" placeholder="Enter description"></textarea>
                </div>
            </div>
        </div>

            <!-- Buttons below fields -->
            <div class="row mt-4">
            <div class="col-md-12 text-center">
              <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
              <button type="submit" class="add_btn">Save</button>
            </div>
            </div>
          </form>
          </div>

        </div>
        <!-- </div> -->
        @if(Session::has('file_delete_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('file_delete_success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('file_delete_success');
            @endphp
          @endif

        <div class="card px-20">
          <div class="card-body1">
          <div class="tab-content">
            <!-- Active Employees Tab -->
            <div class="tab-pane active" id="activeemployee">
            <div class="col-md-12 table-responsive pad_table">
              <table id="example1" class="table table-hover text-nowrap">
              <thead>
                <tr>
                <th>Description</th>
                <th>Upload On</th>
                <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($employeeFiles as $file)
              <tr>
                  <td>{{ $file->description }}</td>
                  <td>{{ $file->created_at->format('m-d-Y') }}</td>
                  <td class="text-right">
                  <a href="{{ url(env('IMAGE_URL').'/masteradmin/employee_doc/' . $file->doc_file) }}" download class="btn btn-sm btn-primary">
                      <i class="fas fa-cloud-download-alt"></i>
                  </a>

                  <a data-toggle="modal" data-target="#delete-emp-modal-{{ $file->emp_file_id  }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                </td>
            </tr>
            <div class="modal fade" id="delete-emp-modal-{{ $file->emp_file_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <form id="delete-plan-form" action="{{ route('business.employee.filedestroy', ['emp_file_id' => $file->emp_file_id]) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <div class="modal-body pad-1 text-center">
                                        <i class="fas fa-solid fa-trash delete_icon"></i>
                                        <p class="company_business_name px-10"><b>Delete File</b></p>
                                        <p class="company_details_text px-10"> Are you sure you want to delete this file?</p>
                                        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete_btn px-15">Delete</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
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
<!-- end empfiles -->
      <div class="tab-pane {{ $activeTab == 'employmentstatus' ? 'active' : '' }}" id="employmentstatus">
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
    <div class="modal fade" id="startoffboarding" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                      <input type="hidden" name="staf_start_date_range" id="startDateRange2">
                      <input type="hidden" name="staf_end_date_range" id="endDateRange2">

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
                      
                      <div class="col-md-6">
                          <div class="form-group @error('emp_off_last_work_date') is-invalid @enderror">
                              <label for="vendor">Last Day Of Work <span class="text-danger">*</span></label>
                              <div class="input-group date" id="lastdate" data-target-input="nearest">
                                  <x-flatpickr id="last-work-datepicker" name="emp_off_last_work_date" placeholder="Select a date" />
                                  <div class="input-group-append">
                                  <div class="input-group-text" id="last-work-calendar-icon">
                                  <i class="fa fa-calendar-alt"></i>
                                  </div>
                                  </div>
                              </div>
                              <small>This determines the total length of employment. This date should be the last day your employee performed work.</small>
                              @error('emp_off_last_work_date')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                      
                      <div class="col-md-6">
                          <div class="form-group @error('emp_off_notice_date') is-invalid @enderror">
                              <label for="vendor">Date Of Notice <span class="text-danger">*</span></label>
                              <div class="input-group date" id="noticedate" data-target-input="nearest">
                                  <x-flatpickr id="notice-datepicker" name="emp_off_notice_date" placeholder="Select a date" />
                                  <div class="input-group-append">
                                      <div class="input-group-text" id="notice-calendar-icon">
                                          <i class="fa fa-calendar-alt"></i>
                                      </div>
                                  </div>
                              </div>
                              <small>If no notice was given, just select when the employee exited.</small>
                              @error('emp_off_notice_date')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                      </div>
                      <div class="row pxy-15 px-10">
                        <div class="col-md-12">
                            <h6 class="font-weight-bold">See your schedule</h6>
                              <div class="start-offboarding-bgbox">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-md-6">
                                        <strong>Final Pay Period</strong>
                                        <p class="mb-0 text-muted">
                                            You’ll need to complete Timesheets up to this period.
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p id="dateRange2" class="mb-0 font-weight-bold text-right"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                          <h6 class="font-weight-bold">Set the pay</h6>
                          <div class="start-offboarding-bgbox">
                            <div class="row justify-content-between align-items-center">
                              <div class="col-md-6">
                                  <strong>Dismissal Pay</strong>
                                  <p class="mb-0 text-muted">
                                      For partial notice or in lieu of notice.
                                  </p>
                              </div>
                              <div class="dismissal-pay-div" style="display: none;">
                                  <input type="number" class="form-control" id="dismissal-pay-amount" name="amount" placeholder="0.00">
                              </div>
                              <div class="dismissal-span-div" style="display: none;">
                                  <span>Not applicable</span>
                              </div>
                            </div>
                          </div>
                          <div class="start-offboarding-bgbox">
                            <div class="row justify-content-between align-items-center">
                              <div class="col-md-6">
                                  <strong>Vacation Pay</strong>
                                  <p class="mb-0 text-muted">
                                      The remaining vacation balance will be paid out on the final payroll.
                                  </p>
                              </div>
                              <div class="col-md-6">
                                  <span>Calculated at Payroll</span>
                                  <p class="mb-0 text-muted">Don't worry, you'll review this later.</p>
                              </div>
                            </div>
                          </div>
                          <div class="start-offboarding-bgbox">
                            <div class="row justify-content-between align-items-center">
                              <div class="col-md-6">
                                <strong>Regular, Overtime, and Sick Pay</strong>
                                <p class="mb-0 text-muted">You’ll enter these hours in Timesheets.</p>
                              </div>
                              <div class="col-md-6">
                                <span>Calculated at Payroll</span>
                                <p class="mb-0 text-muted">Don't worry, you'll review this later.</p>
                              </div>
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
    </div>
 
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
        <input type="hidden" name="start_date_range" id="startDateRange">
           <input type="hidden" name="end_date_range" id="endDateRange">
        <div class="row pxy-15 px-10">
          <div class="col-md-6">
            <div class="form-group">
              <!-- <label for="leavestartdate">Start Date <span class="text-danger">*</span></label> -->
              <label for="vendor">Start Date <span class="text-danger">*</span></label>
              <div class="input-group date" id="emp_lev_start_date" data-target-input="nearest">
                <x-flatpickr id="d-datepicker" class="form-control" name="emp_lev_start_date" placeholder="Select a date" />
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
                <x-flatpickr id="End-datepicker" name="emp_lev_end_date" placeholder="Select a date" />
                <div class="input-group-append">
                  <div class="input-group-text" id="End-calendar-icon">
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
          <div class="col-md-12">
            <h6 class="font-weight-bold">See your schedule</h6>
              <div class="start-offboarding-bgbox">
                <div class="row justify-content-between align-items-center">
                  <div>
                    <p class="mb-1 font-weight-bold">Final Pay Period</p>
                    <small class="text-muted">You’ll need to complete Timesheets up to this period.</small>
                  </div>
                  <p id="dateRange" class="mb-0 font-weight-bold text-right"></p>
                </div>
                 <!-- <p id="dateRange" class="mt-3 text-muted text-center">
                  Select a date to see the week range.
                </p> -->
            </div>
          </div>
        </div>
<!-- Section: See your schedule -->
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
    function updateDeductDescription() {
    const selectElement = document.getElementById("pay_cat_id2");
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const description = selectedOption.getAttribute("data-description");

    // Update the description div for Deduct
    const descriptionDiv = document.getElementById("description2");
    descriptionDiv.textContent = description || ""; // Show description or clear if none
    }
  </script>
  <script>
    function updateDescription() {
    const selectElement = document.getElementById("pay_cat_id");
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const description = selectedOption.getAttribute("data-description");

    // Update the description div
    const descriptionDiv = document.getElementById("description");
    descriptionDiv.textContent = description || ""; // Show description or clear if none
    }
  </script>
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

  <!-- <script>
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
  </script> -->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    var salaryTypeField = document.getElementById('emp_comp_salary_type');
    var hoursField = document.getElementById('hours_per_week');
    var hoursInput = document.getElementById('average_hours_per_week'); // Input field inside hours_per_week

    // Check salary type on page load
    if (salaryTypeField.value === 'Annual') {
      hoursField.style.display = 'block'; // Show the hours per week field
    } else {
      hoursField.style.display = 'none'; // Hide the hours per week field
      if (hoursInput) {
        hoursInput.value = ''; // Clear the field value
      }
    }

    // Handle salary type change
    salaryTypeField.addEventListener('change', function () {
      if (this.value === 'Annual') {
        hoursField.style.display = 'block'; // Show the hours per week field
      } else {
        hoursField.style.display = 'none'; // Hide the hours per week field
        if (hoursInput) {
          hoursInput.value = ''; // Clear the field value
        }
      }
    });
  });
</script>
  <script>
    function toggleSalary(employeeId, wageAmount, wageType) {
        // Get the salary elements for the specific employee
        const salaryElement = document.getElementById('Salary-' + employeeId); // <p> tag
        const salaryTdElement = document.getElementById('SalaryTd-' + employeeId); // <td> tag
        const toggleBtn = document.getElementById('toggleBtn-' + employeeId); // The button
        
        // Check if salary is currently hidden by checking if the paragraph has '••••••' text
        if (salaryElement.innerText === "$••••••••/" + wageType) {
            // If hidden, show both the <p> and <td> elements with the original values
            salaryElement.innerText = "$" + wageAmount + "/" + wageType;
            salaryTdElement.innerText = "$" + salaryTdElement.getAttribute('data-hidden'); // Using the original salary value
            toggleBtn.innerText = "Hide"; // Change button text to 'Hide'
        } else {
            // If visible, hide both the <p> and <td> elements
            salaryElement.innerText = "$••••••••/" + wageType;
            salaryTdElement.innerText = "$••••••••"; // Hide the salary with the dollar sign
            toggleBtn.innerText = "Show"; // Change button text to 'Show'
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

        var fromdatepicker = flatpickr("#End-datepicker", {
          locale: 'en',
          altInput: true,
          dateFormat: "m/d/Y",
          altFormat: "d/m/Y",
          allowInput: true,
          
        });

        document.getElementById('End-calendar-icon').addEventListener('click', function () {
          fromdatepicker.open();
        });

        var fromdatepicker = flatpickr("#notice-datepicker", {
          locale: 'en',
          altInput: true,
          dateFormat: "m/d/Y",
          altFormat: "d/m/Y",
          allowInput: true,
          
        });

        document.getElementById('notice-calendar-icon').addEventListener('click', function () {
          fromdatepicker.open();
        });


        var startdatepicker = flatpickr("#last-work-datepicker", {
          locale: 'en',
          altInput: true,
          dateFormat: "m/d/Y",
          altFormat: "d/m/Y",
          allowInput: true,
          onChange: function (selectedDates, dateStr, instance) {
          const selectedDate = selectedDates[0];
          if (selectedDate) {
            const dayOfWeek = selectedDate.getDay();
  
            // Calculate Monday (start of the week)
            const monday = new Date(selectedDate);
            monday.setDate(selectedDate.getDate() - ((dayOfWeek + 6) % 7));
  
            // Calculate Sunday (end of the week)
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
  
            // Format dates
            const options = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
            const mondayStr = monday.toLocaleDateString('en-US', options).replace(',', '');
            const sundayStr = sunday.toLocaleDateString('en-US', options).replace(',', '');
  
            // Update the date range display
            document.getElementById('dateRange2').textContent = `${mondayStr} – ${sundayStr}`;
  
            // Store the date range in hidden input fields
            document.getElementById('startDateRange2').value = mondayStr;
            document.getElementById('endDateRange2').value = sundayStr;
          }
        }
        });

        document.getElementById('last-work-calendar-icon').addEventListener('click', function () {
          startdatepicker.open();
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

<!-- emp file -->
<script>
    function togglefileForm() {
    var form = document.querySelector('.editfilebox');
    var isHidden = form.style.display === 'none';

    // Toggle display
    form.style.display = isHidden ? 'block' : 'none';
    }
  </script>
  <!-- vacation -->
  <script>
    function toggleVacationForm() {
    var form = document.querySelector('.editvacationbox');
    var isHidden = form.style.display === 'none';

    // Toggle display
    form.style.display = isHidden ? 'block' : 'none';
    }
  </script>

  <!-- add pay form -->
  <script>
    function togglePayForm() {
    var payForm = document.querySelector('.editpaybox');
    var deductionForm = document.querySelector('.editdeductionbox');

    // Show the pay form and hide the deduction form
    payForm.style.display = 'block';
    deductionForm.style.display = 'none';
    }

    function toggleDeductionForm() {
    var payForm = document.querySelector('.editpaybox');
    var deductionForm = document.querySelector('.editdeductionbox');

    // Show the deduction form and hide the pay form
    deductionForm.style.display = 'block';
    payForm.style.display = 'none';
    }
    </script>

    <!-- vacation policy 2 rate  -->
   <!-- vacation policy 2 rate  -->
   <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get references to the elements
        var vacationPolicySelect = document.getElementById('emp_vacation_policy2');
        var accrualRateContainer = document.getElementById('accrual_rate_container');
        var accrualRateInput = document.getElementById('emp_vacation_accural_rate'); // Target the input field inside the container

        function toggleAccrualRateField() {
            if (vacationPolicySelect.value === '2' || vacationPolicySelect.value === '3') {
                // Show the accrual rate field for policy 2 or 3
                accrualRateContainer.style.display = 'block';
            } else {
                // Hide the accrual rate field
                accrualRateContainer.style.display = 'none';
                if (accrualRateInput) {
                    accrualRateInput.value = ''; // Clear the field value
                }
            }
        }

        // Initialize visibility on page load
        toggleAccrualRateField();

        // Listen for changes in vacation policy
        vacationPolicySelect.addEventListener('change', toggleAccrualRateField);
    });
</script>


    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

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
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const accrualRateInput = document.getElementById("emp_vacation_accural_rate");
    const accrualMessage = document.getElementById("accrual_message");
    const totalHoursInput = document.getElementById("emp_total_hours_year");
    const accrualRates = []; // Array to store multiple accrual rates for summing

    const defaultHoursPerWeek = 40; // Assuming 40 hours per week by default
    const weeksPerYear = 52;

    // Function to calculate accrual hours based on the rate
    function calculateAccrualHours(rate) {
        return (rate / 100) * defaultHoursPerWeek * weeksPerYear;
    }

    // Function to update the accrual message and hidden field
    function updateAccrualMessageAndHiddenField() {
        const rate = parseFloat(accrualRateInput.value);

        if (isNaN(rate) || rate < 0 || rate > 100) {
            accrualMessage.textContent = "e.g. 4% of regular hours on a 40-hour/week payroll period translates to 80 hours/year.";
            accrualMessage.style.color = "red";
            totalHoursInput.value = ""; // Clear the hidden field value
            return;
        }

        const annualHours = calculateAccrualHours(rate);
        accrualMessage.textContent = `e.g. ${rate}% of regular hours on a 40-hour/week payroll period translates to approximately ${annualHours.toFixed(3)} hours/year.`;
        accrualMessage.style.color = "green";
        totalHoursInput.value = annualHours.toFixed(3); // Update hidden field value

        // Push the accrual rate to the array for summing
        accrualRates.push(rate);
        displayTotalAccrual();
    }

    // Function to display the total accrual hours for all entered rates
    function displayTotalAccrual() {
        const totalAccrualRate = accrualRates.reduce((sum, rate) => sum + rate, 0);
        const totalAccrualMessage = `Total Accrual Rate: ${totalAccrualRate.toFixed(2)}%`;
        const totalAnnualHours = calculateAccrualHours(totalAccrualRate);
        
        document.getElementById("total_accrual_message").textContent = 
            `${totalAccrualMessage} (Approx. ${totalAnnualHours.toFixed(3)} hours/year)`;
    }

    // Event listener for the input change on the accrual rate
    accrualRateInput.addEventListener("input", updateAccrualMessageAndHiddenField);

    // Trigger initial calculation
    updateAccrualMessageAndHiddenField();
});
</script>
<script>
  
  document.addEventListener('DOMContentLoaded', function () {
  flatpickr('.startdate', {
    onChange: function (selectedDates, dateStr, instance) {
      const selectedDate = selectedDates[0];
      if (selectedDate) {
        const dayOfWeek = selectedDate.getDay();
        const monday = new Date(selectedDate);
        monday.setDate(selectedDate.getDate() - ((dayOfWeek + 6) % 7));
        const sunday = new Date(monday);
        sunday.setDate(monday.getDate() + 6);

        const options = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
        const mondayStr = monday.toLocaleDateString('en-US', options).replace(',', '');
        const sundayStr = sunday.toLocaleDateString('en-US', options).replace(',', '');

        document.getElementById('dateRange').textContent = `${mondayStr} – ${sundayStr}`;

        // Store the date range in hidden input fields to send to the backend
        document.getElementById('startDateRange').value = mondayStr;
        document.getElementById('endDateRange').value = sundayStr;
      }
    }
  });
});

</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ssnField = document.getElementById('employeesecuritynumber');
    
    ssnField.addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove all non-numeric characters
      if (value.length > 9) value = value.slice(0, 9); // Limit to 9 digits

      // Format as ***-**-****
      const formatted = value.replace(/^(\d{3})(\d{2})?(\d{4})?$/, (_, p1, p2, p3) => {
        if (p3) return `***-**-${p3}`;
        if (p2) return `***-**-${p2}`;
        return `***-${p1}`;
      });

      e.target.value = formatted;
    });
  });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('emp_off_ending');
        const dismissalPayDiv = document.querySelector('.dismissal-pay-div'); // Reference to the dismissal pay section

        // Function to show or hide the textbox
        const toggleTextbox = () => {
            const selectedValue = dropdown.value;
            if (
                selectedValue === 'Dismissal With Cause' || 
                selectedValue === 'Dismissal Without Cause' || 
                selectedValue === 'Other'
            ) {
                dismissalPayDiv.style.display = 'block'; // Show the textbox
            } else {
                dismissalPayDiv.style.display = 'none'; // Hide the textbox
            }
        };

        // Initialize visibility on page load
        toggleTextbox();

        // Add event listener for dropdown change
        dropdown.addEventListener('change', toggleTextbox);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('emp_off_ending');
        const dismissalPayDivspan = document.querySelector('.dismissal-span-div'); // Reference to the dismissal pay section

        // Function to show or hide the textbox
        const toggleTextbox = () => {
            const selectedValue = dropdown.value;
            if (
                selectedValue === 'Resignation'
            ) {
                dismissalPayDivspan.style.display = 'block'; // Show the textbox
            } else {
                dismissalPayDivspan.style.display = 'none'; // Hide the textbox
            }
        };

        // Initialize visibility on page load
        toggleTextbox();

        // Add event listener for dropdown change
        dropdown.addEventListener('change', toggleTextbox);
    });
</script>
    @endsection
  @endif
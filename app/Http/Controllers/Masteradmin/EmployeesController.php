<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Countries;
use App\Models\States;
use App\Models\Employees;
use App\Models\EmployeeTaxDetails;
use Carbon\Carbon;
use App\Models\VacationPolicy;
use App\Models\EmployeeComperisation;
use App\Models\EmployeeStartOffboarding;
use App\Models\EmployeePlaceLeave;
use App\Models\VacationHistory;
use App\Models\EmployeeBenefitOccure;
use App\Models\EmployeeBenefitDeduction;
use App\Models\EmployeeFile;
use App\Models\EmplayeeVacationBalance;



use Illuminate\Support\Facades\DB;  // Add this to use DB facade

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    //
    public function index(): View
    {
        $employees = Employees::all(); // This will fetch all employees, adjust the query if needed

    // Pass the employee data to the view
    return view('masteradmin.payroll_employee.index', compact('employees'));
    }
    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        // $State = States::all(); // Fetch all states
        $State = States::orderBy('name', 'asc')->get(); // Order by name ascending

        $vacation = VacationPolicy::whereIn('v_id', [1, 2])->get();
         // Fetch vacation policies dynamically based on emp_vacation_policy
  
        return view('masteradmin.payroll_employee.add', compact('Country', 'State','vacation'));
    }

    
    
   
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::guard('masteradmins')->user();
    
        // Validate request data
        $request->validate([
            'emp_first_name' => 'required|string|max:255',
            'emp_last_name' => 'nullable|string|max:255',
            'emp_social_security_number' => 'required|string|max:255',
            'emp_hopy_address' => 'nullable|string|max:255',
            'city_name' => 'nullable|string|max:255',
            'state_id' => 'nullable|numeric',
            'zipcode' => 'nullable|string|max:255',
            'emp_dob' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dob = Carbon::parse($value);
                    $age = $dob->diffInYears(Carbon::now());
                    if ($age < 10) {
                        $fail('The employee must be at least 10 years old.');
                    }
                },
            ],
            'emp_email' => 'nullable|email|max:255',
            'emp_doh' => 'required|string|max:255',
            'emp_work_location' => 'required|string|max:255',
            'emp_wage_type' => 'required|string|max:255',
            'emp_wage_amount' => 'required|string|max:255',
            'emp_work_hours' => 'nullable|numeric', // Ensure emp_work_hours is numeric
            'emp_status' => 'nullable|string|max:255',
            'emp_direct_deposit' => 'required|in:1,0',
            'emp_vacation_policy' => 'required|exists:py_vacation_policy,v_id',
            'emp_vacation_accural_rate' => 'nullable|numeric',
            'emp_total_hours_year' => 'nullable|numeric',
        ], [
            'emp_first_name.required' => 'Please enter first name.',
            'emp_last_name.required' => 'Please enter last name.',
            'emp_social_security_number.required' => 'Please enter social security number.',
            'emp_wage_amount.required' => 'Please enter wage amount.',
            'emp_dob.required' => 'Please enter date of birth.',
            'emp_doh.required' => 'Please enter DOH.',
            'emp_work_location.required' => 'Please enter work location.',
            'emp_wage_type.required' => 'Please enter wage type.',
            'emp_direct_deposit.required' => 'Please select direct deposit option.',
        ]);
    
        // Calculate emp_total_hours_year if emp_work_hours is provided
        // $annualHours = $request->input('emp_work_hours') ? $request->input('emp_work_hours') * 52 : null;
    
        // Prepare the data for insertion
        $validatedData = $request->all();
        $validatedData['id'] = $user->id;
        $validatedData['emp_status'] = 1;
        $validatedData['emp_direct_deposit'] = $request->input('emp_direct_deposit');
        $validatedData['emp_vacation_policy'] = $request->input('emp_vacation_policy');
        $validatedData['emp_vacation_accural_rate'] = $request->input('emp_vacation_accural_rate');
        $validatedData['emp_total_hours_year'] = $request->input('emp_total_hours_year');;
    
        // Insert the data into the Employees table
        $employee = Employees::create([
            'emp_first_name' => $validatedData['emp_first_name'],
            'emp_last_name' => $validatedData['emp_last_name'],
            'emp_social_security_number' => $validatedData['emp_social_security_number'],
            'emp_hopy_address' => $validatedData['emp_hopy_address'],
            'city_name' => $validatedData['city_name'],
            'state_id' => $validatedData['state_id'],
            'zipcode' => $validatedData['zipcode'],
            'emp_dob' => $validatedData['emp_dob'],
            'emp_email' => $validatedData['emp_email'],
            'emp_work_hours' => $validatedData['emp_work_hours'],
            'emp_doh' => $validatedData['emp_doh'],
            'emp_work_location' => $validatedData['emp_work_location'],
            'emp_wage_type' => $validatedData['emp_wage_type'],
            'emp_wage_amount' => $validatedData['emp_wage_amount'],
            'id' => $validatedData['id'],
            'emp_status' => $validatedData['emp_status'],
            'emp_direct_deposit' => $validatedData['emp_direct_deposit'],
            'emp_vacation_policy' => $validatedData['emp_vacation_policy'],
            'emp_vacation_accural_rate' => $validatedData['emp_vacation_accural_rate'],
            'emp_total_hours_year' => $validatedData['emp_total_hours_year'],
        ]);
    dd($employee);
        // Insert salary-related data into EmployeeComperisation table
        EmployeeComperisation::create([
            'emp_id' => $employee->id,
            'id' => $user->id,
            'emp_comp_salary_amount' => $validatedData['emp_wage_amount'],
            'emp_comp_salary_type' => $validatedData['emp_wage_type'],
            'emp_comp_effective_date' => $validatedData['emp_doh'],
            'average_hours_per_week' => $validatedData['emp_work_hours'],
            'emp_comp_status' => 1,
        ]);
      // Determine status based on effective date
      $effectiveDate = Carbon::parse($validatedData['emp_doh']);
      $status = $effectiveDate->isPast() || $effectiveDate->isToday() ? 1 : 0;
        // Insert vacation-related data into VacationHistory table
        VacationHistory::create([
            'emp_id' => $employee->id,
            'emp_vacation_policy' => $validatedData['emp_vacation_policy'],
            'emp_vacation_accural_rate' => $validatedData['emp_vacation_accural_rate'],
            'emp_comp_effective_date' => $validatedData['emp_doh'],
            'status' => $status,
        ]);
    
        \MasterLogActivity::addToLog('Employee details created.');
    
        return redirect()->route('business.employee.index')->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
    }

    public function edit($id): View
{

    
    $employee = Employees::where('emp_id' , $id)->firstOrFail();
    // Fetch countries and states for dropdowns
    $Country = Countries::all(); 
    $State = States::orderBy('name', 'asc')->get(); // Order by name ascending
    $taxDetails=EmployeeTaxDetails::where('emp_id', $id)->first();
    $EmployeeComperisation = EmployeeComperisation::where('emp_id' , $id)->first();
    $EmployeeComperisationLIST = EmployeeComperisation::where('emp_id' , $id)->get();
    $EmployeeVacationIST = VacationHistory::where('emp_id' , $id)->get();
    // $EmployeeVacation = VacationHistory::where('emp_id' , $id) ->orderBy('id', 'asc')->first();
    $Employeevacationbalance = EmplayeeVacationBalance::where('emp_id' , $id)->first();
   // Fetch the employee's compensation history based on the given conditions
    $EmployeeVacation = VacationHistory::where('emp_id', $id)
        ->whereDate('emp_comp_effective_date', Carbon::now()) // Check if a current date record exists
        ->first();
    if (!$EmployeeVacation) {
        // If no current date record exists, fetch the most recent past date record
        $EmployeeVacation = VacationHistory::where('emp_id', $id)
        ->where('emp_comp_effective_date', '<=', Carbon::now())  // Only include dates before or equal to now
        ->orderBy('emp_comp_effective_date', 'desc')  // Get the most recent record
        ->first();
    }
    if ($EmployeeVacation && $EmployeeVacation->emp_vacation_policy == 1) {
        $vacation = VacationPolicy::all();
    } else {
        // Fetch only the first two policies if the policy value is not 1
        $vacation = VacationPolicy::whereIn('v_id', [1, 2])->get();
    }
    $occure = EmployeeBenefitOccure::all();
    $tabs = DB::table('emp_pay_category')
    ->where('p_menu_status', 1)
    ->whereIn('p_menu_id', [0]) // Assuming 0=Expenses, 1=Assets, 2=Liabilities, 3=Income, 4=Equity
    ->get();
    $subMenus = DB::table('emp_pay_category')
    ->where('p_menu_status', 1)
    ->whereIn('p_menu_id', [0, 1, 2, 3, 4, 5,6])
    ->get()
    ->groupBy('p_menu_id'); 

    $tabs2 = DB::table('emp_deduction_tax')
    ->where('de_menu_status', 1)
    ->whereIn('de_menu_id', [0]) // Assuming 0=Expenses, 1=Assets, 2=Liabilities, 3=Income, 4=Equity
    ->get();
    $subMenus2 = DB::table('emp_deduction_tax')
    ->where('de_menu_status', 1)
    ->whereIn('de_menu_id', [0, 1, 2, 3, 4, 5,6])
    ->get()
    ->groupBy('de_menu_id'); 
    $employeeBenefits = EmployeeBenefitDeduction::where('emp_id', $id)
    ->with(['category', 'deductcategory', 'occures'])
    ->orderBy('created_at', 'desc')
    ->get();
    // dd($employeeBenefits);
    $employeeFiles = EmployeeFile::where('emp_id' , $id)->get();
    session()->flash('activeTab',  'personalinformation');

    return view('masteradmin.payroll_employee.edit', compact( 'Employeevacationbalance','employeeFiles','employeeBenefits','occure','tabs2','subMenus2','tabs','subMenus','EmployeeVacation','EmployeeVacationIST','vacation', 'employee', 'Country', 'State','taxDetails','EmployeeComperisation','EmployeeComperisationLIST'));
}

public function update(Request $request, $id)
{
    $user = Auth::guard('masteradmins')->user();

    // Dynamically fetch the employee record
    $employeeModel = Employees::where(['emp_id' => $id, 'id' => $user->id])->firstOrFail();

    // Validate the request data
    $validatedData = $request->validate([
        'emp_first_name' => 'nullable|string|max:255',
        'emp_last_name' => 'nullable|string|max:255',
        'emp_social_security_number' => 'required|string|max:255',
        'emp_hopy_address' => 'nullable|string|max:255',
        'city_name' => 'nullable|string|max:255',
        'state_id' => 'nullable|numeric',
        'zipcode' => 'nullable|string|max:255',
        'emp_dob' => 'required|date',
        'emp_email' => 'nullable|email|max:255',
        'emp_work_hours' => 'nullable|string|max:255',
        'emp_work_location' => 'required|string|max:255',
        'emp_wage_type' => 'required|string|max:255',
        'emp_wage_amount' => 'required|numeric|min:0',
        'emp_vacation_policy' => 'nullable|exists:py_vacation_policy,v_id', // Assuming this is the ID of the selected vacation policy
        'emp_vacation_accural_rate' => 'nullable|numeric',  // Optional field
        'emp_direct_deposit' => 'required|in:1,0', // Non-boolean type, 1 or 0
    ], [
        'emp_social_security_number.required' => 'Please enter social security number.',
        'emp_wage_amount.required' => 'Please enter wage amount.',
        'emp_dob.required' => 'Please enter date of birth.',
        'emp_work_location.required' => 'Please enter work location.',
        'emp_wage_type.required' => 'Please enter wage type.',
        'emp_direct_deposit.required' => 'Please select direct deposit option.',
    ]);

    // Prepare the validated data for update
    $updateData = [
        'emp_first_name' => $request->input('emp_first_name'),
        'emp_last_name' => $request->input('emp_last_name'),
        'emp_social_security_number' => $request->input('emp_social_security_number'),
        'emp_hopy_address' => $request->input('emp_hopy_address'),
        'city_name' => $request->input('city_name'),
        'state_id' => $request->input('state_id'),
        'zipcode' => $request->input('zipcode'),
        'emp_dob' => $request->input('emp_dob'),
        'emp_email' => $request->input('emp_email'),
        'emp_work_hours' => $request->input('emp_work_hours'),
        'emp_work_location' => $request->input('emp_work_location'),
        'emp_wage_type' => $request->input('emp_wage_type'),
        'emp_wage_amount' => $request->input('emp_wage_amount'),
        'emp_vacation_policy' => $request->input('emp_vacation_policy'),
        'emp_vacation_accural_rate' => $request->input('emp_vacation_accural_rate'),
        'emp_direct_deposit' => $request->input('emp_direct_deposit'), // Non-boolean, use 1 or 0
    ];

    // Update the employee data
    $employee = $employeeModel->where(['emp_id' => $id])->update($validatedData);

    // Check if update was successful
    if (!$employee) {
        return redirect()->route('business.employee.index')->withErrors('Employee not found.');
    }

    // Log the activity
    \MasterLogActivity::addToLog('Employee is edited.');

    // Redirect back with success message
    return redirect()->route('business.employee.index')->with(['employee-edit' => __('messages.masteradmin.employee.edit_success')]);
}



public function storeCompensation(Request $request, $id)
{
    $user = Auth::guard('masteradmins')->user();

    $request->validate([
        'emp_comp_salary_amount' => 'required|numeric',
        'emp_comp_salary_type' => 'required|string',
        'emp_comp_effective_date' => [
            'required',
            'string',
            function ($attribute, $value, $fail) use ($id) {
                $existingCompensation = EmployeeComperisation::where('emp_id', $id)
                    ->where('emp_comp_effective_date', $value)
                    ->first();

                if ($existingCompensation) {

                    $fail('Effective date is already used with another salary.');
                    session()->flash('activeTab', 'compensation');

                }
            },
        ],
        'average_hours_per_week' => 'nullable|numeric',
    ], [
        'emp_comp_salary_amount.required' => 'Please enter salary amount.',
        'emp_comp_salary_type.required' => 'Please select a salary type.',
        'emp_comp_effective_date.required' => 'Please enter an effective date.',
    ]);

    EmployeeComperisation::create([
        'emp_id' => $id,
        'id' => $user->id,
        'emp_comp_salary_amount' => $request->emp_comp_salary_amount,
        'average_hours_per_week' => $request->average_hours_per_week,
        'emp_comp_salary_type' => $request->emp_comp_salary_type,
        'emp_comp_effective_date' => $request->emp_comp_effective_date,
        'emp_comp_status' => 1,
    ]);

    \MasterLogActivity::addToLog('Employee compensation is saved.');
   
    session()->flash('activeTab', 'compensation');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}



public function storeVacation(Request $request, $id)
{
    // Debugging: Display incoming request data
    // dd($request->all());

    $request->validate([
        'emp_vacation_policy' => 'required|numeric',
        'emp_vacation_accural_rate' => 'nullable|string',
        'emp_comp_effective_date' => 'nullable|string', // Make effective date nullable
    ]);

    // Use the effective date in its existing `m/d/Y` format
    $effectiveDate = $request->emp_comp_effective_date;

    // Debugging: Check the effective date
    // dd($effectiveDate);

    // Check if a record exists with the same `emp_comp_effective_date` for the employee
    $existingVacation = VacationHistory::where('emp_id', $id)
        ->where('emp_comp_effective_date', $effectiveDate) // Use exact string match
        ->first();

    if ($existingVacation) {
        // Update the existing record
        $existingVacation->update([
            'emp_vacation_policy' => $request->emp_vacation_policy,
            'emp_vacation_accural_rate' => $request->emp_vacation_accural_rate,
        ]);

        \MasterLogActivity::addToLog('Employee vacation updated.');
    } else {
        // Create a new record
        VacationHistory::create([
            'emp_id' => $id,
            'emp_vacation_policy' => $request->emp_vacation_policy,
            'emp_vacation_accural_rate' => $request->emp_vacation_accural_rate,
            'emp_comp_effective_date' => $effectiveDate,
            'status' => 1,
        ]);

        \MasterLogActivity::addToLog('Employee vacation saved as a new record.');
    }

    session()->flash('activeTab', 'vacation');

    return redirect()->back()->with([
        'employee-add' => __('messages.masteradmin.employee.send_success')
    ]);
}



public function storeTaxDetails(Request $request, $emp_id)
{
    $user = Auth::guard('masteradmins')->user();

    // Validate the form data
    $request->validate([
        'emp_tax_deductions' => 'required|numeric',
        'emp_tax_dependent_amount' => 'required|numeric',
        'emp_tax_filing_status' => 'required|string',
        'emp_tax_nra_amount' => 'required|numeric',
        'emp_tax_other_income' => 'required|numeric',
        'emp_tax_job' => 'required|string',
        'emp_tax_california_total_allowances' => 'required|numeric',
        'emp_tax_california_filing_status' => 'nullable|string',
    ],[
        'emp_tax_deductions.required' => 'Please enter tax deductions.',
        'emp_tax_dependent_amount.required' => 'Please enter dependent amount.',
        'emp_tax_filing_status.required' => 'Please enter filing status.',
        'emp_tax_nra_amount.required' => 'Please enter nra amount.',
        'emp_tax_other_income.required' => 'Please enter other income.',
        'emp_tax_job.required' => 'Please enter tax job.',
        'emp_tax_california_total_allowances.required' => 'Please enter total allowances.',

    ]);

    // Check if tax details exist for this employee
    $taxDetails = EmployeeTaxDetails::where('emp_id', $emp_id)->first();
   
    $data = [
        'id' => $user->id,
        'emp_id' => $emp_id,
        'emp_tax_deductions' => $request->emp_tax_deductions,
        'emp_tax_dependent_amount' => $request->emp_tax_dependent_amount,
        'emp_tax_filing_status' => $request->emp_tax_filing_status,
        'emp_tax_nra_amount' => $request->emp_tax_nra_amount,
        'emp_tax_other_income' => $request->emp_tax_other_income,
        'emp_tax_job' => $request->emp_tax_job,
        'emp_tax_california_state_tax' => $request->emp_tax_california_state_tax,
        'emp_tax_california_filing_status' => $request->emp_tax_california_filing_status,
        'emp_tax_california_total_allowances' => $request->emp_tax_california_total_allowances,
        'emp_tax_non_resident_emp' => $request->emp_tax_non_resident_emp ?? 0, // default to 0 if not checked
        'emp_tax_california_state' => $request->emp_tax_california_state ?? 0,
        'emp_tax_california_sdi' => $request->emp_tax_california_sdi ?? 0,
        'emp_tax_status' => 1,  // Assuming 1 means active
    ];

    // If tax details exist, update; otherwise, create
    if ($taxDetails) {
        $taxDetails->update($data);
    } else {
        EmployeeTaxDetails::create($data);
    }
    \MasterLogActivity::addToLog('Employee Tax details is saved.');
    session()->flash('activeTab', 'taxdetails');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}



public function storeOffboarding(Request $request, $emp_id)
{
    $user = Auth::guard('masteradmins')->user();

    // Validate the incoming request
    $request->validate([
        'emp_off_ending' => 'required|string',
        'emp_off_last_work_date' => 'required|date',
        'emp_off_notice_date' => 'required|date',
        'dismissal_amount' => 'nullable|numeric|min:0', // Validate dismissal amount
        'staf_start_date_range' => 'nullable|string',
        'staf_end_date_range' => 'nullable|string',
    ], [
        'emp_off_last_work_date.required' => 'Please enter last work date.',
        'emp_off_notice_date.required' => 'Please enter notice date.',
    ]);

    // Prepare the offboarding data
    $offboardingData = [
        'emp_id' => $emp_id,
        'id' => $user->id,
        'ct_id' => $user->ct_id,
        'emp_off_ending' => $request->emp_off_ending,
        'emp_off_last_work_date' => $request->emp_off_last_work_date,
        'emp_off_notice_date' => $request->emp_off_notice_date,
        'amount' => $request->amount, // Save dismissal amount
        'emp_date_range' => $request->staf_start_date_range . ' – ' . $request->staf_end_date_range, // Store the date range
        'emp_off_status' => 1,
    ];

    // Save the data
    EmployeeStartOffboarding::create($offboardingData);

    \MasterLogActivity::addToLog('Employee Offboarding is saved.');
    session()->flash('activeTab', 'employmentstatus');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}
public function storeLeaveData(Request $request, $emp_id)
{
    // Validation and data insertion
    $request->validate([
        'emp_lev_desc' => 'nullable|string',
        'emp_lev_start_date' => 'required|date',
        'emp_lev_end_date' => 'required|date',
        'start_date_range' => 'nullable|string',
        'end_date_range' => 'nullable|string',
    ],[
        'emp_lev_start_date.required' => 'Please enter start date.',
        'emp_lev_end_date.required' => 'Please enter end date.',
    ]);

    $user = Auth::guard('masteradmins')->user();

    $offboardingData = [
        'emp_id' => $emp_id,    
        'id' => $user->id,
        'ct_id' => $user->ct_id, 
        'emp_lev_desc' => $request->emp_lev_desc,
        'emp_lev_end_date' => $request->emp_lev_end_date,
        'emp_lev_start_date' => $request->emp_lev_start_date,
        'emp_lev_status' => 1,
        'emp_lev_date_range' => $request->start_date_range . ' – ' . $request->end_date_range, // Store the date range
    ];

    EmployeePlaceLeave::create($offboardingData);
    \MasterLogActivity::addToLog('Employee Leave Data is saved.');
    session()->flash('activeTab', 'employmentstatus');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

// benefit and deduction data

public function storeBenefitDeduction(Request $request, $emp_id)
{
    
    $request->validate([
        'emp_pay_category' => 'required|string',
        'pay_stub_label' =>   'required|numeric',
        'amount' => 'required|numeric',
        'occure'=> 'required|string',
      
    ],[
        'emp_pay_category.required' => 'Please enter category.',
        'pay_stub_label.required' => 'Please enter Pay stub label.',
        'amount.required' => 'Please enter amount.',
        'occure.required' => 'Please enter occure.',
      
    ]);

    $user = Auth::guard('masteradmins')->user();

    $offboardingData = [
        'emp_id' => $emp_id,    // Use the passed emp_id
        'id' => $user->id,
        'type' => $request->type, 
        'emp_pay_category' => $request->emp_pay_category,
        'pay_stub_label' => $request->pay_stub_label,
        'amount' => $request->amount,
        'occure'=> $request->occure,
        'emp_off_status' => 1,
    ];
    EmployeeBenefitDeduction::create($offboardingData);
    \MasterLogActivity::addToLog('Employee Leave Data is saved.');
    session()->flash('activeTab', 'benefits');
    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

public function destroy($emp_id)
{
  
    $employee = Employees::where('emp_id', $emp_id)->first();

    if (!$employee) {
        return redirect()->route('business.employee.index')->withErrors('Employee not found.');
    }

    // Delete related data from all other tables
    EmployeeTaxDetails::where('emp_id', $emp_id)->delete();
    EmployeeComperisation::where('emp_id', $emp_id)->delete();
    EmployeeStartOffboarding::where('emp_id', $emp_id)->delete();
    EmployeePlaceLeave::where('emp_id', $emp_id)->delete();

    // Delete the employee record
    $employee->where('emp_id', $emp_id)->delete();
    \MasterLogActivity::addToLog('Employee Data is deleted.');

    return redirect()->route('business.employee.index')->with('delete_success', __('messages.masteradmin.employee.delete_success'));
}

public function destroyBenefitDeduction($emp_benefit_id )
{
  
    $benefit = EmployeeBenefitDeduction::where('emp_benefit_id', $emp_benefit_id)->first();
    if (!$benefit) {
        return redirect()->back()->withErrors('Benefit or deduction not found.');
    }

    // Delete the record
    $benefit->where('emp_benefit_id', $emp_benefit_id)->delete();

    // Log activity
    \MasterLogActivity::addToLog('Employee Benefit or Deduction deleted.');

    return redirect()->back()->with(['benefit_delete_success' => __('messages.masteradmin.employee.benefit_delete_success')]);
}
public function storeFile(Request $request)
{
   
    $request->validate([
        'image' => 'required|file|max:25600',
        'description' => 'nullable|string|max:255',
    ], [
        'image.required' => 'Please upload a file.',
        'description.max' => 'The description should not exceed 255 characters.',
    ]);
   
    if ($request->hasFile('image')) {
        $filePath = $this->handleImageUpload($request, $request->file('image'), 'masteradmin/employee_doc');
    }
    // Get the authenticated user
    $user = Auth::guard('masteradmins')->user();

    // Prepare the data for insertion
    $fileData = [
        'emp_id' =>  $request->emp_id,
        'id' => $user->id,
        'doc_file' => $filePath,
        'description' => $request->description,
        'emp_file_status' => 1,
    ];

    EmployeeFile::create($fileData);

    \MasterLogActivity::addToLog('Employee file data has been uploaded.');
    session()->flash('activeTab',  'empfiles');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);

}
public function destroyfile($emp_file_id)
{
    
    $empfile = EmployeeFile::where('emp_file_id', $emp_file_id )->first();
    if (!$empfile) {
        return redirect()->back()->withErrors('file not found.');
    }

    // Delete the record
    $empfile->where('emp_file_id', $emp_file_id)->delete();

    // Log activity
    \MasterLogActivity::addToLog('Employee file deleted.');
    session()->flash('activeTab',  'empfiles');

    return redirect()->back()->with(['file_delete_success' => __('messages.masteradmin.employee.file_delete_success')]);
}
public function storeVacationBalance(Request $request, $emp_id)
    {
      
        $request->validate([
            'balance' => 'required|string',
        ]);
        $user = Auth::guard('masteradmins')->user();

        // Check if the employee's vacation balance already exists
        $vacationBalance = EmplayeeVacationBalance::where('emp_id', $emp_id)->first();

        if ($vacationBalance) {
            // Update the existing record
            $vacationBalance->update([
                'balance' => $request->balance,
            ]);
        } else {
            // Insert a new record
            EmplayeeVacationBalance::create([
                'emp_id' => $emp_id,
                'id' => $user->id,
                'balance' => $request->balance,
                'emp_vb_status' => 1, // Default status (can be customized)
            ]);
        }
        \MasterLogActivity::addToLog('Vacation balance is updated.');
        // Redirect back with a success message
        session()->flash('activeTab', 'vacation');

        return redirect()->back()->with([
            'employee-add' => __('messages.masteradmin.employee.send_success')
        ]);
    }
}

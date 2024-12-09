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
        $State = States::all(); // Fetch all states
        $vacation = VacationPolicy::all();
        return view('masteradmin.payroll_employee.add', compact('Country', 'State','vacation'));
    }

    
    
    // public function store(Request $request)
    // {
        
    //     $user = Auth::guard('masteradmins')->user();
    
    //     // Validate request data
    //     $request->validate([
    //         'emp_first_name' => 'required|string|max:255',
    //         'emp_last_name' => 'nullable|string|max:255',
    //         'emp_social_security_number' => 'required|string|max:255',
    //         'emp_hopy_address' => 'nullable|string|max:255',
    //         'city_name' => 'nullable|string|max:255',
    //         'state_id' => 'nullable|numeric',
    //         'zipcode' => 'nullable|string|max:255',
    //         'emp_dob' => [
    //             'required',
    //             'date',
    //             function ($attribute, $value, $fail) {
    //                 $dob = Carbon::parse($value);
    //                 $age = $dob->diffInYears(Carbon::now());
    //                 if ($age < 10) {
    //                     $fail('The employee must be at least 10 years old.');
    //                 }
    //             },
    //         ],
    //         'emp_email' => 'nullable|email|max:255',
    //         'emp_doh' => 'required|string|max:255',
    //         'emp_work_location' => 'required|string|max:255',
    //         'emp_wage_type' => 'required|string|max:255',
    //         'emp_wage_amount' => 'required|string|max:255',
    //         'emp_work_hours' => 'nullable|string|max:255',
    //         'emp_status' => 'nullable|string|max:255',
    //         'emp_direct_deposit' => 'required|in:1,0', // Update validation rule        //    'emp_vacation_policy' => 'required|exists:py_vacation_policy,v_id', // New validation rule
    //         'emp_vacation_accural_rate' => 'nullable|numeric', // New validation rule for the accrual rate

    //     ], [
    //         'emp_first_name.required' => 'Please enter first name.',
    //         'emp_last_name.required' => 'Please enter last name.',
    //         'emp_social_security_number.required' => 'Please enter social security number.',
    //         'emp_wage_amount.required' => 'Please enter wage amount.',
    //         'emp_dob.required' => 'Please enter date of birth.',
    //         'emp_doh.required' => 'Please enter doh.',
    //         'emp_work_location.required' => 'Please enter work location.',
    //         'emp_wage_type.required' => 'Please enter wage type.',
    //         'emp_direct_deposit.required' => 'Please select direct deposit option.', // New custom message
    //         // 'emp_vacation_policy.required' => 'Please select a vacation policy.', // New custom message
    //     ]);
    
    //     // Prepare the data for insertion
    //     $validatedData = $request->all();
    //     $validatedData['id'] = $user->id; // Use the correct field name for user ID
    //     $validatedData['emp_status'] = 1;
    //     $validatedData['emp_direct_deposit'] = $request->input('emp_direct_deposit'); // Directly use the input value
    //     // Convert 'yes'/'no' to 1/0
    //     $validatedData['emp_vacation_policy'] = $request->input('emp_vacation_policy'); // Assuming this is the ID of the selected vacation policy
    //     $validatedData['emp_vacation_accural_rate'] = $request->input('emp_vacation_accural_rate'); // Get the value of the new field

    //     // Insert the data into the Employees table
    //     Employees::create([
    //         'emp_first_name' => $validatedData['emp_first_name'],
    //         'emp_last_name' => $validatedData['emp_last_name'],
    //         'emp_social_security_number' => $validatedData['emp_social_security_number'],
    //         'emp_hopy_address' => $validatedData['emp_hopy_address'],
    //         'city_name' => $validatedData['city_name'],
    //         'state_id' => $validatedData['state_id'],
    //         'zipcode' => $validatedData['zipcode'],
    //         'emp_dob' => $validatedData['emp_dob'],
    //         'emp_email' => $validatedData['emp_email'],
    //         'emp_work_hours' => $validatedData['emp_work_hours'],
    //         'emp_doh' => $validatedData['emp_doh'],
    //         'emp_work_location' => $validatedData['emp_work_location'],
    //         'emp_wage_type' => $validatedData['emp_wage_type'],
    //         'emp_wage_amount' => $validatedData['emp_wage_amount'],
    //         'id' => $validatedData['id'],
    //         'emp_status' => $validatedData['emp_status'],
    //         'emp_direct_deposit' => $validatedData['emp_direct_deposit'], // New field
    //         'emp_vacation_policy' => $validatedData['emp_vacation_policy'], // New field
    //         'emp_vacation_accural_rate' => $validatedData['emp_vacation_accural_rate'],
    //     ]);
    // // dd( $validatedData);
    //     \MasterLogActivity::addToLog('Employee is created.');
    
    //     return redirect()->route('business.employee.index')->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
    // }
    public function store(Request $request)
{
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
            'emp_work_hours' => 'nullable|string|max:255',
            'emp_status' => 'nullable|string|max:255',
            'emp_direct_deposit' => 'required|in:1,0', // Update validation rule        //    'emp_vacation_policy' => 'required|exists:py_vacation_policy,v_id', // New validation rule
            'emp_vacation_accural_rate' => 'nullable|numeric', // New validation rule for the accrual rate

        ], [
            'emp_first_name.required' => 'Please enter first name.',
            'emp_last_name.required' => 'Please enter last name.',
            'emp_social_security_number.required' => 'Please enter social security number.',
            'emp_wage_amount.required' => 'Please enter wage amount.',
            'emp_dob.required' => 'Please enter date of birth.',
            'emp_doh.required' => 'Please enter doh.',
            'emp_work_location.required' => 'Please enter work location.',
            'emp_wage_type.required' => 'Please enter wage type.',
            'emp_direct_deposit.required' => 'Please select direct deposit option.', // New custom message
            // 'emp_vacation_policy.required' => 'Please select a vacation policy.', // New custom message
        ]);
    
        // Prepare the data for insertion
        $validatedData = $request->all();
        $validatedData['id'] = $user->id; // Use the correct field name for user ID
        $validatedData['emp_status'] = 1;
        $validatedData['emp_direct_deposit'] = $request->input('emp_direct_deposit'); // Directly use the input value
        // Convert 'yes'/'no' to 1/0
        $validatedData['emp_vacation_policy'] = $request->input('emp_vacation_policy'); // Assuming this is the ID of the selected vacation policy
        $validatedData['emp_vacation_accural_rate'] = $request->input('emp_vacation_accural_rate'); // Get the value of the new field

        // Insert the data into the Employees table
        $employee =   Employees::create([
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
            'emp_direct_deposit' => $validatedData['emp_direct_deposit'], // New field
            'emp_vacation_policy' => $validatedData['emp_vacation_policy'], // New field
            'emp_vacation_accural_rate' => $validatedData['emp_vacation_accural_rate'],
        ]);

    // Insert the salary-related data into EmployeeComperisation table
    EmployeeComperisation::create([
        'emp_id' => $employee->id, // Use the newly created employee's ID
        'id' => $user->id,
        'emp_comp_salary_amount' => $validatedData['emp_wage_amount'],
        'emp_comp_salary_type' => $validatedData['emp_wage_type'],
        'emp_comp_effective_date' => $validatedData['emp_doh'],
        'average_hours_per_week' => $validatedData['emp_work_hours'],
        'emp_comp_status' => 1, // Active status or as needed
    ]);

    \MasterLogActivity::addToLog('Employee details created.');

    return redirect()->route('business.employee.index')->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

    public function edit($id): View
{

    // dd('hiii');
    // Fetch employee data by ID
    $employee = Employees::where('emp_id' , $id)->firstOrFail();
// dd($employee);
    // Fetch countries and states for dropdowns
    $Country = Countries::all(); 
    $State = States::all(); 
    $taxDetails=EmployeeTaxDetails::where('emp_tax_id', 1)->first();
    $EmployeeComperisation = EmployeeComperisation::where('emp_id' , $id)->first();
    $EmployeeComperisationLIST = EmployeeComperisation::where('emp_id' , $id)->get();
    $vacation = VacationPolicy::all();
    // dd($EmployeeComperisation);
    return view('masteradmin.payroll_employee.edit', compact('vacation', 'employee', 'Country', 'State','taxDetails','EmployeeComperisation','EmployeeComperisationLIST'));
}
// public function update(Request $request, $id)
//     {
//         $user = Auth::guard('masteradmins')->user();
//         // dd($request->all());
//         // dd($id);
//                 // Dynamically create the table name based on the user ID
//         $dynamicId = $user->user_id;
//         // $tableName = $dynamicId . '_py_employees';
//         $employeeModel = Employees::where(['emp_id' => $id, 'id' => $user->id])->firstOrFail();
// // dd($employeeModel);
//         // Validate request data
//         $validatedData = $request->validate([
//             'emp_first_name' => 'nullable|string|max:255',
//             'emp_last_name' => 'nullable|string|max:255',
//             'emp_social_security_number' => 'required|string|max:255',
//             'emp_hopy_address' => 'nullable|string|max:255',
//             'city_name' => 'nullable|string|max:255',
//             'state_id' => 'nullable|numeric',
//             'zipcode' => 'nullable|string|max:255',
//             'emp_dob' => 'required|date',
//             'emp_email' => 'nullable|email|max:255',
//             'emp_work_hours' => 'nullable|string|max:255',
//             'emp_work_location' => 'required|string|max:255',
//             'emp_wage_type' => 'required|string|max:255',
//             'emp_wage_amount' => 'required|numeric|min:0',
//         ], [
//             // 'emp_first_name.required' => 'Please enter first name.',
//             'emp_social_security_number.required' => 'Please enter social security number.',
//             'emp_wage_amount.required' => 'Please enter wage amount.',
//             'emp_dob.required' => 'Please enter date of birth.',
//             // 'emp_doh.required' => 'Please enter date of hire.',
//             'emp_work_location.required' => 'Please enter work location.',
//             'emp_wage_type.required' => 'Please enter wage type.',
//         ]);
       
//         $employee = $employeeModel->where(['emp_id' => $id])->update($validatedData);
// // dd( $validatedData);
//         if (!$employee) {
//             return redirect()->route('business.employee.index')->withErrors('Employee not found.');
//         }

       
//         \MasterLogActivity::addToLog('Employee is edited.');

//         return redirect()->route('business.employee.index')->with(['employee-edit' => __('messages.masteradmin.employee.edit_success')]);
//     }
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
    // Get the authenticated user
    $user = Auth::guard('masteradmins')->user();

    // Find the employee using the provided emp_id and ensure the correct table prefix
    // $employee = Employees::where('emp_id', $id)->firstOrFail(); // Using $id directly
    $employee = EmployeeComperisation::where('emp_id', $id)
    ->orderBy('created_at', 'desc') // Sorting by most recent
    ->get();
    // Validate compensation form fields
    $request->validate([
        'emp_comp_salary_amount' => 'required|numeric',
        'emp_comp_salary_type' => 'required|string',
        'emp_comp_effective_date' => 'required|string',
        'average_hours_per_week' => 'nullable|numeric',  // Optional if salary type is not 'Hourly'
    ], [
        'emp_comp_salary_amount.required' => 'Please enter salary amount.',
        'emp_comp_salary_type.required' => 'Please select a salary type.',
        'emp_comp_effective_date.required' => 'Please enter an effective date.',
    ]);

    // Create a new compensation record (always inserts a new record)
    EmployeeComperisation::create([
        'emp_id' => $id,  // Store the emp_id directly
        'id' => $user->id,  // Assuming you're storing the user ID
        'emp_comp_salary_amount' => $request->emp_comp_salary_amount,
        'average_hours_per_week' => $request->average_hours_per_week,
        'emp_comp_salary_type' => $request->emp_comp_salary_type,
        'emp_comp_effective_date' => $request->emp_comp_effective_date, // Ensure this is correct
        'emp_comp_status' => 1,  // Set to active or any status you prefer
    ]);

    \MasterLogActivity::addToLog('Employee compensation is saved.');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

// public function storeCompensation(Request $request, $id)
// {
// // dd($request->all());
//     // Get the authenticated user
//     $user = Auth::guard('masteradmins')->user();
    
//     // Find the employee using the provided emp_id and ensure the correct table prefix
//     $employee = Employees::where('emp_id', $id)->firstOrFail(); // Using $id directly

//     // Validate compensation form fields
//     $request->validate([
//         'emp_comp_salary_amount' => 'required|numeric',
//         'emp_comp_salary_type' => 'required|string',
//           'effective_date' => 'required|string',
//           'average_hours_per_week' => 'required|numeric',  // Uncomment if needed
//     ], [
//         'emp_comp_salary_amount.required' => 'The salary amount is required.',
//         'emp_comp_salary_type.required' => 'Please select a salary type.',
//         'effective_date.required' => 'Please provide an effective date.',
//     ]);

//     // Insert the compensation data into the EmployeeComperisation model
//    $dx = EmployeeComperisation::create([
//         'emp_id' => $id,  // Store the emp_id directly
//         'id' => $user->id,  // Assuming you're storing the user ID
//         'emp_comp_salary_amount' => $request->emp_comp_salary_amount,
//         'average_hours_per_week' => $request->average_hours_per_week,
//         'emp_comp_salary_type' => $request->emp_comp_salary_type,
//         'emp_comp_effective_date' => $request->emp_comp_effective_date, // Uncomment if needed
//         'emp_comp_status' => 1,  // Set to active or any status you prefer
//     ]);

//     // dd( $dx);
//     \MasterLogActivity::addToLog('employee is saved.');

//     return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
// }

// public function storeTaxDetails(Request $request, $emp_id)
// {
//     $user = Auth::guard('masteradmins')->user();

//     // Validate the form data
//     $request->validate([
//         'emp_tax_deductions' => 'required|numeric',
//         'emp_tax_dependent_amount' => 'required|numeric',
//         'emp_tax_filing_status' => 'required|string',
//         'emp_tax_nra_amount' => 'required|numeric',
//         'emp_tax_other_income' => 'required|numeric',
//         'emp_tax_job' => 'required|string',
//         'emp_tax_california_total_allowances' => 'required|numeric',
//         'emp_tax_california_filing_status' => 'required|string',

//         // Add other validation rules for tax details
//     ]);
   
//     // Prepare data for insertion
//     $taxDetails = [
//         // 'emp_id' => $id,  // Store the emp_id directly
//         'id' => $user->id,
//         'emp_id' => $emp_id,  // Employee ID
//         'emp_tax_deductions' => $request->emp_tax_deductions,
//         'emp_tax_dependent_amount' => $request->emp_tax_dependent_amount,
//         'emp_tax_filing_status' => $request->emp_tax_filing_status,
//         'emp_tax_nra_amount' => $request->emp_tax_nra_amount,
//         'emp_tax_other_income'=> $request->emp_tax_other_income,
//         'emp_tax_job'=> $request->emp_tax_job,
//         'emp_tax_california_state_tax'=> $request->emp_tax_california_state_tax,
//         'emp_tax_california_filing_status'=> $request->emp_tax_california_filing_status,
//         'emp_tax_california_total_allowances'=> $request->emp_tax_california_total_allowances,
//         'emp_tax_non_resident_emp'=> $request->emp_tax_non_resident_emp,
//         'emp_tax_california_state'=> $request->emp_tax_california_state,
//         'emp_tax_california_sdi'=> $request->emp_tax_california_sdi,
//         // Add other tax fields here
//         'emp_tax_status' => 1,  // Set tax status to active or any other status
//     ];

//     // Insert the tax details into the dynamic table
//     EmployeeTaxDetails::create($taxDetails);
//      \MasterLogActivity::addToLog('employee is saved.');

//     return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
// }
// app/Http/Controllers/Masteradmin/EmployeesController.php



public function storeTaxDetails(Request $request, $emp_id)
{
    // DD();
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
        'emp_tax_california_filing_status' => 'required|string',
        // Add other validation rules as needed
    ],[
        'emp_tax_deductions.required' => 'Please enter tax deductions.',
        'emp_tax_dependent_amount.required' => 'Please enter dependent amount.',
        'emp_tax_filing_status.required' => 'Please enter filing status.',
        'emp_tax_nra_amount.required' => 'Please enter nra amount.',
        'emp_tax_other_income.required' => 'Please enter other income.',
        'emp_tax_job.required' => 'Please enter tax job.',
        'emp_tax_california_filing_status.required' => 'Please enter california filing status.',
        'emp_tax_california_total_allowances.required' => 'Please enter total allowances.',

    ]);

    // Check if tax details exist for this employee
    $taxDetails = EmployeeTaxDetails::where('emp_id', $emp_id)->first();
    // dd($taxDetails);
    // Prepare data
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

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}



public function storeOffboarding(Request $request, $emp_id)
{
    // dd('aaa');
    // Get the authenticated user
    $user = Auth::guard('masteradmins')->user();
    
    // Validate request data
    $request->validate([
        'emp_off_ending' => 'required|string',
        'emp_off_last_work_date' => 'required|date',
        'emp_off_notice_date' => 'required|date',
    ],[
        'emp_off_last_work_date.required' => 'Please enter last work date.',
        'emp_off_notice_date.required' => 'Please enter notice date.',
      
    ]);

    // Prepare the data for insertion
    $offboardingData = [
        'emp_id' => $emp_id,  
        'id' => $user->id, 
        'ct_id' => $user->ct_id, 
        'emp_off_ending' => $request->emp_off_ending,
        'emp_off_last_work_date' => $request->emp_off_last_work_date,
        'emp_off_notice_date' => $request->emp_off_notice_date,
        'emp_off_status' =>1,
    ];
    // dd($offboardingData);

   
    EmployeeStartOffboarding::create($offboardingData);
    \MasterLogActivity::addToLog('Employee Offboarding is saved.');

    // Redirect back with success message
    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}
// app/Http/Controllers/Masteradmin/EmployeesController.php

public function storeLeaveData(Request $request, $emp_id)
{
    // Validation and data insertion as described in your code
    $request->validate([
        'emp_lev_desc' => 'nullable|string',
        'emp_lev_start_date' => 'required|date',
        'emp_lev_end_date' => 'required|date',
    ],[
        'emp_lev_start_date.required' => 'Please enter start date.',
        'emp_lev_end_date.required' => 'Please enter end date.',
      
    ]);

    $user = Auth::guard('masteradmins')->user();

    $offboardingData = [
        'emp_id' => $emp_id,    // Use the passed emp_id
        'id' => $user->id,
        'ct_id' => $user->ct_id, 
        'emp_lev_desc' => $request->emp_lev_desc,
        'emp_lev_end_date' => $request->emp_lev_end_date,
        'emp_lev_start_date' => $request->emp_lev_start_date,
        'emp_lev_status' => 1,
    ];

    EmployeePlaceLeave::create($offboardingData);
    \MasterLogActivity::addToLog('Employee Leave Data is saved.');

    return redirect()->back()->with(['employee-add' => __('messages.masteradmin.employee.send_success')]);
}

public function destroy($emp_id)
{
    // Find the employee by emp_id
    // dd($emp_id);
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


}

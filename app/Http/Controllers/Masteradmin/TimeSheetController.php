<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Employees;
use App\Models\EmployeeTimesheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;  // Add this to use DB facade

class TimeSheetController extends Controller
{
   
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date')
            ? Carbon::createFromFormat('m-d-Y', $request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfWeek();
    
        $endDate = $startDate->copy()->addDays(6)->endOfDay();
    
        // Fetch employees
        $hourlyEmployees = Employees::where('emp_wage_type', 'Hourly')->get();
        $salariedEmployees = Employees::where('emp_wage_type', 'Annual')->get();
    
        // Fetch and group timesheets
        $hourlyTimesheets = EmployeeTimesheet::where('type', 1)
            ->whereBetween(DB::raw("STR_TO_DATE(start_date, '%m-%d-%Y')"), [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
            ])
            ->get();
        $salariedTimesheets = EmployeeTimesheet::where('type', 2)
            ->whereBetween(DB::raw("STR_TO_DATE(start_date, '%m-%d-%Y')"), [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
            ])
            ->get();
        $groupedTimesheets = $hourlyTimesheets->groupBy('emp_id');
        $groupedSalariedTimesheets = $salariedTimesheets->groupBy('emp_id');


        // Return view with data
        return view('masteradmin.timesheet.index', [
            'hourlyEmployees' => $hourlyEmployees,
            'salariedEmployees' => $salariedEmployees,
            'hourlyCount' => $hourlyEmployees->count(),
            'salariedCount' => $salariedEmployees->count(),
            'hourlyTimesheets' => $hourlyTimesheets,
            'salariedTimesheets' => $salariedTimesheets,
            'groupedTimesheets' => $groupedTimesheets, // Pass grouped timesheets to the view
            'groupedSalariedTimesheets' => $groupedSalariedTimesheets,
        ]);
    }
    
    
    




public function store(Request $request)
{
   // dd($request->all());

    $validatedData = $request->validate([
        'hours.*.*' => 'nullable',
        'overtime.*.*' => 'nullable',
        'double_time.*.*' => 'nullable',
        'vacation.*.*' => 'nullable',
        'sick_time.*.*' => 'nullable',
        'date' => 'required|array',
        'date.*' => 'required|date',
        'type' => 'required|in:1,2', 
    ]);

    $dates = $request->input('date'); // Array of dates for the week

    if ($request->input('type') == 2) {

        $this->processSalariedEmployeeForAllDates($request, $dates);
    }

    foreach ($request->input('hours', []) as $emp_id => $days) {
      
        foreach (['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'] as $index => $day) {
           
            $date = Carbon::parse($dates[$index])->format('m-d-Y'); // Format as Y-m-d

            $hours = isset($days[$day]) ? $days[$day] : 0;
            $overtime = isset($request->input('overtime')[$emp_id][$day]) ? $request->input('overtime')[$emp_id][$day] : 0;
            $double_time = isset($request->input('doubletime')[$emp_id][$day]) ? $request->input('doubletime')[$emp_id][$day] : 0;
            $vacation = isset($request->input('vacation')[$emp_id][$day]) ? $request->input('vacation')[$emp_id][$day] : 0;
            $sick_time = isset($request->input('sicktime')[$emp_id][$day]) ? $request->input('sicktime')[$emp_id][$day] : 0;
            $emp_total = $hours + $overtime + $double_time + $vacation + $sick_time;

            $timesheetData = [
                'emp_hours' => $hours,
                'emp_overtime' => $overtime,
                'emp_doubletime' => $double_time,
                'emp_vacation' => $vacation,
                'emp_sicktime' => $sick_time,
                'emp_total' => $emp_total,
                'type' => 1, // Hourly employee
                'emp_status' => $request->input('emp_status'),
                'start_date' => $date, // Store the specific date for this entry
                'updated_at' => now(),
            ];
            // Check if a timesheet record already exists for the employee and date
            $existingRecord = EmployeeTimesheet::where('emp_id', $emp_id)
                ->where('start_date', $date)
                ->where('emp_day', $day)
                ->first();
            if ($existingRecord) {
                // Update the existing record
                $existingRecord->where('emp_id', $emp_id)
                ->where('start_date', $date)
                ->where('emp_day', $day)
                ->where('type', 1)->update($timesheetData);

            } else {
                // Insert a new record
                $timesheetData['emp_id'] = $emp_id;
                $timesheetData['emp_day'] = $day;
                $timesheetData['created_at'] = now();
                EmployeeTimesheet::create($timesheetData);
            }
        }
    }

    return redirect()->back()->with('success', 'Timesheet data saved successfully!');
}

private function processSalariedEmployeeForAllDates($request, $dates)
{
  

    foreach ($request->input('overtime', []) as $emp_id => $days) {
        foreach (['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'] as $index => $day) {
          
            $date = Carbon::parse($dates[$index])->format('m-d-Y'); // Get the date for each day
            $overtime = isset($request->input('overtime')[$emp_id][$day]) ? $request->input('overtime')[$emp_id][$day] : 0;
            $double_time = isset($request->input('doubletime')[$emp_id][$day]) ? $request->input('doubletime')[$emp_id][$day] : 0;
            $vacation = isset($request->input('vacation')[$emp_id][$day]) ? $request->input('vacation')[$emp_id][$day] : 0;
            $sick_time = isset($request->input('sicktime')[$emp_id][$day]) ? $request->input('sicktime')[$emp_id][$day] : 0;

            $emp_total =  $overtime + $double_time + $vacation + $sick_time;

            $timesheetData = [
                'emp_id' => $emp_id,
                'emp_day' => $day,
                'emp_overtime' => $overtime,
                'emp_doubletime' => $double_time,
                'emp_vacation' => $vacation,
                'emp_sicktime' => $sick_time,
                'emp_total' => $emp_total,
                'type' => 2, // Salaried employee
                'emp_status' => $request->input('emp_status'),
                'start_date' => $date, // Store the specific date for this entry
                'updated_at' => now(),
            ];
            // Check if a record already exists for this employee and date
            $existingRecord = EmployeeTimesheet::where('emp_id', $emp_id)
                ->where('emp_day', $day)
                ->where('start_date', $date)
                ->where('type', 2)
                ->first();

            if ($existingRecord) {
                // Update the existing record
                $existingRecord->where('emp_id', $emp_id)
                ->where('emp_day', $day)
                ->where('start_date', $date)
                ->where('type', 2)->update($timesheetData);
            } else {
                // Insert a new record
                EmployeeTimesheet::create($timesheetData);
            }
        }
    }
}



public function fetchTimesheetData(Request $request)
{
    // Parse the start and end dates from the request
    //dd($request->all());
      $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->startOfDay();

// Calculate the end date (7 days later)
$endDate = $startDate->copy()->addDays(6)->endOfDay();

    

    // Fetch employees and timesheets
    $hourlyEmployees = Employees::where('emp_wage_type', 'Hourly')->get();
    $salariedEmployees = Employees::where('emp_wage_type', 'Annual')->get();
    
    $hourlyTimesheets = EmployeeTimesheet::where('type', 1)
        ->whereBetween(DB::raw("STR_TO_DATE(start_date, '%m-%d-%Y')"), [
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
        ])
        ->get();
       // dd($hourlyTimesheets);
    $salariedTimesheets = EmployeeTimesheet::where('type', 2)
        ->whereBetween(DB::raw("STR_TO_DATE(start_date, '%m-%d-%Y')"), [
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
        ])
        ->get();

    // Group the timesheets
    $groupedTimesheets = $hourlyTimesheets->groupBy('emp_id');
    $groupedSalariedTimesheets = $salariedTimesheets->groupBy('emp_id');

    // Return the response as JSON
    return response()->json([
            'hourlyEmployees' => $hourlyEmployees,
            'salariedEmployees' => $salariedEmployees,
            'hourlyCount' => $hourlyEmployees->count(),
            'salariedCount' => $salariedEmployees->count(),
            'hourlyTimesheets' => $hourlyTimesheets,
            'salariedTimesheets' => $salariedTimesheets,
            'groupedTimesheets' => $groupedTimesheets, // Pass grouped timesheets to the view
            'groupedSalariedTimesheets' => $groupedSalariedTimesheets,
    ]);
}


}

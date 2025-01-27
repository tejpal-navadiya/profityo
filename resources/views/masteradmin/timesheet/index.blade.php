@extends('masteradmin.layouts.app')
<title>Profityo | Employees</title>
<style>
    .weekly-calendar {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        background-color: #fff;
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
    }

    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .calendar-header button {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #1e90ff;
    }

    .calendar-header .week-display {
        display: flex;
        align-items: center;
        gap: 10px;
        text-align: center;
        width: 100%;
        justify-content: space-around;
    }
    .calendar-header .week-display .start-date,
    .calendar-header .week-display .end-date {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .calendar-header .week-display .arrow {
        font-size: 24px;
        color: #666;
    }

    .calendar-header span {
        font-size: 14px;
        font-weight: 500;
    }

    .calendar-header span#start-day,
    .calendar-header span#end-day {
        font-size: 24px;
        font-weight: bold;
    }
</style>

@section( 'content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0">Employee Timesheet</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Timesheet</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content px-10">
        <div class="container-fluid">
            <!-- Tabs -->
            <div class="weekly-calendar">
                <div class="calendar-header">
                    <button class="prev-week" onclick="changeWeek(-1)">&#8249;</button>
                    <div class="week-display">
                        <div class="start-date">
                            <span id="start-day"></span>
                            <span id="start-month-year"></span>
                            <span id="start-weekday"></span>
                        </div>
                        <span class="arrow">→</span>
                        <div class="end-date">
                            <span id="end-day"></span>
                            <span id="end-month-year"></span>
                            <span id="end-weekday"></span>
                        </div>
                    </div>
                    <button class="next-week" onclick="changeWeek(1)">&#8250;</button>
                </div>
            </div>

            <div class="card-header d-flex justify-content-center tab_panal">
                <ul class="nav nav-pills p-2 tab_box">
                <li class="nav-item">
                    <a class="nav-link active" id="hourly-tab" data-toggle="pill" href="#hourly">
                        Hourly Employees <span class="badge badge-toes">{{ $hourlyCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="salaried-tab" data-toggle="pill" href="#salaried">
                        Salaried Employees <span class="badge badge-toes">{{ $salariedCount }}</span>
                    </a>
                </li>
            </ul>
            </div>
         
            <div class="tab-content">
                <!-- Hourly Employees Tab -->
                <!-- <div class="tab-pane active" id="hourly"> -->
                <div class="tab-pane fade show active" id="hourly">
           <!-- Hourly Employees Form -->

                    <form action="{{ route('timesheet.store') }}" method="POST">
                        <input type="hidden" name="type" id="type" value="1">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">

                            @csrf
                            <div class="card px-20">
                                <div class="card-body1">
                            
                                            <div class="table-responsive pad_table">
                                                <table class="table table-hover timesheet-table text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Employee</th>
                                                          
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="employeeTable">
                @foreach($hourlyEmployees as $employee)

                    <input type="hidden" name="emp_id" id="emp_id" value="{{ $employee->emp_id }}">

                    <tr class="employee-row" id="employee_{{ $employee->emp_id }}">
                        <td>
                            <span class="toggle">▲</span> {{ $employee->emp_first_name }}, {{ $employee->emp_last_name }}
                        </td>
                        @foreach(['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'] as $day)
                            <td>
                                <input 
                                    type="number" 
                                    name="hours[{{ $employee->emp_id }}][{{ $day }}]" 
                                    value="{{ isset($groupedTimesheets[$employee->emp_id]) ? $groupedTimesheets[$employee->emp_id]->where('emp_day', $day)->first()->emp_hours ?? '0.00' : '0.00' }}" 
                                    min="0"
                                    max="24"
                                    class="hour-input"
                                    data-employee-id="{{ $employee->emp_id }}" 
                                    data-day="{{ $day }}"
                                    style="width: 70px;">
                            </td>
                        @endforeach

                        <td class="total" id="total_{{ $employee->emp_id }}">
                        {{ 
            isset($groupedTimesheets[$employee->emp_id]) 
            ? $groupedTimesheets[$employee->emp_id]
                ->whereNotIn('type', ['overtime', 'doubletime', 'vacation', 'sicktime'])
                ->sum('emp_hours') 
            : '0.00' 
        }}

        </td>

                    </tr>

                <!-- Nested Rows for Overtime, Double Time, Vacation, Sick Time -->
                @foreach(['overtime' => 'Rate x 1.5', 'doubletime' => 'Rate x 2.0', 'vacation' => 'Balance: 0.0', 'sicktime' => 'Balance: 0.0'] as $type => $label)
            <tr class="nested-row" id="nested-row-{{ $employee->emp_id }}-{{ $type }}">
                <td>{{ ucfirst($type) }} <br><small>{{ $label }}</small></td>
                @foreach(['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'] as $day)
                    <td>
                        <input 
                            type="number" 
                            name="{{ $type }}[{{ $employee->emp_id }}][{{ $day }}]" 
                            value="{{ isset($groupedTimesheets[$employee->emp_id]) ? $groupedTimesheets[$employee->emp_id]->where('emp_day', $day)->first()->{"emp_$type"} ?? '0.00' : '0.00' }}" 
                            min="0"
                            max="24"
                            class="nested-input"
                            data-employee-id="{{ $employee->emp_id }}"
                            data-type="{{ $type }}"
                            data-day="{{ $day }}"
                            style="width: 70px;">
                    </td>
                @endforeach
                <td class="nested-total" id="nested-total-{{ $employee->emp_id }}-{{ $type }}">
                    {{ isset($groupedTimesheets[$employee->emp_id]) ? $groupedTimesheets[$employee->emp_id]->sum("emp_$type") ?? '0.00' : '0.00' }}
                </td>
            </tr>
        @endforeach

            @endforeach
</tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <!-- </div>
                            </div> -->
                            <button type="submit" class="add_btn">Save Hourly Timesheet</button>
                    </form>
                </div>

                <!-- Salaried Employees Form -->
                 
                 <div class="tab-pane fade" id="salaried">

                <form action="{{ route('timesheet.store') }}" method="POST">
                <input type="hidden" name="type" id="type" value="2">

                    @csrf
                    <div class="card px-20">
                        <div class="card-body1">
                            <!-- <div class="tab-content">
                               
                                <div class="tab-pane" id="salaried"> -->

                                    <div class="table-responsive pad_table">
                                        <table class="table table-hover timesheet-table text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Employee</th>
                                                   
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employeeSalariedTable">
                                                @foreach($salariedEmployees as $employee2)
                                                <input type="hidden" name="emp_id" id="emp_id" value="{{ $employee2->emp_id }}">

                                                    <tr class="employee-row" id="employee_{{ $employee2->emp_id }}">
                                                        <td>
                                                            <span class="toggle">▲</span> {{ $employee2->emp_first_name }}, {{ $employee2->emp_last_name }}
                                                        </td>
                                                        @foreach(['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'] as $day)
                                                            <td>
                                                                <!-- <input 
                                                                    type="text" 
                                                                    value="N/A" 
                                                                    class="form-control-plaintext text-center"
                                                                    readonly
                                                                    style="width: 70px;"
                                                                > -->
                                                            </td>
                                                        @endforeach
                                                        <td class="total" id="total_Salaried_{{ $employee2->emp_id }}">{{ 
                                                        isset($groupedSalariedTimesheets[$employee2->emp_id]) 
                                                        ? $groupedSalariedTimesheets[$employee2->emp_id]
                                                            ->whereNotIn('type', ['overtime', 'doubletime', 'vacation', 'sicktime'])
                                                            ->sum('emp_hours') 
                                                        : '0.00' 
                                                    }}</td>
                                                    </tr>

                                                    <!-- Nested Rows for Vacation, Sick Time -->
                                                    @foreach(['overtime' => 'Rate x 1.5', 'doubletime' => 'Rate x 2.0', 'vacation' => 'Balance: 0.0', 'sicktime' => 'Balance: 0.0'] as $type => $label)
                                                        <tr class="nested-row" id="nested-row-{{ $employee2->emp_id }}-{{ $type }}">
                                                            <td>{{ ucfirst($type) }} <br><small>{{ $label }}</small></td>
                                                            @foreach(['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'] as $day)
                                                                <td>
                                                                    <input 
                                                                        type="number" 
                                                                        name="{{ $type }}[{{ $employee2->emp_id }}][{{ $day }}]" 
                                                                        value="{{ isset($groupedSalariedTimesheets[$employee2->emp_id]) ? $groupedSalariedTimesheets[$employee2->emp_id]->where('emp_day', $day)->first()->{"emp_$type"} ?? '0.00' : '0.00' }}" 
                                                                        min="0"
                                                                        max="24"
                                                                        class="nested-input"
                                                                        data-employee-id="{{ $employee2->emp_id }}"
                                                                        data-type="{{ $type }}"
                                                                        data-day="{{ $day }}"
                                                                        style="width: 70px;"
                                                                    >
                                                                </td>
                                                            @endforeach
                                                            <td class="nested-total" id="nested-total-Salaried-{{ $employee2->emp_id }}-{{ $type }}">                    
                                                            {{ isset($groupedSalariedTimesheets[$employee2->emp_id]) ? $groupedSalariedTimesheets[$employee2->emp_id]->sum("emp_$type") ?? '0.00' : '0.00' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <!-- </div>
                    </div> -->
                    <button type="submit" class="add_btn">Save Salaried Timesheet</button>
                </form>
            </div> 
           </div>
        </div>
    </section>
</div>
@endsection
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            let row = this.closest('tr').nextElementSibling;
            let isHidden = false;

            // Toggle all subsequent rows with the class 'nested-row'
            while (row && row.classList.contains('nested-row')) {
                row.classList.toggle('d-none');
                isHidden = row.classList.contains('d-none');
                row = row.nextElementSibling;
            }

            // Update the toggle symbol based on visibility
            this.textContent = isHidden ? '▼' : '▲';
        });
    });
});

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

// Function to update the total for the main row (regular hours for employee)
function updateMainRowTotal(employeeId) {
    const totalElement = document.querySelector(`#total_${employeeId}`);
    // const newtotalElement = document.querySelector(`#newtotal_${employeeId}`);

    let total = 0;

    // Calculate for regular hours
    document.querySelectorAll(`input[data-employee-id="${employeeId}"][name^="hours"]`).forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    totalElement.textContent = total.toFixed(2); // Update the total in the main row
    // newtotalElement.value = total.toFixed(2); // Update the total in the main row

}

// Function to update the total for nested row (overtime, vacation, etc.)
function updateNestedRowTotal(employeeId, type) {
    const nestedTotalElement = document.querySelector(`#nested-total-${employeeId}-${type}`);
    let total = 0;

    // Calculate for nested row (overtime, vacation, etc.)
    document.querySelectorAll(`input[data-employee-id="${employeeId}"][data-type="${type}"]`).forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    nestedTotalElement.textContent = total.toFixed(2); // Update the total in the nested row
}

// Function to calculate totals when any input is changed
function recalculateTotal(e) {
    const employeeId = e.target.getAttribute('data-employee-id');
    
    if (e.target.classList.contains('hour-input')) {
        updateMainRowTotal(employeeId);
    } else if (e.target.classList.contains('nested-input')) {
        const type = e.target.getAttribute('data-type');
        updateNestedRowTotal(employeeId, type);
    }
}

// Event delegation: Listen for input changes inside the table rows
document.getElementById('employeeTable').addEventListener('input', function(e) {
    if (e.target.matches('input[data-employee-id]')) {
        recalculateTotal(e);
    }
});
});

</script>
<script>
    // Dynamically generate the route URL using Laravel's `route()` helper
    const timesheetRoute = "{{ route('timesheet.data') }}";
</script>


<script>
//    let currentDate = new Date();
// currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1); // Monday as start of the week

// // Format the date as 'MO', 'TU', etc.
// function formatDate(date) {
//     const days = ["MO", "TU", "WE", "TH", "FR", "SA", "SU"];
//     const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
//     let dayIndex = date.getDay(); // Get the day index (0 = Sunday, 1 = Monday, etc.)
//     dayIndex = (dayIndex === 0) ? 6 : dayIndex - 1; // Adjust Sunday (0) to the last index (6)
//     const day = date.getDate();
//     return `${days[dayIndex]} ${day}`;
// }

// // Update the week display and set the hidden start_date input
// function updateWeekDisplay() {
//     let startOfWeek = new Date(currentDate);
//     let endOfWeek = new Date(startOfWeek);
//     endOfWeek.setDate(startOfWeek.getDate() + 6);

//     // Update the display in the calendar
//     document.getElementById("start-day").textContent = startOfWeek.getDate();
//     document.getElementById("start-month-year").textContent = `${startOfWeek.toLocaleString('default', { month: 'long' })} ${startOfWeek.getFullYear()}`;
//     document.getElementById("start-weekday").textContent = startOfWeek.toLocaleString('default', { weekday: 'long' });

//     document.getElementById("end-day").textContent = endOfWeek.getDate();
//     document.getElementById("end-month-year").textContent = `${endOfWeek.toLocaleString('default', { month: 'long' })} ${endOfWeek.getFullYear()}`;
//     document.getElementById("end-weekday").textContent = endOfWeek.toLocaleString('default', { weekday: 'long' });

//     // Update table headers for both hourly and salaried
//     const tableHeaderRow = document.querySelectorAll(".timesheet-table thead tr");
//     tableHeaderRow.forEach((row) => {
//         row.innerHTML = `
//             <th>Employee</th>
//             ${Array.from({ length: 7 }).map((_, i) => {
//                 const date = new Date(startOfWeek);
//                 date.setDate(startOfWeek.getDate() + i);
//                 return `<th>${formatDate(date)}<input type="hidden" name="date[]" value="${date.toISOString().split('T')[0]}" /></th>`;
//             }).join("")}
//             <th>Total</th>
//         `;
//     });

//     // Create an array of all dates in the week (from startOfWeek to endOfWeek)
//     const allDates = [];
//     for (let i = 0; i < 7; i++) {
//         const date = new Date(startOfWeek);
//         date.setDate(startOfWeek.getDate() + i);
//         allDates.push(date.toISOString().split('T')[0]); // Store the date in YYYY-MM-DD format
//     }

//     // Set the hidden start_date field with the first date of the week (startOfWeek)
//     document.getElementById('start_date').value = allDates.join(","); // Set all dates as comma-separated values
// }

// // Function to change the week when navigating
// function changeWeek(direction) {
//     currentDate.setDate(currentDate.getDate() + direction * 7);
//     updateWeekDisplay();
// }

// // Initialize the week display on page load
// document.addEventListener("DOMContentLoaded", updateWeekDisplay);
let currentDate = new Date();
currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1); // Set currentDate to Monday of the current week

// Format the date to 'MO', 'TU', etc. (day of the week)
function formatDate(date) {
    const days = ["MO", "TU", "WE", "TH", "FR", "SA", "SU"];
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let dayIndex = date.getDay(); // Get the day index (0 = Sunday, 1 = Monday, etc.)
    dayIndex = (dayIndex === 0) ? 6 : dayIndex - 1; // Adjust Sunday (0) to the last index (6)
    const day = date.getDate();
    return `${days[dayIndex]} ${day}`;
}


// Fetch data via AJAX
function fetchTimesheetData(startDate, endDate) {
    fetch(timesheetRoute, { // Use the dynamically generated route URL
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ start_date: startDate, end_date: endDate }),
    })
        .then(response => response.json())
        .then(data => {
            updateTimesheetTable(data); 
        })
        .catch(error => console.error('Error fetching timesheet data:', error));
}


function updateTimesheetTable1(data) {
    const { hourlyEmployees, groupedTimesheets } = data;

    hourlyEmployees.forEach(employee => {
        const timesheet = groupedTimesheets[employee.emp_id] || [];

        // Loop over the days of the week (mo, tu, we, th, fr, sa, su)
        ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'].forEach(day => {
            // Find the timesheet entry for the specific employee and day
            const employeeTimesheet = timesheet.find(ts => ts.emp_day === day);

            // Get the hour value for the day (if found, otherwise default to '0.00')
            const hours = employeeTimesheet ? employeeTimesheet.emp_hours : '0.00';

            // Find the input field and set the value
            const inputElement = document.querySelector(`input[name="hours[${employee.emp_id}][${day}]"]`);
            if (inputElement) {
                inputElement.value = hours;
            }
        });

        // Calculate total regular hours for the employee (sum of all days)
        const totalHours = timesheet.reduce((sum, ts) => sum + parseFloat(ts.emp_hours || 0), 0);
        const totalElement = document.getElementById(`total_${employee.emp_id}`);
        if (totalElement) {
            totalElement.textContent = totalHours.toFixed(2);
        }

        // Update the nested rows for overtime, double time, vacation, and sick time
        ['overtime', 'doubletime', 'vacation', 'sicktime'].forEach(type => {
            const nestedRow = document.querySelector(`#nested-row-${employee.emp_id}-${type}`);

            // Loop over days for each type (overtime, double time, etc.)
            ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'].forEach(day => {
                const nestedTimesheet = timesheet.find(ts => ts.emp_day === day);
                const nestedHours = nestedTimesheet ? nestedTimesheet[`emp_${type}`] : '0.00';

                // Find and set the nested input field for each day
                const nestedInputElement = nestedRow.querySelector(`input[name="${type}[${employee.emp_id}][${day}]"]`);
                if (nestedInputElement) {
                    nestedInputElement.value = nestedHours;
                }
            });

            // Calculate the total for the nested type (e.g., overtime, doubletime)
            const nestedTotal = timesheet.reduce((sum, ts) => sum + parseFloat(ts[`emp_${type}`] || 0), 0);
            const nestedTotalElement = nestedRow.querySelector(`#nested-total-${employee.emp_id}-${type}`);
            if (nestedTotalElement) {
                nestedTotalElement.textContent = nestedTotal.toFixed(2);
            }
        });
    });
}

function updateTimesheetTable(data) {
    const { hourlyEmployees, salariedEmployees, groupedTimesheets, groupedSalariedTimesheets } = data;

    // Update Hourly Employees (as you already did)
    hourlyEmployees.forEach(employee => {
        const timesheet = groupedTimesheets[employee.emp_id] || [];

        // Loop over the days of the week (mo, tu, we, th, fr, sa, su)
        ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'].forEach(day => {
            // Find the timesheet entry for the specific employee and day
            const employeeTimesheet = timesheet.find(ts => ts.emp_day === day);

            // Get the hour value for the day (if found, otherwise default to '0.00')
            const hours = employeeTimesheet ? employeeTimesheet.emp_hours : '0.00';

            // Find the input field and set the value
            const inputElement = document.querySelector(`input[name="hours[${employee.emp_id}][${day}]"]`);
            if (inputElement) {
                inputElement.value = hours;
            }
        });

        // Calculate total regular hours for the employee (sum of all days)
        const totalHours = timesheet.reduce((sum, ts) => sum + parseFloat(ts.emp_hours || 0), 0);
        const totalElement = document.getElementById(`total_${employee.emp_id}`);
        if (totalElement) {
            totalElement.textContent = totalHours.toFixed(2);
        }

        // Update the nested rows for overtime, double time, vacation, and sick time
        ['overtime', 'doubletime', 'vacation', 'sicktime'].forEach(type => {
            const nestedRow = document.querySelector(`#nested-row-${employee.emp_id}-${type}`);

            // Loop over days for each type (overtime, double time, etc.)
            ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'].forEach(day => {
                const nestedTimesheet = timesheet.find(ts => ts.emp_day === day);
                const nestedHours = nestedTimesheet ? nestedTimesheet[`emp_${type}`] : '0.00';

                // Find and set the nested input field for each day
                const nestedInputElement = nestedRow.querySelector(`input[name="${type}[${employee.emp_id}][${day}]"]`);
                if (nestedInputElement) {
                    nestedInputElement.value = nestedHours;
                }
            });

            // Calculate the total for the nested type (e.g., overtime, doubletime)
            const nestedTotal = timesheet.reduce((sum, ts) => sum + parseFloat(ts[`emp_${type}`] || 0), 0);
            const nestedTotalElement = nestedRow.querySelector(`#nested-total-${employee.emp_id}-${type}`);
            if (nestedTotalElement) {
                nestedTotalElement.textContent = nestedTotal.toFixed(2);
            }
        });
    });

    // Update Salaried Employees
    salariedEmployees.forEach(employee2 => {
        const timesheet = groupedSalariedTimesheets[employee2.emp_id] || [];

        // Loop over each day (mo, tu, we, th, fr, sa, su) for salaried employees
        ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'].forEach(day => {
            const employeeTimesheet = timesheet.find(ts => ts.emp_day === day);
            const hours = employeeTimesheet ? employeeTimesheet.emp_hours : '0.00';
            const inputElement = document.querySelector(`input[name="hours[${employee2.emp_id}][${day}]"]`);
            if (inputElement) {
                inputElement.value = hours;
            }
        });

        const totalHours = timesheet.reduce((sum, ts) => sum + parseFloat(ts.emp_hours || 0), 0);
        const totalElement = document.getElementById(`total_Salaried_${employee2.emp_id}`);
        if (totalElement) {
            totalElement.textContent = totalHours.toFixed(2);
        }

        // Handle nested timesheets for overtime, doubletime, vacation, and sicktime
        ['overtime', 'doubletime', 'vacation', 'sicktime'].forEach(type => {
            const nestedRow = document.querySelector(`#nested-row-${employee2.emp_id}-${type}`);

            ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'].forEach(day => {
                const nestedTimesheet = timesheet.find(ts => ts.emp_day === day);
                const nestedHours = nestedTimesheet ? nestedTimesheet[`emp_${type}`] : '0.00';

                const nestedInputElement = nestedRow.querySelector(`input[name="${type}[${employee2.emp_id}][${day}]"]`);
                if (nestedInputElement) {
                    nestedInputElement.value = nestedHours;
                }
            });

            const nestedTotal = timesheet.reduce((sum, ts) => sum + parseFloat(ts[`emp_${type}`] || 0), 0);
            const nestedTotalElement = nestedRow.querySelector(`#nested-total-Salaried-${employee2.emp_id}-${type}`);
            if (nestedTotalElement) {
                nestedTotalElement.textContent = nestedTotal.toFixed(2);
            }
        });
    });
}


function updateWeekDisplay() {
    let startOfWeek = new Date(currentDate);
    let endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);

    const startDate = startOfWeek.toISOString().split('T')[0]; // Format: YYYY-MM-DD
    const endDate = endOfWeek.toISOString().split('T')[0];

    // Fetch data for the current week
    fetchTimesheetData(startDate, endDate);

    // Update the calendar UI
    document.getElementById("start-day").textContent = startOfWeek.getDate();
    document.getElementById("start-month-year").textContent = `${startOfWeek.toLocaleString('default', { month: 'long' })} ${startOfWeek.getFullYear()}`;
    document.getElementById("start-weekday").textContent = startOfWeek.toLocaleString('default', { weekday: 'long' });

    document.getElementById("end-day").textContent = endOfWeek.getDate();
    document.getElementById("end-month-year").textContent = `${endOfWeek.toLocaleString('default', { month: 'long' })} ${endOfWeek.getFullYear()}`;
    document.getElementById("end-weekday").textContent = endOfWeek.toLocaleString('default', { weekday: 'long' });

    // Update table headers for both hourly and salaried employees
    const tableHeaderRow = document.querySelectorAll(".timesheet-table thead tr");
    tableHeaderRow.forEach((row) => {
        row.innerHTML = `
            <th>Employee</th>
            ${Array.from({ length: 7 }).map((_, i) => {
                const date = new Date(startOfWeek);
                date.setDate(startOfWeek.getDate() + i);
                return `<th>${formatDate(date)}<input type="hidden" name="date[]" value="${date.toISOString().split('T')[0]}" /></th>`;
            }).join("")}
            <th>Total</th>
        `;
    });

    // Set the hidden input for start and end dates
    document.getElementById('start_date').value = startDate;
    document.getElementById('end_date').value = endDate;
}


// Change the week when navigating
function changeWeek(direction) {
    currentDate.setDate(currentDate.getDate() + direction * 7);
    updateWeekDisplay();
}

// Initialize the week display on page load
document.addEventListener("DOMContentLoaded", updateWeekDisplay);


    
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const startDate = new Date(currentDate);
        document.getElementById("start-date").value = startDate.toISOString().split('T')[0];
    });
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {

// Function to update the total for the main row (regular hours for employee)
function updateMainRowTotal(employeeId) {
    const totalElement = document.querySelector(`#total_Salaried_${employeeId}`);
    // const newtotalElement = document.querySelector(`#newtotal_${employeeId}`);

    let total = 0;

    // Calculate for regular hours
    document.querySelectorAll(`input[data-employee-id="${employeeId}"][name^="hours"]`).forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    totalElement.textContent = total.toFixed(2); // Update the total in the main row
    // newtotalElement.value = total.toFixed(2); // Update the total in the main row

}

// Function to update the total for nested row (overtime, vacation, etc.)
function updateNestedRowTotal(employeeId, type) {
    const nestedTotalElement = document.querySelector(`#nested-total-Salaried-${employeeId}-${type}`);
    let total = 0;

    // Calculate for nested row (overtime, vacation, etc.)
    document.querySelectorAll(`input[data-employee-id="${employeeId}"][data-type="${type}"]`).forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    nestedTotalElement.textContent = total.toFixed(2); // Update the total in the nested row
}

// Function to calculate totals when any input is changed
function recalculateTotal(e) {
    const employeeId = e.target.getAttribute('data-employee-id');
    
    if (e.target.classList.contains('hour-input')) {
        updateMainRowTotal(employeeId);
    } else if (e.target.classList.contains('nested-input')) {
        const type = e.target.getAttribute('data-type');
        updateNestedRowTotal(employeeId, type);
    }
}

// Event delegation: Listen for input changes inside the table rows
document.getElementById('employeeSalariedTable').addEventListener('input', function(e) {
    if (e.target.matches('input[data-employee-id]')) {
        recalculateTotal(e);
    }
});
});

</script>

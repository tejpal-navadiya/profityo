<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeTimesheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'emp_id',
        'emp_day',
        'emp_hours',
        'emp_overtime',
        'emp_doubletime',
        'emp_vacation',
        'emp_sicktime',
        'emp_total',
        'type',
        'start_date',
        'emp_status'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_employee_timesheet');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeStartOffboarding extends Model
{
    use HasFactory;
    protected $fillable = ['emp_id','id','ct_id','emp_off_ending','emp_off_last_work_date','emp_off_notice_date','emp_off_status','emp_date_range','amount'];
   
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_employee_start_offboarding');
    }
}

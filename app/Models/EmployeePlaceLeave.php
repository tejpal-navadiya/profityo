<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeePlaceLeave extends Model
{
    use HasFactory;
    protected $fillable = ['emp_id','id','ct_id','emp_lev_start_date','emp_lev_end_date','emp_lev_desc','emp_lev_status','emp_lev_date_range'];
   
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_employee_place_leave');
    }
}

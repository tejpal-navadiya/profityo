<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Employees extends Model
{
    use HasFactory;
    protected $fillable = ['id','emp_first_name', 'emp_last_name', 'emp_social_security_number', 'emp_hopy_address', 'city_name', 'state_id', 'zipcode', 'emp_dob', 'emp_email', 'emp_middle_initial', 'emp_doh', 'emp_work_location','emp_wage_type','emp_wage_amount','emp_status','emp_work_hours','emp_direct_deposit','emp_vacation_policy','emp_vacation_accural_rate'];
   
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_employee_details');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

}

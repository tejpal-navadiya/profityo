<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeBenefitDeduction extends Model
{
    use HasFactory;
    protected $fillable = ['emp_id','id','type','emp_pay_category','pay_stub_label','amount','occure','emp_off_status'];
   
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . 'py_employee_benefit_deduction');
    }
    public function category()
{
    return $this->belongsTo(EmployeePayCategory::class, 'emp_pay_category','pay_cat_id');
}
public function deductcategory()
{
    return $this->belongsTo(EmployeeDeductionTax::class, 'emp_pay_category','de_cat_id');
}
public function occures()
{
    return $this->belongsTo(EmployeeBenefitOccure::class, 'occure','occur_id');
}
}

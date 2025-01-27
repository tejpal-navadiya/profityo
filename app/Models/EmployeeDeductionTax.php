<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeductionTax extends Model
{
    use HasFactory;
    public $table= "emp_deduction_tax";
    protected $fillable = ['de_cat_id ','de_menu_id','de_menu_title','de_menu_description','de_menu_status'];


}

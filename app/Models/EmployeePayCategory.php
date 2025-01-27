<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayCategory extends Model
{
    use HasFactory;
    public $table= "emp_pay_category";
    protected $fillable = ['pay_cat_id ','p_menu_id','p_menu_title','p_menu_description','p_menu_status'];

    
}

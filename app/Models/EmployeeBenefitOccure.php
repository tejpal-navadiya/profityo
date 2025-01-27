<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBenefitOccure extends Model
{
    use HasFactory;
    public $table= "emp_benefit_occure";
    protected $fillable = ['occur_id','name', 'status'];
}

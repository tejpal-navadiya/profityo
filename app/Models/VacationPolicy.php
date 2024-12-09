<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VacationPolicy extends Model
{
    use HasFactory;
    public $table= "py_vacation_policy";
    protected $fillable = ['v_id','name', 'status'];

  
}

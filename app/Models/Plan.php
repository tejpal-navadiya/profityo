<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    public $table = "py_subscription_plans";
    protected $fillable = [
        'sp_name',
        'sp_amount',
        'sp_month',
        'sp_desc',
        'sp_user',
        'sp_status'
    ];

}

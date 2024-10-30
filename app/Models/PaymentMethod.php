<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentMethod extends Model
{
    use HasFactory;
    public $table = "py_payment_methods";
    protected $fillable = [
        // 'id',
        'method_name',
        'method_status',
    ];  

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);

    //     // Dynamically set the table name
    //     $userDetails = session('user_details');
    //     Auth::guard('masteradmins')->setUser($userDetails);
    //     $user = Auth::guard('masteradmins')->user();
    //     // dd($user);
    //     $uniq_id = $user->user_id;
    //     $this->setTable($uniq_id . '_py_payment_methods');
    // }
}

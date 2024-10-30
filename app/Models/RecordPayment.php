<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ChartAccount;

class RecordPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'invoice_id',
        'payment_method',
        'payment_account',
        'payment_date',
        'payment_amount',
        'notes',
        'status',
       
       
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_record_a_payment');
    }
    public function chartOfAccount()
{
    return $this->belongsTo(ChartAccount::class, 'payment_account','chart_acc_id');
}

}

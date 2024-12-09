<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Estimates extends Model
{
    use HasFactory;

    protected $fillable = ['id','sale_estim_title', 'sale_estim_summary', 'sale_cus_id', 'sale_estim_number', 'sale_estim_customer_ref', 'sale_estim_date', 'sale_estim_valid_date', 'sale_estim_discount_desc','sale_estim_discount_type','sale_currency_id', 'sale_estim_sub_total', 'sale_estim_discount_total', 'sale_estim_tax_amount', 'sale_estim_final_amount', 'sale_estim_notes', 'sale_estim_footer_note', 'sale_estim_image', 'sale_status', 'sale_estim_status'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_estimates_details');
    }

    public function customer()
    {
        return $this->belongsTo(SalesCustomers::class, 'sale_cus_id','sale_cus_id');
    }
    public function sentLogs()
{
    return $this->hasMany(SentLog::class, 'sale_estim_id', 'id');
}
public function currency()
{
    return $this->belongsTo(Countries::class, 'sale_currency_id', 'id');
}
}

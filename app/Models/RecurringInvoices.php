<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecurringInvoices extends Model
{
    use HasFactory;
    protected $fillable = ['id','sale_re_inv_title', 'sale_re_inv_summary', 'sale_cus_id', 'sale_re_inv_number', 'sale_re_inv_customer_ref', 'sale_re_inv_date', 'sale_re_inv_valid_date', 'sale_re_inv_discount_desc','sale_re_inv_discount_type','sale_currency_id', 'sale_re_inv_sub_total', 'sale_re_inv_discount_total', 'sale_re_inv_tax_amount', 'sale_re_inv_final_amount', 'sale_re_inv_notes', 'sale_re_inv_footer_note', 'sale_re_inv_image', 'sale_status', 'sale_re_inv_status','sale_re_inv_payment_due_id','sale_re_inv_item_discount'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_inv_recurring_details');
    }

    public function customer()
    {
        return $this->belongsTo(SalesCustomers::class, 'sale_cus_id','sale_cus_id');
    }

    public function sentLogs()
    {
        return $this->hasMany(SentLog::class, 'sale_re_inv_id', 'id');
    }
    public function currency()
{
    return $this->belongsTo(Countries::class, 'sale_currency_id', 'id');
}
}

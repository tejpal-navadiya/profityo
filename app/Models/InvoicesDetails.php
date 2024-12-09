<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InvoicesDetails extends Model
{
    use HasFactory;
    protected $fillable = ['id','sale_inv_title', 'sale_inv_summary', 'sale_cus_id', 'sale_inv_number', 'sale_inv_customer_ref', 'sale_inv_date', 'sale_inv_valid_date', 'sale_inv_discount_desc','sale_inv_discount_type','sale_currency_id', 'sale_inv_sub_total', 'sale_inv_discount_total', 'sale_inv_tax_amount', 'sale_inv_final_amount','sale_inv_due_amount', 'sale_inv_notes', 'sale_inv_footer_note', 'sale_inv_image', 'sale_status', 'sale_inv_status','sale_inv_due_days','sale_total_days'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_invoices_details');
    }

    public function customer()
    {
        return $this->belongsTo(SalesCustomers::class, 'sale_cus_id','sale_cus_id');
    }
    public function sentLogs()
{
    return $this->hasMany(SentLog::class, 'sale_inv_id', 'id');
}
public function currency()
{
    return $this->belongsTo(Countries::class, 'sale_currency_id', 'id');
}


}

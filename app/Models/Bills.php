<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = ['id','sale_bill_title', 'sale_bill_summary', 'sale_vendor_id', 'sale_bill_number', 'sale_bill_customer_ref', 'sale_bill_date', 'sale_bill_valid_date', 'sale_bill_note','sale_currency_id','sale_bill_sub_total', 'sale_bill_tax_amount', 'sale_bill_final_amount', 'sale_status','sale_bill_paid_amount','sale_bill_due_amount', 'sale_bill_status'];

    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_bills_details');
    }

     // INSERT INTO `chir62_py_bills_details`(`sale_bill_id`, `id`, `sale_bill_title`, `sale_bill_summary`, `sale_vendor_id`, `sale_bill_number`, `sale_bill_customer_ref`, `sale_bill_date`, `sale_bill_valid_date`, `sale_bill_note`, `sale_currency_id`, `sale_bill_sub_total`, `sale_bill_tax_amount`, `sale_bill_final_amount`, `sale_status`, `sale_bill_status`, `created_at`, `updated_at`) 
    public function vendor()
    {
        return $this->belongsTo(PurchasVendor::class, 'sale_vendor_id','purchases_vendor_id');
    }
    public function currency()
    {
        return $this->belongsTo(Countries::class, 'sale_currency_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchasVendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'purchases_vendor_name',
        'purchases_vendor_type',
        'purchases_vendor_contractor_type',
        'purchases_vendor_security_number',
        'purchases_contractor_type',
        'purchases_vendor_first_name',
        'purchases_vendor_last_name',
        'purchases_vendor_email',
        'purchases_vendor_country_id',
        'purchases_vendor_state_id',
        'purchases_vendor_address1',
        'purchases_vendor_address2',
        'purchases_vendor_city_name',
        'purchases_vendor_zipcode',
        'purchases_vendor_account_number',
        'purchases_vendor_phone',
        'purchases_vendor_fax',
        'purchases_vendor_mobile',
        'purchases_vendor_toll_free',
        'purchases_vendor_website',
        'purchases_vendor_currency_id',
        'purchases_vendor_status',
       
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_purchases_vendor');
    }
    public function tax()
    {
        return $this->belongsTo(SalesTax::class, 'purchases_product_tax','tax_id');
    }
    public function state()
    {
        return $this->belongsTo(States::class, 'purchases_vendor_state_id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'purchases_vendor_country_id');
    }
    public function bankDetails()
    {
        return $this->hasOne(PurchasVendorBankDetail::class, 'purchases_vendor_id', 'purchases_vendor_id');
    }
    public function currency()
    {
        return $this->belongsTo(Countries::class, 'sale_currency_id', 'id');
    }
}

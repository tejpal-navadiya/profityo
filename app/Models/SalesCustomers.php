<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalesCustomers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        // 'users_id',
        'sale_cus_business_name',
        'sale_cus_first_name',
        'sale_cus_last_name',
        'sale_cus_email',
        'sale_cus_phone',
        // 'sale_cus_fax',
        // 'sale_cus_mobile',
        // 'sale_cus_toll_free',
        'sale_cus_account_number',
        'sale_cus_website',
        'sale_cus_notes',
        'sale_bill_currency_id',
        'sale_bill_address1',
        'sale_bill_address2',
        'sale_bill_country_id',
        'sale_bill_city_name',
        'sale_bill_zipcode',
        'sale_bill_state_id' ,
        'sale_ship_country_id',
        'sale_ship_shipto',
        // 'sale_ship_currency_id',
        'sale_ship_address1',
        'sale_ship_address2',
        'sale_ship_city_name',
        'sale_ship_zipcode',
        'sale_ship_state_id',
        'sale_ship_phone',
        'sale_ship_delivery_desc',
        'sale_same_address',
        'sale_cus_status',
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_sale_customers');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'sale_bill_state_id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'sale_ship_country_id');
    }

    public function ship_state()
    {
        return $this->belongsTo(States::class, 'sale_ship_state_id');
    }

    public function bill_country()
    {
        return $this->belongsTo(Countries::class, 'sale_bill_country_id');
    }
    public function currency()
{
    return $this->belongsTo(Countries::class, 'sale_bill_currency_id', 'id');
}
}

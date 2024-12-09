<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalesProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'sale_product_name',
        'sale_product_price',
        'sale_product_tax',
        'sale_product_sell',
        'sale_product_buy',
        'sale_product_income_account',
        'sale_product_expense_account',
        'sale_product_desc',
        'sale_product_currency_id',
        'sale_product_status',
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_sale_product');
    }
    public function tax()
    {
        return $this->belongsTo(SalesTax::class, 'sale_product_tax','tax_id');
    }
    public function currency()
    {
        return $this->belongsTo(Countries::class, 'sale_product_currency_id', 'id');
    }
}

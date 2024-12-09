<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class PurchasProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'purchases_product_name',
        'purchases_product_price',
        'purchases_product_tax',
        'purchases_product_sell',
        'purchases_product_buy',
        'purchases_product_income_account',
        'purchases_product_expense_account',
        'purchases_product_desc',
        'purchases_product_currency_id',
        'purchases_product_status',
];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $userDetails = session('user_details');
        Auth::guard('masteradmins')->setUser($userDetails);
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_purchases_product');
    }
    public function tax()
    {
        return $this->belongsTo(SalesTax::class, 'purchases_product_tax','tax_id');
    }

    public function currency()
{
    return $this->belongsTo(Countries::class, 'purchases_product_currency_id', 'id');
}
}

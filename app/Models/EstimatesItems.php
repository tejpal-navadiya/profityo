<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EstimatesItems extends Model
{
    use HasFactory;

    protected $fillable = ['id','sale_estim_id', 'sale_product_id', 'sale_estim_item_qty', 'sale_estim_item_price', 'sale_estim_item_discount', 'sale_estim_item_tax', 'sale_estim_item_desc', 'sale_estim_item_amount','sale_currency_id','sale_estim_item_status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically set the table name
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_estimates_items');
    }

    public function estimate_product()
    {
        return $this->belongsTo(SalesProduct::class, 'sale_product_id','sale_product_id');
    }

    public function item_tax()
    {
        return $this->belongsTo(SalesTax::class, 'sale_estim_item_tax','tax_id');
    }

    
}

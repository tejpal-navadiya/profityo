<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\MasterUser;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function handleImageUpload(Request $request, $currentImage = null, $directory = 'default_directory')
    {
        
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($currentImage) {
                Storage::delete($directory . '/' . $currentImage);
            }

            // Generate a unique filename
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueFilename = Str::uuid() . '.' . $extension;

            // Store the new image
            $request->file('image')->storeAs($directory, $uniqueFilename);
            
            return $uniqueFilename;
        }

        return $currentImage;
    }

    public function CreateTable($id){
        $master_user = MasterUser::find($id);
        if($master_user){
            $storeId = $master_user->buss_unique_id;
            if (!Schema::hasTable($storeId.'_py_log_activities_table')){   
                Schema::create($storeId.'_py_log_activities_table', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('subject')->nullable();
                    $table->string('url')->nullable();
                    $table->string('method')->nullable();
                    $table->string('ip')->nullable();
                    $table->string('agent')->nullable();
                    $table->integer('user_id')->nullable()->default(0);
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId.'_py_users_role')){  
                Schema::create($storeId.'_py_users_role', function (Blueprint $table) {
                    $table->increments('role_id');
                    $table->integer('id');
                    $table->string('role_name');
                    $table->tinyInteger('role_status')->default(0);
                    $table->timestamps();
                });

            }else{
                Schema::table($storeId.'_py_users_role', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_users_role', 'id')) {
                        $table->integer('id');
                    }
                });
            }

            if (!Schema::hasTable($storeId.'_py_users_details')){   
                Schema::create($storeId.'_py_users_details', function (Blueprint $table) {
                    $table->increments('users_id');
                    $table->string('users_name')->nullable();
                    $table->string('users_email')->nullable()->unique();
                    $table->string('email_verified_at')->nullable()->unique();
                    $table->string('users_phone')->nullable()->unique();
                    $table->string('users_password')->nullable();
                    $table->integer('role_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->string('user_id')->nullable();
                    $table->string('remember_token')->nullable();
                    $table->tinyInteger('users_status')->default(0)->nullable();
                    $table->string('users_image')->nullable();
                    $table->integer('country_id')->nullable()->default(0);
                    $table->integer('state_id')->nullable()->default(0);
                    $table->string('users_city_name')->nullable();
                    $table->string('users_pincode')->nullable();
                    $table->timestamps();
                });
            }else{
                
                Schema::table($storeId.'_py_users_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'users_image')) {
                        $table->string('users_image')->nullable();
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'country_id')) {
                        $table->integer('country_id');
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'state_id')) {
                        $table->integer('state_id');
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'users_city_name')) {
                        $table->string('users_city_name');
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'users_pincode')) {
                        $table->string('users_pincode');
                    }
                });
            }

            if (!Schema::hasTable($storeId.'_py_business_details')){   
                Schema::create($storeId.'_py_business_details', function (Blueprint $table) {
                    $table->increments('bus_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('bus_company_name')->nullable();
                    $table->string('bus_image')->nullable();
                    $table->integer('state_id')->nullable()->default(0);
                    $table->integer('country_id')->nullable()->default(0);
                    $table->string('city_name')->nullable();
                    $table->string('zipcode')->nullable();
                    $table->string('bus_address1')->nullable();
                    $table->string('bus_address2')->nullable();
                    $table->string('bus_phone')->nullable();
                    $table->string('bus_mobile')->nullable();
                    $table->string('bus_website')->nullable();
                    $table->integer('bus_currency')->nullable()->default(0);
                    $table->tinyInteger('bus_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId.'_py_sales_tax')){   
                Schema::create($storeId.'_py_sales_tax', function (Blueprint $table) {
                    $table->increments('tax_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('tax_name')->nullable();
                    $table->string('tax_abbreviation')->nullable();
                    $table->integer('tax_number')->nullable();
                    $table->string('tax_desc')->nullable();
                    $table->string('tax_number_invoices')->nullable();
                    $table->string('tax_recoverable')->nullable();
                    $table->string('tax_compound')->nullable();
                    $table->integer('tax_rate')->nullable()->default(0);
                    $table->tinyInteger('tax_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // master user access
            if (!Schema::hasTable($storeId.'_py_master_user_access')){   
                Schema::create($storeId.'_py_master_user_access', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('u_id')->nullable()->default(0);
                    $table->integer('role_id')->nullable()->default(0);
                    $table->string('mname')->nullable();
                    $table->string('mtitle')->nullable();
                    $table->integer('mid')->nullable();
                    $table->string('is_access')->nullable();
                    $table->timestamps();
                });
            }
            // end by dx....

            // SalesCustomer...
            if (!Schema::hasTable($storeId . '_py_sale_customers')) {
                Schema::create($storeId . '_py_sale_customers', function (Blueprint $table) {
                    $table->increments('sale_cus_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('users_id')->nullable()->default(0);
                    $table->string('sale_cus_business_name')->nullable();
                    $table->string('sale_cus_first_name')->nullable();
                    $table->string('sale_cus_last_name')->nullable();
                    $table->string('sale_cus_email')->nullable();
                    $table->string('sale_cus_phone')->nullable();
                    $table->string('sale_cus_fax')->nullable();
                    $table->string('sale_cus_mobile')->nullable();
                    $table->string('sale_cus_toll_free')->nullable();
                    $table->string('sale_cus_account_number')->nullable();
                    $table->string('sale_cus_website')->nullable();
                    $table->string('sale_cus_notes')->nullable();
                    $table->integer('sale_bill_currency_id')->nullable()->default(0);
                    $table->string('sale_bill_address1')->nullable();
                    $table->string('sale_bill_address2')->nullable();
                    $table->integer('sale_bill_country_id')->nullable()->default(0);
                    $table->string('sale_bill_city_name')->nullable();
                    $table->string('sale_bill_zipcode')->nullable();
                    $table->integer('sale_bill_state_id')->nullable()->default(0);
                    $table->string('sale_ship_shipto')->nullable();
                    $table->integer('sale_ship_currency_id')->nullable()->default(0);
                    $table->string('sale_ship_address1')->nullable();
                    $table->string('sale_ship_address2')->nullable();
                    $table->integer('sale_ship_country_id')->nullable()->default(0);
                    $table->string('sale_ship_city_name')->nullable();
                    $table->string('sale_ship_zipcode')->nullable();
                    $table->integer('sale_ship_state_id')->nullable()->default(0);
                    $table->string('sale_ship_phone')->nullable();
                    $table->string('sale_ship_delivery_desc')->nullable();
                    $table->string('sale_same_address')->nullable();
                    $table->tinyInteger('sale_cus_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

              // Sales & payments....product module..
            if (!Schema::hasTable($storeId . '_py_sale_product')) {
                Schema::create($storeId . '_py_sale_product', function (Blueprint $table) {
                    $table->increments('sale_product_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_product_name')->nullable();
                    $table->string('sale_product_price')->nullable();
                    $table->string('sale_product_tax')->nullable();
                    $table->string('sale_product_sell')->nullable();
                    $table->string('sale_product_buy')->nullable();
                    $table->integer('sale_product_income_account')->nullable();
                    $table->integer('sale_product_expense_account')->nullable();
                    $table->string('sale_product_desc')->nullable();
                    $table->integer('sale_product_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_estimates_details')) {
                Schema::create($storeId . '_py_estimates_details', function (Blueprint $table) {
                    $table->increments('sale_estim_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_estim_title')->nullable();
                    $table->text('sale_estim_summary')->nullable();
                    $table->integer('sale_cus_id')->nullable();
                    $table->string('sale_estim_number')->nullable();
                    $table->string('sale_estim_customer_ref')->nullable();
                    $table->string('sale_estim_date')->nullable();
                    $table->string('sale_estim_valid_date')->nullable();
                    $table->integer('sale_total_days')->nullable()->default(0);
                    $table->string('sale_estim_item_discount')->nullable()->default(0);
                    $table->text('sale_estim_discount_desc')->nullable();
                    $table->integer('sale_estim_discount_type')->nullable()->default(0);
                    $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->string('sale_estim_sub_total')->nullable()->default(0);
                    $table->string('sale_estim_discount_total')->nullable()->default(0);
                    $table->string('sale_estim_tax_amount')->nullable()->default(0);
                    $table->string('sale_estim_final_amount')->nullable()->default(0);
                    $table->string('sale_estim_notes')->nullable();
                    $table->string('sale_estim_footer_note')->nullable();
                    $table->string('sale_estim_image')->nullable();
                    $table->string('sale_status')->nullable()->default(0);
                    $table->tinyInteger('sale_estim_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }else{
                
                Schema::table($storeId.'_py_estimates_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_estimates_details', 'sale_total_days')) {
                        $table->integer('sale_total_days')->nullable()->default(0);
                    }
                });
            }


            if (!Schema::hasTable($storeId . '_py_estimates_items')) {
                Schema::create($storeId . '_py_estimates_items', function (Blueprint $table) {
                    $table->increments('sale_estim_item_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_estim_id')->nullable()->default(0);
                    $table->integer('sale_product_id')->nullable()->default(0);
                    $table->integer('sale_estim_item_qty')->nullable()->default(0);
                    $table->string('sale_estim_item_price')->nullable()->default(0);
                    // $table->string('sale_estim_item_discount')->nullable()->default(0);
                    $table->string('sale_estim_item_tax')->nullable()->default(0);
                    $table->text('sale_estim_item_desc')->nullable();
                    $table->string('sale_estim_item_amount')->nullable()->default(0);
                    // $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_estim_item_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // Sales & payments....product module..
            if (!Schema::hasTable($storeId . '_py_sale_product')) {
                Schema::create($storeId . '_py_sale_product', function (Blueprint $table) {
                    $table->increments('sale_product_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_product_name')->nullable();
                    $table->string('sale_product_price')->nullable();
                    $table->string('sale_product_tax')->nullable();
                    $table->string('sale_product_sell')->nullable();
                    $table->string('sale_product_buy')->nullable();
                    $table->integer('sale_product_income_account')->nullable();
                    $table->integer('sale_product_expense_account')->nullable();
                    $table->string('sale_product_desc')->nullable();
                    $table->integer('sale_product_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // Sales & payments....chart _of_account..
            if (!Schema::hasTable($storeId . '_py_chart_account')) {
                Schema::create($storeId . '_py_chart_account', function (Blueprint $table) {
                    $table->increments('chart_acc_id');
                    $table->integer('id')->nullable()->default(0);
                    // $table->integer('users_id')->nullable()->default(0);
                    $table->integer('type_id')->nullable()->default(0);
                    $table->integer('acc_type_id')->nullable()->default(0);
                    $table->string('chart_acc_name')->nullable();
                    $table->string('amount')->nullable();
                    $table->integer('currency_id')->nullable()->default(0);
                    $table->string('chart_account_id')->nullable();
                    $table->string('sale_acc_desc')->nullable();
                    $table->integer('archive_account')->nullable()->default(0);
                    $table->tinyInteger('sale_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }else{
                Schema::table($storeId.'_py_chart_account', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_chart_account', 'archive_account')) {
                        $table->integer('archive_account')->nullable()->default(0);
                    }
                });
            }

            // Purchases....product module..
            if (!Schema::hasTable($storeId . '_py_purchases_product')) {
                Schema::create($storeId . '_py_purchases_product', function (Blueprint $table) {
                    $table->increments('purchases_product_id');
                    $table->integer('id')->nullable()->default(0);
                    // $table->integer('users_id')->nullable()->default(0);
                    $table->string('purchases_product_name')->nullable();
                    $table->string('purchases_product_price')->nullable();
                    $table->string('purchases_product_tax')->nullable();
                    $table->string('purchases_product_sell')->nullable();
                    $table->string('purchases_product_buy')->nullable();
                    $table->integer('purchases_product_income_account')->nullable();
                    $table->integer('purchases_product_expense_account')->nullable();
                    $table->string('purchases_product_desc')->nullable();
                    $table->integer('purchases_product_currency_id')->nullable()->default(0);
                    $table->tinyInteger('purchases_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_purchases_vendor')) {
                Schema::create($storeId . '_py_purchases_vendor', function (Blueprint $table) {
                    $table->increments('purchases_vendor_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('type')->nullable();
                    $table->string('purchases_vendor_name')->nullable();
                    $table->string('purchases_vendor_type')->nullable();
                    $table->string('purchases_vendor_contractor_type')->nullable();
                    $table->string('purchases_contractor_type')->nullable();
                    $table->string('purchases_vendor_security_number')->nullable();
                    $table->string('purchases_vendor_first_name')->nullable();
                    $table->string('purchases_vendor_last_name')->nullable();
                    $table->string('purchases_vendor_email')->nullable();
                    $table->string('purchases_vendor_country_id')->nullable()->default(0);
                    $table->string('purchases_vendor_state_id')->nullable()->default(0);
                    $table->string('purchases_vendor_address1')->nullable();
                    $table->string('purchases_vendor_address2')->nullable();
                    $table->string('purchases_vendor_city_name')->nullable();
                    $table->string('purchases_vendor_zipcode')->nullable();
                    $table->string('purchases_vendor_account_number')->nullable();
                    $table->string('purchases_vendor_phone')->nullable();
                    $table->string('purchases_vendor_fax')->nullable();
                    $table->string('purchases_vendor_mobile')->nullable();
                    $table->string('purchases_vendor_toll_free')->nullable();
                    $table->string('purchases_vendor_website')->nullable();
                    $table->integer('purchases_vendor_currency_id')->nullable()->default(0);
                    $table->tinyInteger('purchases_vendor_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_customize_menu_estimates')) {
                Schema::create($storeId . '_py_customize_menu_estimates', function (Blueprint $table) {
                    $table->increments('esti_cust_menu_id')->unique();
                    $table->integer('sale_estim_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->string('mname')->nullable();
                    $table->string('mtitle')->nullable();
                    $table->integer('mid')->nullable();
                    $table->integer('is_access')->nullable();
                    $table->string('esti_cust_menu_title')->nullable();
                    $table->timestamps();
                });
            }

            //invoice
            if (!Schema::hasTable($storeId . '_py_invoices_details')) {
                Schema::create($storeId . '_py_invoices_details', function (Blueprint $table) {
                    $table->increments('sale_inv_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_inv_title')->nullable();
                    $table->text('sale_inv_summary')->nullable();
                    $table->integer('sale_cus_id')->nullable();
                    $table->string('sale_inv_number')->nullable();
                    $table->string('sale_inv_customer_ref')->nullable();
                    $table->string('sale_inv_date')->nullable();
                    $table->string('sale_inv_valid_date')->nullable();
                    $table->integer('sale_total_days')->nullable()->default(0);
                    $table->string('sale_inv_item_discount')->nullable()->default(0);
                    $table->text('sale_inv_discount_desc')->nullable();
                    $table->integer('sale_inv_discount_type')->nullable()->default(0);
                    $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->string('sale_inv_sub_total')->nullable()->default(0);
                    $table->string('sale_inv_discount_total')->nullable()->default(0);
                    $table->string('sale_inv_tax_amount')->nullable()->default(0);
                    $table->string('sale_inv_final_amount')->nullable()->default(0);
                    $table->string('sale_inv_due_amount')->nullable()->default(0);
                    $table->string('sale_inv_notes')->nullable();
                    $table->string('sale_inv_footer_note')->nullable();
                    $table->string('sale_inv_image')->nullable();
                    $table->string('sale_status')->nullable()->default(0);
                    $table->tinyInteger('sale_inv_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }else{
                Schema::table($storeId.'_py_invoices_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_invoices_details', 'sale_total_days')) {
                        $table->integer('sale_total_days')->nullable()->default(0);
                    }
                });

                Schema::table($storeId.'_py_invoices_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_invoices_details', 'sale_inv_due_amount')) {
                        $table->integer('sale_inv_due_amount')->nullable()->default(0);
                    }
                });
            }
            

            if (!Schema::hasTable($storeId . '_py_invoices_items')) {
                Schema::create($storeId . '_py_invoices_items', function (Blueprint $table) {
                    $table->increments('sale_inv_item_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_inv_id')->nullable()->default(0);
                    $table->integer('sale_product_id')->nullable()->default(0);
                    $table->integer('sale_inv_item_qty')->nullable()->default(0);
                    $table->string('sale_inv_item_price')->nullable()->default(0);
                    // $table->string('sale_estim_item_discount')->nullable()->default(0);
                    $table->string('sale_inv_item_tax')->nullable()->default(0);
                    $table->text('sale_inv_item_desc')->nullable();
                    $table->string('sale_inv_item_amount')->nullable()->default(0);
                    // $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_inv_item_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_customize_menu_invoices')) {
                Schema::create($storeId . '_py_customize_menu_invoices', function (Blueprint $table) {
                    $table->increments('inv_cust_menu_id')->unique();
                    $table->integer('sale_inv_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->string('mname')->nullable();
                    $table->string('mtitle')->nullable();
                    $table->integer('mid')->nullable();
                    $table->integer('is_access')->nullable();
                    $table->string('inv_cust_menu_title')->nullable();
                    $table->timestamps();
                });
            }

              // Purchases....bank details. module..
            if (!Schema::hasTable($storeId . '_py_purchases_bank_details')) {
                Schema::create($storeId . '_py_purchases_bank_details', function (Blueprint $table) {
                    $table->increments('purchases_bank_id');
                    $table->integer('purchases_vendor_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    // $table->integer('users_id')->nullable()->default(0);
                    $table->string('purchases_routing_number')->nullable();
                    $table->string('purchases_account_number')->nullable();
                    $table->string('bank_account_type')->nullable();
                
                    $table->timestamps();
                });
            }

            //estimate and invoice sent log
            if (!Schema::hasTable($storeId . '_py_sent_log')) {
                Schema::create($storeId . '_py_sent_log', function (Blueprint $table) {
                    $table->increments('log_id');
                    $table->integer('log_type')->nullable()->default(0)->comment('1-estimate,2-invoice');
                    $table->integer('user_id')->nullable()->default(0)->comment('business id');
                    $table->integer('cust_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->string('log_msg')->nullable();
                    $table->string('status')->nullable();
                    $table->tinyInteger('log_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_inv_recurring_details')) {
                Schema::create($storeId . '_py_inv_recurring_details', function (Blueprint $table) {
                    $table->increments('sale_re_inv_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_re_inv_title')->nullable();
                    $table->text('sale_re_inv_summary')->nullable();
                    $table->integer('sale_cus_id')->nullable();
                    $table->string('sale_re_inv_number')->nullable();
                    $table->string('sale_re_inv_customer_ref')->nullable();
                    $table->string('sale_re_inv_date')->nullable();
                    $table->integer('sale_re_inv_payment_due_id')->nullable()->default(0);
                    $table->string('sale_re_inv_valid_date')->nullable();
                    $table->string('sale_re_inv_item_discount')->nullable()->default(0);
                    $table->text('sale_re_inv_discount_desc')->nullable();
                    $table->integer('sale_re_inv_discount_type')->nullable()->default(0);
                    $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->string('sale_re_inv_sub_total')->nullable()->default(0);
                    $table->string('sale_re_inv_discount_total')->nullable()->default(0);
                    $table->string('sale_re_inv_tax_amount')->nullable()->default(0);
                    $table->string('sale_re_inv_final_amount')->nullable()->default(0);
                    $table->string('sale_re_inv_notes')->nullable();
                    $table->string('sale_re_inv_footer_note')->nullable();
                    $table->string('sale_re_inv_image')->nullable();
                    $table->string('sale_status')->nullable()->default(0);
                    $table->tinyInteger('sale_re_inv_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }else{
                Schema::table($storeId.'_py_inv_recurring_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_inv_recurring_details', 'sale_re_inv_payment_due_id')) {
                        $table->integer('sale_re_inv_payment_due_id')->nullable()->default(0);
                    }
                });
            }
            

            if (!Schema::hasTable($storeId . '_py_inv_recurring_items')) {
                Schema::create($storeId . '_py_inv_recurring_items', function (Blueprint $table) {
                    $table->increments('sale_re_inv_item_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_re_inv_id')->nullable()->default(0);
                    $table->integer('sale_product_id')->nullable()->default(0);
                    $table->integer('sale_re_inv_item_qty')->nullable()->default(0);
                    $table->string('sale_re_inv_item_price')->nullable()->default(0);
                    // $table->string('sale_estim_item_discount')->nullable()->default(0);
                    $table->string('sale_re_inv_item_tax')->nullable()->default(0);
                    $table->text('sale_re_inv_item_desc')->nullable();
                    $table->string('sale_re_inv_item_amount')->nullable()->default(0);
                    // $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_re_inv_item_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_customize_menu_re_invoices')) {
                Schema::create($storeId . '_py_customize_menu_re_invoices', function (Blueprint $table) {
                    $table->increments('re_inv_cust_menu_id')->unique();
                    $table->integer('sale_re_inv_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->string('mname')->nullable();
                    $table->string('mtitle')->nullable();
                    $table->integer('mid')->nullable();
                    $table->integer('is_access')->nullable();
                    $table->string('re_inv_cust_menu_title')->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_re_invoices_schedule')) {
                Schema::create($storeId . '_py_re_invoices_schedule', function (Blueprint $table) {
                    $table->increments('re_inv_sch_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_re_inv_id')->nullable()->default(0);
                    $table->string('repeat_inv_type')->nullable();
                    $table->string('repeat_inv_month')->nullable();
                    $table->string('repeat_inv_day')->nullable();
                    $table->string('repeat_inv_date')->nullable();
                    $table->string('invoice_date')->nullable();
                    $table->string('create_inv_type')->nullable();
                    $table->integer('create_inv_number')->nullable()->default(0);
                    $table->string('create_inv_date')->nullable();
                    $table->tinyInteger('re_inv_sch_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_bills_details')) {
                Schema::create($storeId . '_py_bills_details', function (Blueprint $table) {
                    $table->increments('sale_bill_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_bill_title')->nullable();
                    $table->text('sale_bill_summary')->nullable();
                    $table->integer('sale_vendor_id')->nullable();
                    $table->string('sale_bill_number')->nullable();
                    $table->string('sale_bill_customer_ref')->nullable();
                    $table->string('sale_bill_date')->nullable();
                    $table->string('sale_bill_valid_date')->nullable();
                    $table->text('sale_bill_note')->nullable()->default(0);
                    $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->string('sale_bill_sub_total')->nullable()->default(0);
                    $table->string('sale_bill_tax_amount')->nullable()->default(0);
                    $table->string('sale_bill_final_amount')->nullable()->default(0);
                    $table->string('sale_bill_paid_amount')->nullable()->default(0);
                    $table->string('sale_bill_due_amount')->nullable()->default(0);
                    $table->string('sale_status')->nullable()->default(0);
                    $table->tinyInteger('sale_bill_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }else{
                Schema::table($storeId.'_py_bills_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_bills_details', 'sale_bill_paid_amount')) {
                        $table->string('sale_bill_paid_amount')->nullable()->default(0);
                    }
                });

                Schema::table($storeId.'_py_bills_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_bills_details', 'sale_bill_due_amount')) {
                        $table->string('sale_bill_due_amount')->nullable()->default(0);
                    }
                });
            }

            if (!Schema::hasTable($storeId . '_py_bills_items')) {
                Schema::create($storeId . '_py_bills_items', function (Blueprint $table) {
                    $table->increments('sale_bill_item_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_bill_id')->nullable()->default(0);
                    $table->integer('sale_product_id')->nullable()->default(0);
                    $table->integer('sale_expense_id')->nullable()->default(0);
                    $table->integer('sale_bill_item_qty')->nullable()->default(0);
                    $table->string('sale_bill_item_price')->nullable()->default(0);
                    $table->string('sale_bill_item_tax')->nullable()->default(0);
                    $table->text('sale_bill_item_desc')->nullable();
                    $table->tinyInteger('sale_bill_item_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }


// payroll   employees module 
if (!Schema::hasTable($storeId . 'py_employee_details')) {
    Schema::create($storeId . 'py_employee_details', function (Blueprint $table) {
        $table->increments('emp_id');
        $table->integer('id')->nullable()->default(0);
        $table->integer('users_id')->nullable()->default(0);
        $table->string('emp_first_name')->nullable();
        $table->string('emp_last_name')->nullable();
        $table->string('emp_social_security_number')->nullable();
        $table->string('emp_hopy_address')->nullable();
        $table->string('city_name')->nullable();
        $table->string('state_id')->nullable()->default(0);
        $table->string('zipcode')->nullable();
        $table->string('emp_dob')->nullable();
        $table->string('emp_email')->nullable();
        $table->string('emp_middle_initial')->nullable();
        $table->string('emp_doh')->nullable();
        $table->string('emp_work_location')->nullable();
        $table->string('emp_wage_type')->nullable();
        $table->integer('emp_wage_amount')->nullable()->default(0);
        $table->string('emp_work_hours')->nullable();
        $table->integer('emp_direct_deposit')->nullable();
        $table->integer('emp_vacation_policy')->nullable();
        $table->integer('emp_vacation_accural_rate')->nullable();
        $table->tinyInteger('emp_status')->default(0)->nullable();
        $table->timestamps();
    });
}
else{
    Schema::table($storeId.'py_employee_details', function (Blueprint $table) use ($storeId) {
        if (!Schema::hasColumn($storeId.'py_employee_details', 'emp_direct_deposit')) {
            $table->integer('emp_direct_deposit')->nullable();
        }
    });
    Schema::table($storeId.'py_employee_details', function (Blueprint $table) use ($storeId) {
        if (!Schema::hasColumn($storeId.'py_employee_details', 'emp_vacation_policy')) {
            $table->integer('emp_vacation_policy')->nullable();
        }
    });
    Schema::table($storeId.'py_employee_details', function (Blueprint $table) use ($storeId) {
        if (!Schema::hasColumn($storeId.'py_employee_details', 'emp_vacation_accural_rate')) {
            $table->integer('emp_vacation_accural_rate')->nullable();
        }
    });
}
// py_employee_comperisation
if (!Schema::hasTable($storeId . 'py_employee_comperisation')) {
    Schema::create($storeId . 'py_employee_comperisation', function (Blueprint $table) {
        $table->increments('emp_comp_id');
        $table->integer('emp_id')->nullable()->default(0);
        $table->integer('id')->nullable()->default(0);
        $table->integer('users_id')->nullable()->default(0);
        $table->string('emp_comp_salary_amount')->nullable();
        $table->string('emp_comp_salary_type')->nullable();
        $table->string('emp_comp_effective_date')->nullable();
        $table->tinyInteger('emp_comp_status')->default(0)->nullable();
        $table->string('average_hours_per_week')->nullable();
        $table->timestamps();
    });
}
else{
    Schema::table($storeId.'py_employee_comperisation', function (Blueprint $table) use ($storeId) {
        if (!Schema::hasColumn($storeId.'py_employee_comperisation', 'average_hours_per_week')) {
            $table->string('average_hours_per_week')->nullable();
        }
    });
}
// py_employee_tax_details
if (!Schema::hasTable($storeId . 'py_employee_tax_details')) {
    Schema::create($storeId . 'py_employee_tax_details', function (Blueprint $table) {
        $table->increments('emp_tax_id');
        $table->integer('emp_id')->nullable()->default(0);
        $table->integer('id')->nullable()->default(0);
        $table->integer('users_id')->nullable()->default(0);
        $table->string('emp_tax_deductions')->nullable();
        $table->string('emp_tax_dependent_amount')->nullable();
        $table->string('emp_tax_filing_status')->nullable();
        $table->string('emp_tax_nra_amount')->nullable();
        $table->string('emp_tax_other_income')->nullable();
        $table->string('emp_tax_job')->nullable();
        $table->string('emp_tax_california_state_tax')->nullable();
        $table->string('emp_tax_california_filing_status')->nullable();
        $table->string('emp_tax_california_total_allowances')->nullable();
        $table->string('emp_tax_non_resident_emp')->nullable();
        $table->string('emp_tax_california_state')->nullable()->default(0);
        $table->string('emp_tax_california_sdi')->nullable();
        $table->tinyInteger('emp_tax_status')->default(0)->nullable();
        $table->timestamps();
    });
}


// py_employee_start_offboarding
if (!Schema::hasTable($storeId . 'py_employee_start_offboarding')) {
    Schema::create($storeId . 'py_employee_start_offboarding', function (Blueprint $table) {
        $table->increments('emp_off_id');
        $table->integer('emp_id')->nullable()->default(0);
        $table->integer('id')->nullable()->default(0);
        $table->integer('users_id')->nullable()->default(0);
        $table->integer('ct_id')->nullable()->default(0);
        $table->string('emp_off_ending')->nullable();
        $table->string('emp_off_last_work_date')->nullable();
        $table->string('emp_off_notice_date')->nullable();
        $table->tinyInteger('emp_off_status')->default(0)->nullable();
        $table->timestamps();
    });
}

// py_employee_place_leave
if (!Schema::hasTable($storeId . 'py_employee_place_leave')) {
    Schema::create($storeId . 'py_employee_place_leave', function (Blueprint $table) {
        $table->increments('emp_lev_id');
        $table->integer('emp_id')->nullable()->default(0);
        $table->integer('id')->nullable()->default(0);
        $table->integer('users_id')->nullable()->default(0);
        $table->integer('ct_id')->nullable()->default(0);
        $table->string('emp_lev_start_date')->nullable();
        $table->string('emp_lev_end_date')->nullable();
        $table->string('emp_lev_desc')->nullable();
        $table->tinyInteger('emp_lev_status')->default(0)->nullable();
        $table->timestamps();
    });
}

// 
if (!Schema::hasTable($storeId . '_py_record_a_payment')) {
    Schema::create($storeId . '_py_record_a_payment', function (Blueprint $table) {
        $table->increments('record_payment_id');
        $table->integer('id')->nullable()->default(0);
        $table->integer('invoice_id')->nullable()->default(0);
        $table->string('payment_method')->nullable()->default(0);
        $table->string('payment_account')->nullable();
        $table->string('payment_date')->nullable();
        $table->string('payment_amount')->nullable();
        $table->string('notes')->nullable();
        $table->string('description')->nullable();
        $table->tinyInteger('status')->default(0)->nullable();
        $table->timestamps();
    });
}
		









            //customer contact
            if (!Schema::hasTable($storeId . '_py_sale_customer_contact')) {
                Schema::create($storeId . '_py_sale_customer_contact', function (Blueprint $table) {
                    $table->increments('cus_con_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_cus_id')->nullable()->default(0);
                    $table->string('cus_con_name')->nullable();
                    $table->string('cus_con_email')->nullable();
                    $table->string('cus_con_phone')->nullable();
                    $table->tinyInteger('cus_con_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }
            

        }
    }

    public function createTableRoute(Request $request)
    {
        
       $user = Auth::guard('masteradmins')->user();
        //dd($user);
        $id = $user->id;

        if (!$id) {
            return response()->json(['message' => 'ID is required'], 400);
        }
        try {
            $this->CreateTable($id);
            return response()->json(['message' => 'Table created or modified successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



    function formatDueDays($dueDate)
    {
        $dueDate = Carbon::parse($dueDate); // Parse the due date
        $currentDate = Carbon::now(); // Get today's date
        $dueDays = $dueDate->diffInDays($currentDate, false); // Difference in days

        // Format the message
        if ($dueDate->isPast()) {
            return $dueDays === 1 ? '1 day ago' : "$dueDays days ago";
        } else {
            return $dueDays === 1 ? 'Due in 1 day' : "Due in $dueDays days";
        }
    }

}
    

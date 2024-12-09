<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Estimates;
use App\Models\BusinessDetails;
use App\Models\Countries;
use App\Models\States;
use App\Models\SalesCustomers;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesProduct;
use App\Models\SalesTax;
use App\Models\EstimatesItems;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\CustomizeMenu;
use App\Models\EstimateCustomizeMenu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Notifications\EstimateViewMail;
use App\Models\ChartAccount;

// use Dompdf\Dompdf;
// use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use App\Models\InvoicesDetails;
use App\Models\SentLog;
use Illuminate\Validation\Rule;


class EstimatesController extends Controller
{
    //
    // public function index(Request $request)
    // {


    //     $user = Auth::guard('masteradmins')->user();
    //     $user_id = $user->users_id;
    //     $currencys = Countries::get();
    //     $startDate = $request->input('start_date'); 
    //     $endDate = $request->input('end_date');   
    //     //\DB::enableQueryLog();
       
    //     // $query = Estimates::with(['customer', 'currency'])->orderBy('created_at', 'desc');
    //     $query = Estimates::with(['customer', 'currency'])
    //     ->where('id', $user_id) // Filter by user ID
    //     ->orderBy('created_at', 'desc');
    
    //     // if ($request->has('start_date') && $request->start_date) {
    //     //     $query->whereDate('sale_estim_date', '>=', $request->start_date);
    //     // }

    //     // if ($request->has('end_date') && $request->end_date) {
    //     //     $query->whereDate('sale_estim_date', '<=', $request->end_date);
    //     // }

    //     // Check for start date and end date
    //     if ($startDate && !$endDate) {
    //         $query->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') = STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);
    //     } elseif ($startDate && $endDate) {
    //         $query->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate])
    //             ->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);
    //     }

    //     if ($request->has('sale_estim_number') && $request->sale_estim_number) {
    //         $query->where('sale_estim_number', 'like', '%' . $request->sale_estim_number . '%');
    //     }

    //     if ($request->has('sale_cus_id') && $request->sale_cus_id) {
    //         $query->where('sale_cus_id', $request->sale_cus_id);
    //     }
      
    //     if ($request->has('sale_status') && $request->sale_status) {
    //         $query->where('sale_status', $request->sale_status);
    //     }

    //     $filteredEstimates = $query->get();

    //     $activeEstimates = $filteredEstimates->whereIn('sale_status', ['Saved', 'Sent']);
    //     $draftEstimates = $filteredEstimates->where('sale_status', 'Draft');
    //     $allEstimates = $filteredEstimates;
    //     $salecustomer = SalesCustomers::get();
    //     $currencys = Countries::get();
    //     if ($request->ajax()) {
          
    //         return view('masteradmin.estimates.filtered_results', compact('activeEstimates', 'draftEstimates', 'allEstimates', 'user_id', 'salecustomer'))->render();
    //     }

    //     return view('masteradmin.estimates.index', compact('activeEstimates', 'draftEstimates', 'allEstimates', 'user_id', 'salecustomer','currencys'));
    // }

    public function index(Request $request)
{
    $user = Auth::guard('masteradmins')->user();
    $user_id = $user->users_id;
    $role_id = $user->role_id;

    $currencys = Countries::get();
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Initialize query based on role
    if ($role_id == 0) { // Admin Role
        $query = Estimates::with(['customer', 'currency'])
            ->orderBy('created_at', 'desc');
    } else { // Non-admin Role
        $query = Estimates::with(['customer', 'currency'])
            ->where(function ($query) use ($user_id) {
                $query->where('id', $user_id); // Example for additional condition
            })
            ->orderBy('created_at', 'desc');
    }

    // Apply date filters
    if ($startDate && !$endDate) {
        $query->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') = STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);
    } elseif ($startDate && $endDate) {
        $query->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate])
            ->whereRaw("STR_TO_DATE(sale_estim_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);
    }

    // Additional filters
    if ($request->has('sale_estim_number') && $request->sale_estim_number) {
        $query->where('sale_estim_number', 'like', '%' . $request->sale_estim_number . '%');
    }

    if ($request->has('sale_cus_id') && $request->sale_cus_id) {
        $query->where('sale_cus_id', $request->sale_cus_id);
    }

    if ($request->has('sale_status') && $request->sale_status) {
        $query->where('sale_status', $request->sale_status);
    }

    // Fetch filtered data
    $filteredEstimates = $query->get();

    // Categorize estimates
    $activeEstimates = $filteredEstimates->whereIn('sale_status', ['Saved', 'Sent']);
    $draftEstimates = $filteredEstimates->where('sale_status', 'Draft');
    $allEstimates = $filteredEstimates;

    $salecustomer = SalesCustomers::get();

    if ($request->ajax()) {
        return view('masteradmin.estimates.filtered_results', compact('activeEstimates', 'draftEstimates', 'allEstimates', 'user_id', 'salecustomer'))->render();
    }

    return view('masteradmin.estimates.index', compact('activeEstimates', 'draftEstimates', 'allEstimates', 'user_id', 'salecustomer', 'currencys'));
}


    public function create(): View
    {
        
        $user = Auth::guard('masteradmins')->user();
     
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $countries = Countries::all();
        $states = collect();
        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        if ($businessDetails && $businessDetails->country_id) {
            $states = States::where('country_id', $businessDetails->country_id)->get();
        }

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
      
        
        $salestax = SalesTax::all();

        $customers = SalesCustomers::where('id', $user->id)->first();

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

       
        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        $lastEstimate = Estimates::orderBy('sale_estim_id', 'desc')->first();

        $newId = $lastEstimate ? $lastEstimate->sale_estim_id + 1 : 1;

        $salecustomer = SalesCustomers::get();
        $currencys = Countries::get();
        $Country = Countries::all(); // Fetch all countries
        $SalesTax = SalesTax::all();

        // Fetch ChartAccount records based on type_id
        $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); 
        return view('masteradmin.estimates.add', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','specificMenus','HideMenus','HideSettings','HideDescription','customer_states','ship_state','newId','Country', 'SalesTax', 'IncomeAccounts', 'ExpenseAccounts'));
    }

    public function getProductDetails($id)
    {
        $product = SalesProduct::where('sale_product_id', $id)->firstOrFail();
       
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function store(Request $request)
    {
       
        // dd($request->input('items'));
        // dd($request->all());
        $user = Auth::guard('masteradmins')->user();
       
        $dynamicId = $user->user_id; // This should be set dynamically based on your application logic

        $tableName = $dynamicId . '_py_estimates_details'; // Construct the table name

      $request->validate([
            'sale_estim_title' => 'nullable|string|max:255',
            'sale_estim_summary' => 'nullable|string',
            'sale_cus_id' => 'required|integer',
            'sale_estim_number' => 'required|string|max:255|unique:' . $tableName . ',sale_estim_number',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_estim_date' => 'required|date',
            'sale_estim_valid_date' => 'required|date',
            'sale_estim_discount_desc' => 'nullable|string',
            'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
            'sale_currency_id' => 'nullable|numeric',
            'sale_estim_sub_total' => 'required|numeric',
            'sale_estim_discount_total' => 'required|numeric',
            'sale_estim_tax_amount' => 'required|numeric',
            'sale_estim_final_amount' => 'required|numeric',
            'sale_estim_notes' => 'nullable|string',
            'sale_estim_footer_note' => 'nullable|string',
            'sale_estim_image' => 'nullable|image',
            'sale_status' => 'required|integer',
            'sale_estim_item_discount' => 'nullable|integer',
            'sale_estim_status' => 'required|integer',
            'sale_total_days' => 'required|integer',
            'items.*.sale_product_id' => 'required|integer',
            'items.*.sale_estim_item_desc' => 'required|string',
            'items.*.sale_estim_item_qty' => 'required|integer|min:1',
            'items.*.sale_estim_item_price' => 'required|numeric|min:0',
            // 'items.*.sale_estim_item_tax' => 'required|string',
        ], [
            'sale_estim_title.max' => 'The title may not exceed 255 characters.',
            'sale_cus_id.required' => 'Please select a customer.',
            'sale_cus_id.integer' => 'Please select a customer.',
            'sale_estim_number.required' => 'The estimate number is required.',
            'sale_estim_number.unique' => 'An estimate with this number already exists. Estimate numbers must be unique.',
            'sale_estim_date.required' => 'Please select the estimate date.',
            'sale_estim_valid_date.required' => 'Please select the valid until date.',
            'sale_estim_discount_type.required' => 'Please select a discount type.',
            'sale_estim_discount_type.in' => 'The discount type must be either Dollar ($) or Percentage (%).',
            'sale_estim_sub_total.required' => 'Please enter the sub-total amount.',
            'sale_estim_discount_total.required' => 'Please enter the total discount amount.',
            'sale_estim_tax_amount.required' => 'Please enter the tax amount.',
            'sale_estim_final_amount.required' => 'Please enter the final amount.',
            'sale_estim_image.image' => 'The file uploaded must be a valid image.',
            'sale_status.required' => 'Please set the status of the estimate.',
            'sale_estim_status.required' => 'Please set the estimate status.',
            'sale_total_days.required' => 'Please set valid date range.',
            'items.*.sale_product_id.integer' => 'Please select item.',
            'items.*.sale_estim_item_desc.required' => 'Please provide a description for each item.',
            'items.*.sale_estim_item_qty.required' => 'Please enter the quantity for each item.',
            'items.*.sale_estim_item_qty.min' => 'The quantity for each item must be at least 1.',
            'items.*.sale_estim_item_price.required' => 'Please enter the price for each item.',
            'items.*.sale_estim_item_price.min' => 'The price for each item must be at least 0.',
            'items.*.sale_estim_item_tax.required' => 'Please select the tax amount for each item.',
        ]);

      
        $estimate = new Estimates();
        $estimate->fill($request->only([
            'sale_estim_title', 'sale_estim_summary', 'sale_cus_id', 'sale_estim_number',
            'sale_estim_customer_ref', 'sale_estim_date', 'sale_estim_valid_date','sale_total_days', 'sale_estim_item_discount', 'sale_estim_discount_desc', 'sale_estim_discount_type', 'sale_currency_id','sale_estim_sub_total', 'sale_estim_discount_total', 'sale_estim_tax_amount',
            'sale_estim_final_amount', 'sale_estim_notes', 'sale_estim_footer_note',
            'sale_estim_image', 'sale_status', 'sale_estim_status'
        ]));
      
        $estimate->sale_estim_item_discount = $request->sale_estim_item_discount;
        $estimate->sale_currency_id = $request->sale_currency_id;
        $estimate->sale_total_days = $request->sale_total_days;
        $estimate->id = $user->id;
        $estimate->sale_status = 'Draft';

        $estimate->save();
        
      
        
        foreach ($request->input('items') as $item) {
            $estimateItem = new EstimatesItems();
            $taxValues = [];
          
            if (!empty($item['sale_estim_item_tax'])) {
                $taxValues[] = $item['sale_estim_item_tax'];
            }
            if (!empty($item['sale_estim_item_tax2'])) {
                $taxValues[] = $item['sale_estim_item_tax2'];
            }
          
            if (!empty($item['sale_estim_item_tax_new']) && is_array($item['sale_estim_item_tax_new'])) {
                foreach ($item['sale_estim_item_tax_new'] as $additionalTax) {
                    if (!empty($additionalTax)) {
                        $taxValues[] = $additionalTax;
                    }
                }
            }
        
        
        //   dd($taxValues);
            $estimateItem->sale_estim_item_tax = implode(',', $taxValues);
        
            
            unset($item['sale_estim_item_tax'], $item['sale_estim_item_tax2'], $item['sale_estim_item_tax_new']);
        
          
            $estimateItem->fill($item);
        
           
            $estimateItem->id = $user->id;
            $estimateItem->sale_estim_id = $estimate->id;
            $estimateItem->sale_estim_item_status = 1;
        

            $estimateItem->save();
        }
        
        
       
        $sessionData = session('form_data') ?? [];

      
        foreach ($sessionData as $key => $value) {
            // Ignore _token and _method
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            // Check if the key has an "_other" counterpart
            if (strpos($key, '_other') === false) {
                $mname = str_replace('_', ' ', $key);
                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    $otherKey = $key . '_other';
                    $otherValue = $sessionData[$otherKey] ?? null;

                
                    if ($otherValue) {
                        // If there's an _other value, concatenate it with the main key value
                        $mtitle = $value;
                    } else {
                        // Use the main key value if no _other value
                        $mtitle = $value;
                    }

                    $data = [
                        'sale_estim_id' => $estimate->id ?? null,
                        'id' => $user->id ?? null,
                        'mname' => $menu->mname,
                        'mtitle' => $mtitle, // Set mtitle based on other_value if available
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'esti_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                    ];

                    // Update or create the record
                    EstimateCustomizeMenu::updateOrCreate(
                        ['mname' => $menu->mname, 'sale_estim_id' => $estimate->id ?? null],
                        $data
                    );
                }
            }
        }

        // Clear the session data if necessary
        session()->forget('form_data');

        // return redirect()->route('business.estimates.index')->with(['estimate-add' => __('messages.masteradmin.estimate.send_success')]);
        \MasterLogActivity::addToLog('Estimate is create.');

        session()->flash('estimate-add', __('messages.masteradmin.estimate.send_success'));
        return response()->json([
            'redirect_url' => route('business.estimates.view', ['id' => $estimate->id]),
            'message' => __('messages.masteradmin.estimate.send_success')
        ]);

    }
   

    // Method to show the preview page
    public function preview(Request $request)
    {
   
        // Collect the request data
        $previewData = $request->all();
        
        // Pass the collected data to the preview view
        return view('masteradmin.estimates.preview', compact('previewData'));
    }
    

    public function edit($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
     
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $countries = Countries::all();
        $states = collect();
        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        if ($businessDetails && $businessDetails->country_id) {
            $states = States::where('country_id', $businessDetails->country_id)->get();
        }
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
       

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
      
        
        $salestax = SalesTax::all();
       

        $estimates = Estimates::where('sale_estim_id', $id)->with('customer')->firstOrFail();

        $estimatesItems = EstimatesItems::where('sale_estim_id', $id)->get();

        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        $estimatesCustomizeMenu = EstimateCustomizeMenu::where('sale_estim_id', $id)->get();
        $estimatesCustomizeMenuIcon = EstimateCustomizeMenu::where('sale_estim_id', $id)
        ->where('esti_cust_menu_title', 'on')
        ->get(); // Convert collection to array

       

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

        $estimateCustomizeMenu = EstimateCustomizeMenu::where('sale_estim_id', $id)->get();
   
        return view('masteradmin.estimates.edit', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','estimates','estimatesItems','customer_states','ship_state','estimatesCustomizeMenu','specificMenus','HideMenus', 'HideSettings', 'HideDescription','estimateCustomizeMenu','estimatesCustomizeMenuIcon'));

    }

    public function update(Request $request, $estimates_id)
    {
   

        $user = Auth::guard('masteradmins')->user();

        $estimate = Estimates::where([
            'sale_estim_id' => $estimates_id,
            'id' => $user->id
        ])->firstOrFail();

        $dynamicId = $user->user_id; 

        $tableName = $dynamicId . '_py_estimates_details'; 

        $validatedData = $request->validate([
            'sale_estim_title' => 'required|string|max:255',
            'sale_estim_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique($tableName, 'sale_estim_number')->ignore($estimates_id, 'sale_estim_id')
            ],
            'sale_estim_summary' => 'required|string',
            'sale_cus_id' => 'nullable|integer',
            'sale_estim_customer_ref' => 'nullable|string|max:255',
            'sale_estim_date' => 'required|date',
            'sale_estim_valid_date' => 'required|date',
            'sale_estim_discount_desc' => 'nullable|string',
            'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
            'sale_currency_id' => 'required|integer',
            'sale_estim_sub_total' => 'required|numeric',
            'sale_estim_discount_total' => 'required|numeric',
            'sale_estim_tax_amount' => 'required|numeric',
            'sale_estim_final_amount' => 'required|numeric',
            'sale_estim_notes' => 'nullable|string',
            'sale_estim_footer_note' => 'nullable|string',
            'sale_estim_image' => 'nullable|image',
            'sale_estim_item_discount' => 'nullable|integer',
            'sale_total_days' => 'required|integer',
            'items.*.sale_product_id' => 'required|integer',
            'items.*.sale_estim_item_desc' => 'required|string',
            'items.*.sale_estim_item_qty' => 'required|integer|min:1',
            'items.*.sale_estim_item_price' => 'required|numeric|min:0',
            'items.*.sale_estim_item_tax' => 'required|integer',
        
        ],[
            'sale_estim_title.max' => 'The title may not exceed 255 characters.',
            'sale_cus_id.required' => 'Please select a customer.',
            'sale_cus_id.integer' => 'Please select a customer.',
            'sale_estim_number.required' => 'The estimate number is required.',
            'sale_estim_number.unique' => 'An estimate with this number already exists. Estimate numbers must be unique.',
            'sale_estim_date.required' => 'Please select the estimate date.',
            'sale_estim_valid_date.required' => 'Please select the valid until date.',
            'sale_estim_discount_type.required' => 'Please select a discount type.',
            'sale_estim_discount_type.in' => 'The discount type must be either Dollar ($) or Percentage (%).',
            'sale_estim_sub_total.required' => 'Please enter the sub-total amount.',
            'sale_estim_discount_total.required' => 'Please enter the total discount amount.',
            'sale_estim_tax_amount.required' => 'Please enter the tax amount.',
            'sale_estim_final_amount.required' => 'Please enter the final amount.',
            'sale_estim_image.image' => 'The file uploaded must be a valid image.',
            'sale_status.required' => 'Please set the status of the estimate.',
            'sale_estim_status.required' => 'Please set the estimate status.',
            'sale_total_days.required' => 'Please set valid date range.',
            'items.*.sale_product_id.integer' => 'Please select item.',
            'items.*.sale_estim_item_desc.required' => 'Please provide a description for each item.',
            'items.*.sale_estim_item_qty.required' => 'Please enter the quantity for each item.',
            'items.*.sale_estim_item_qty.min' => 'The quantity for each item must be at least 1.',
            'items.*.sale_estim_item_price.required' => 'Please enter the price for each item.',
            'items.*.sale_estim_item_price.min' => 'The price for each item must be at least 0.',
            'items.*.sale_estim_item_tax.required' => 'Please select the tax amount for each item.',
        ]);

        // if()

        $estimate->sale_estim_item_discount = $validatedData['sale_estim_item_discount'];
        $estimate->sale_currency_id = $validatedData['sale_currency_id'];
        $estimate->sale_total_days = $validatedData['sale_total_days'];
        $estimate->where('sale_estim_id', $estimates_id)->update($validatedData);

        
        EstimatesItems::where('sale_estim_id', $estimates_id)->delete();

        foreach ($request->input('items') as $item) {
            $estimateItem = new EstimatesItems();
            $estimateItem->fill($item);
            $estimateItem->id = $user->id; 
            $estimateItem->sale_estim_id = $estimates_id; 
            $estimateItem->sale_estim_item_status = 1;
            $estimateItem->save();
        }

         // Retrieve session data
         $sessionData = session('form_data') ?? [];
         EstimateCustomizeMenu::where('sale_estim_id', $estimates_id)->delete();

         // Iterate through each item in session data
         foreach ($sessionData as $key => $value) {
             // Ignore _token and _method
             if (in_array($key, ['_token', '_method'])) {
                 continue;
             }
 
             // Check if the key has an "_other" counterpart
             if (strpos($key, '_other') === false) {
                 $mname = str_replace('_', ' ', $key);
                 $menu = CustomizeMenu::where('mname', $mname)->first();
 
                 if ($menu) {
                     // Check if the _other counterpart exists in the session
                     $otherKey = $key . '_other';
                     $otherValue = $sessionData[$otherKey] ?? null;
 
                     // Determine the mtitle value
                     if ($otherValue) {
                         // If there's an _other value, concatenate it with the main key value
                         $mtitle = $value;
                     } else {
                         // Use the main key value if no _other value
                         $mtitle = $value;
                     }
 
                     $data = [
                         'sale_estim_id' => $estimates_id ?? null,
                         'id' => $user->id ?? null,
                         'mname' => $menu->mname,
                         'mtitle' => $mtitle, // Set mtitle based on other_value if available
                         'mid' => $menu->cust_menu_id,
                         'is_access' => $value ? 1 : 0,
                         'esti_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                     ];
 
                     // Update or create the record
                     EstimateCustomizeMenu::updateOrCreate(
                         ['mname' => $menu->mname, 'sale_estim_id' => $estimate->id ?? null],
                         $data
                     );
                 }
             }
         }
 
         // Clear the session data if necessary
         session()->forget('form_data');


        \MasterLogActivity::addToLog('Estimate is Edited.');
        session()->flash('estimate-edit', __('messages.masteradmin.estimate.edit_success'));

        return response()->json([
            'redirect_url' => route('business.estimates.edit', ['id' => $estimate->sale_estim_id]),
            'message' => __('messages.masteradmin.estimate.send_success')
        ]);

    }

    public function updateCustomer(Request $request, $sale_cus_id)
    {
      
        // Find the SalesCustomers by sale_cus_id
        $SalesCustomersu = SalesCustomers::where(['sale_cus_id' => $sale_cus_id])->firstOrFail();

        // Validate incoming request data
        $rules = [
            // 'sale_cus_business_name' => 'required|string|max:255',
            'sale_cus_first_name' => 'nullable|string|max:255',
            'sale_cus_last_name' => 'nullable|string|max:255',
            'sale_cus_email' => 'nullable|email|max:255',
            'sale_cus_phone' => 'nullable|numeric',
            'sale_cus_account_number' => 'nullable|numeric',
            'sale_cus_website' => 'nullable|string|max:255',
            'sale_cus_notes' => 'nullable|string|max:255',
            'sale_bill_currency_id' => 'nullable|numeric',
            'sale_bill_address1' => 'nullable|string|max:255',
            'sale_bill_address2' => 'nullable|string|max:255',
            'sale_bill_country_id' => 'nullable|numeric',
            'sale_bill_city_name' => 'nullable|string|max:255',
            'sale_bill_zipcode' => 'nullable|numeric',
            'sale_bill_state_id' => 'nullable|numeric',
            'sale_ship_country_id' => 'nullable|numeric',
            'sale_ship_shipto' => 'nullable|string|max:255',
            'sale_ship_address1' => 'nullable|string|max:255',
            'sale_ship_address2' => 'nullable|string|max:255',
            'sale_ship_city_name' => 'nullable|string|max:255',
            'sale_ship_zipcode' => 'nullable|numeric',
            'sale_ship_state_id' => 'nullable|numeric',
            'sale_ship_phone' => 'nullable|numeric',
            'sale_ship_delivery_desc' => 'nullable|string|max:255',
            'sale_same_address' => 'nullable|boolean',
        ];

        $messages = [
        //    'sale_cus_business_name.required' => 'The business name is required.',
        'sale_cus_business_name.string' => 'The business name must be a valid string.',
        'sale_cus_first_name.string' => 'The first name must be a valid string.',
        'sale_cus_last_name.string' => 'The last name must be a valid string.',
        'sale_cus_email.email' => 'Please enter a valid email address.',
        'sale_cus_phone.numeric' => 'The phone number must be a valid numeric value.',
        'sale_cus_account_number.numeric' => 'The account number must be a valid numeric value.',
        'sale_cus_website.string' => 'The website must be a valid string.',
        'sale_cus_notes.string' => 'The notes must be a valid string.',
        'sale_bill_currency_id.numeric' => 'Please select a valid currency.',
        'sale_bill_address1.string' => 'The billing address line 1 must be a valid string.',
        'sale_bill_address2.string' => 'The billing address line 2 must be a valid string.',
        'sale_bill_country_id.numeric' => 'Please select a valid country.',
        'sale_bill_city_name.string' => 'The billing city name must be a valid string.',
        'sale_bill_zipcode.numeric' => 'The billing zip code must be a valid numeric value.',
        'sale_bill_state_id.numeric' => 'Please select a valid state.',
        'sale_ship_country_id.numeric' => 'Please select a valid shipping country.',
        'sale_ship_shipto.string' => 'The shipping recipient must be a valid string.',
        'sale_ship_address1.string' => 'The shipping address line 1 must be a valid string.',
        'sale_ship_address2.string' => 'The shipping address line 2 must be a valid string.',
        'sale_ship_city_name.string' => 'The shipping city name must be a valid string.',
        'sale_ship_zipcode.numeric' => 'The shipping zip code must be a valid numeric value.',
        'sale_ship_state_id.numeric' => 'Please select a valid shipping state.',
        'sale_ship_phone.numeric' => 'The shipping phone number must be a valid numeric value.',
        'sale_ship_delivery_desc.string' => 'The delivery description must be a valid string.',
        'sale_same_address.boolean' => 'The "Same Address" field must be true or false.',
        ];

        $validatedData = $request->validate($rules, $messages);

    
        // Handle checkboxes
        $validatedData['sale_same_address'] = $request->has('sale_same_address') ? 'on' : 'off';

        // Update the SalesCustomers record
        $SalesCustomersu->where(['sale_cus_id' => $sale_cus_id])->update($validatedData);

        

        $SalesCustomersu = SalesCustomers::where(['sale_cus_id' => $sale_cus_id])->firstOrFail();
        $SalesCustomersu->load('state', 'country');

        // Redirect with a success message
      
        if ($SalesCustomersu) {
            return response()->json(['customer' => $SalesCustomersu]);
        } else {
            return response()->json(['error' => 'customer not found'], 404);
        }
    }

    public function listCustomers()
    {
        $customers = SalesCustomers::get(['sale_cus_id', 'sale_cus_business_name']);
        
       
        return response()->json($customers);
    }

    //remove
    public function destroy($id)
    {
        //
        $user = Auth::guard('masteradmins')->user();

        $estimates = Estimates::where(['sale_estim_id' => $id, 'id' => $user->id])->firstOrFail();

        // Delete the estimate details
        $estimates->where('sale_estim_id', $id)->delete();

        EstimatesItems::where('sale_estim_id', $id)->delete();

        EstimateCustomizeMenu::where('sale_estim_id', $id)->delete();

        \MasterLogActivity::addToLog('Estimates details Deleted.'); 

       
        return response()->json(['success' => true, 'message' => 'Estimate deleted successfully.']);
       

        // return redirect()->route('business.estimates.index')->with('estimate-delete', __('messages.masteradmin.estimate.delete_success'));

    }

    public function menuUpdate(Request $request) 
    {   
       
        Session::put('form_data', $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully'
        ]);

    }

    public function getMenuSessionData()
    {
        $sessionData = Session::get('form_data', []);
       
        return response()->json($sessionData);
    }

    public function view($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
       
        $user_id = $user->user_id;
       
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $countries = Countries::all();
        $states = collect();
        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        if ($businessDetails && $businessDetails->country_id) {
            $states = States::where('country_id', $businessDetails->country_id)->get();
        }
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
       

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
      
        
        $salestax = SalesTax::all();
      

        $estimates = Estimates::where('sale_estim_id', $id)->with('customer')->firstOrFail();

        $estimatesItems = EstimatesItems::where('sale_estim_id', $id)->with('estimate_product', 'item_tax')->get();
        
        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        // $states = States::get();

     
        return view('masteradmin.estimates.view', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','estimates','estimatesItems','customer_states','ship_state','user_id'));

    }
    
    public function duplicate($id, Request $request): View
    {
        $user = Auth::guard('masteradmins')->user();
      
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $countries = Countries::all();
        $states = collect();
        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        if ($businessDetails && $businessDetails->country_id) {
            $states = States::where('country_id', $businessDetails->country_id)->get();
        }
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
       

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
      
        $salestax = SalesTax::all();
      

        $estimates = Estimates::where('sale_estim_id', $id)->with('customer')->firstOrFail();

        $lastEstimate = Estimates::orderBy('sale_estim_id', 'desc')->first();

        $newId = $lastEstimate ? $lastEstimate->sale_estim_id + 1 : 1;
      

        $estimatesItems = EstimatesItems::where('sale_estim_id', $id)->get();

        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

        $estimateCustomizeMenu = EstimateCustomizeMenu::where('sale_estim_id', $id)->get();
        // $states = States::get();

        $estimatesCustomizeMenu = EstimateCustomizeMenu::where('sale_estim_id', $id)->get();
      

      
        return view('masteradmin.estimates.duplicate', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','estimates','estimatesItems','customer_states','ship_state','newId','HideMenus','estimateCustomizeMenu','estimatesCustomizeMenu','specificMenus','HideSettings','HideDescription'));
    }

    public function duplicateStore(Request $request)
    {
       

        $user = Auth::guard('masteradmins')->user();

        $dynamicId = $user->user_id; 

        $tableName = $dynamicId . '_py_estimates_details'; 

      $request->validate([
        'sale_estim_title' => 'nullable|string|max:255',
        'sale_estim_summary' => 'nullable|string',
        'sale_cus_id' => 'nullable|integer',
        'sale_estim_number' => 'required|string|max:255|unique:' . $tableName . ',sale_estim_number',
        'sale_estim_customer_ref' => 'nullable|string|max:255',
        'sale_estim_date' => 'required|date',
        'sale_estim_valid_date' => 'required|date',
        'sale_estim_discount_desc' => 'nullable|string',
        'sale_estim_discount_type' => 'required|in:1,2', // 1 for $, 2 for %
        'sale_currency_id' => 'required|integer',
        'sale_estim_sub_total' => 'required|numeric',
        'sale_estim_discount_total' => 'required|numeric',
        'sale_estim_tax_amount' => 'required|numeric',
        'sale_estim_final_amount' => 'required|numeric',
        'sale_estim_notes' => 'nullable|string',
        'sale_estim_footer_note' => 'nullable|string',
        'sale_estim_image' => 'nullable|image',
        'sale_status' => 'required|integer',
        'sale_estim_item_discount' => 'nullable|integer',
        'sale_total_days' => 'required|integer',
        ],[
            'sale_estim_number.required' => 'The estimate number is required.',
            'sale_estim_number.unique' => 'An estimate with this number already exists. Estimate numbers must be unique.',
        ]);


        $estimate = new Estimates();
        $estimate->fill($request->only([
            'sale_estim_title', 'sale_estim_summary', 'sale_cus_id', 'sale_estim_number',
            'sale_estim_customer_ref', 'sale_estim_date', 'sale_estim_valid_date','sale_total_days', 'sale_estim_item_discount', 'sale_estim_discount_desc', 'sale_estim_discount_type', 'sale_currency_id','sale_estim_sub_total', 'sale_estim_discount_total', 'sale_estim_tax_amount',
            'sale_estim_final_amount', 'sale_estim_notes', 'sale_estim_footer_note',
            'sale_estim_image', 'sale_status'
        ]));

        $user = Auth::guard('masteradmins')->user();
        $estimate->sale_estim_item_discount = $request->sale_estim_item_discount;
        $estimate->sale_currency_id = $request->sale_currency_id;
        $estimate->sale_total_days = $request->sale_total_days;
        $estimate->id = $user->id;
        $estimate->sale_status = 'Draft';
        $estimate->sale_estim_status = 1;
        
       
        $estimate->save();

        foreach ($request->input('items') as $item) {
            $estimateItem = new EstimatesItems();
            
            $estimateItem->fill($item);

            $estimateItem->id = $user->id;
            $estimateItem->sale_estim_id = $estimate->id; 
            $estimateItem->sale_estim_item_status = 1;

            $estimateItem->save();
        }

        // Retrieve session data
        $sessionData = session('form_data') ?? [];
        EstimateCustomizeMenu::where('sale_estim_id', $estimate->id)->delete();

        // Iterate through each item in session data
        foreach ($sessionData as $key => $value) {
            // Ignore _token and _method
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            // Check if the key has an "_other" counterpart
            if (strpos($key, '_other') === false) {
                $mname = str_replace('_', ' ', $key);
                $menu = CustomizeMenu::where('mname', $mname)->first();

                if ($menu) {
                    // Check if the _other counterpart exists in the session
                    $otherKey = $key . '_other';
                    $otherValue = $sessionData[$otherKey] ?? null;

                    // Determine the mtitle value
                    if ($otherValue) {
                        // If there's an _other value, concatenate it with the main key value
                        $mtitle = $value;
                    } else {
                        // Use the main key value if no _other value
                        $mtitle = $value;
                    }

                    $data = [
                        'sale_estim_id' => $estimate->id ?? null,
                        'id' => $user->id ?? null,
                        'mname' => $menu->mname,
                        'mtitle' => $mtitle, // Set mtitle based on other_value if available
                        'mid' => $menu->cust_menu_id,
                        'is_access' => $value ? 1 : 0,
                        'esti_cust_menu_title' => $otherValue ?? $value, // Use _other value if available
                    ];

                    // Update or create the record
                    EstimateCustomizeMenu::updateOrCreate(
                        ['mname' => $menu->mname, 'sale_estim_id' => $estimate->id ?? null],
                        $data
                    );
                }
            }
        }

        // Clear the session data if necessary
        session()->forget('form_data');

      
        \MasterLogActivity::addToLog('Estimate is Duplicate.');

        return response()->json([
            'redirect_url' => route('business.estimates.view', ['id' => $estimate->id]),
        ]);

    }
    
    // public function statusStore(Request $request, $id)
    // {
    //     $user = Auth::guard('masteradmins')->user();

    //     $estimate = Estimates::where([
    //         'sale_estim_id' => $id,
    //         'id' => $user->id
    //     ])->firstOrFail();
    //     // dd($estimate); 

    //     $validated = $request->validate([
    //         'sale_status' => 'required|string|max:255',
    //     ]);

    //     $estimate->where('sale_estim_id', $id)->update($validated);

    //     return response()->json(['success' => true, 'message' => 'Estimate saved successfully!']);
    // }

    // public function statusStore(Request $request, $id)
    // {
    //     $user = Auth::guard('masteradmins')->user();

    //     $estimate = Estimates::where([
    //         'sale_estim_id' => $id,
    //         'id' => $user->id
    //     ])->firstOrFail();

    //     $validated = $request->validate([
    //         'sale_status' => 'required|string|max:255',
    //     ]);

    //     $estimate->where('sale_estim_id', $id)->update($validated);

    //     $response = ['success' => true, 'message' => 'Estimate saved successfully!'];

    //     if ($validated['sale_status'] === 'Convert to Invoice') {
    //         $response['redirect_url'] = route('business.estimates.viewInvoice', ['id' => $estimate->sale_estim_id]);
    //     } elseif ($validated['sale_status'] === 'Sent') {
    //         $response['redirect_url'] = route('business.estimate.send', [ $estimate->sale_estim_id, $user->user_id]); 
    //     }

    //     return response()->json($response);
    // }

    public function statusStore(Request $request, $id)
    {
        $user = Auth::guard('masteradmins')->user();

        // Fetch the invoice record for the authenticated user and provided ID
        $estimates = Estimates::where([
            'sale_estim_id' => $id,
            'id' => $user->id
        ])->firstOrFail();

        // Define the status transition map
        $statusMap = [
            'Draft' => 'Saved', // Clicking "Approve" changes "Draft" to "Saved"
            'Saved' => 'Send', // Clicking "Send" changes "Saved" to "Sent"
            'Sent' => 'Converted', // Clicking "Convert to Invoice" changes "Sent" to "Converted"
            'Converted' => 'Duplicate', // Clicking "Duplicate" changes "Converted" to "Duplicate"
        ];
    

    $currentStatus = $estimates->sale_status;

    $nextStatus = $statusMap[$currentStatus] ?? null;

  

        if ($nextStatus) {

            if($nextStatus != 'Duplicate'){
                $estimates->where('sale_estim_id', $id)->update(['sale_status' => $nextStatus]);
            }

            $response = [
                'success' => true,
                'message' => "Invoice status updated to $nextStatus successfully!"
            ];
           
            switch ($nextStatus) {
               
                case 'Send':
                    $response['redirect_url'] = route('business.estimate.send', [$estimates->sale_estim_id, $user->user_id]);
                    break;
                case 'Converted':
                    $response['redirect_url'] = route('business.estimates.viewInvoice', [$estimates->sale_estim_id]);
                    break;
                case 'Duplicate':
                    $response['redirect_url'] = route('business.estimates.duplicate', [$estimates->sale_estim_id]);
                    break;
                default:
                    $response['redirect_url'] = route('business.estimates.index'); // Assuming you have an index route
                    break;
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'No further status updates available!',
            ];
        }

        return response()->json($response);
    }


    public function send(Request $request, $id, $slug)
    {
        $estimate = Estimates::where('sale_estim_id', $id)->firstOrFail();

        $validated = [
            'sale_status' => 'Sent', 
        ];

        $estimate->where('sale_estim_id', $id)->update($validated);

        // Encrypt the IDs
        $encryptedEstimateId = Crypt::encryptString($estimate->sale_estim_id);
        $encryptedUserID = Crypt::encryptString($slug);

        // Encode encrypted values to base64
        $encodedEstimateId = base64_encode($encryptedEstimateId);
        $encodedUserID = base64_encode($encryptedUserID);

        // Optionally, use a more URL-safe encoding
        $shortEncodedEstimateId = urlencode($encodedEstimateId);
        $shortEncodedUserID = urlencode($encodedUserID);
        
        $estimateViewUrl = route('business.estimate.sendview', [$shortEncodedEstimateId, $shortEncodedUserID]);


       

        $customer = SalesCustomers::where('sale_cus_id', $estimate->sale_cus_id)->first();
        if (!$customer || empty($customer->sale_cus_email)) {
            return back()->with('error', 'Customer email not found.');
        }

        \MasterLogActivity::addToLog('Admin Estimate Sent.');

        Mail::to($customer->sale_cus_email)->send(new EstimateViewMail($estimateViewUrl));

        $currency = Countries::find($estimate->sale_currency_id);

        $currencySymbol = $currency ? $currency->currency_symbol : '';
        
        $logMsg = "Estimate #{$estimate->sale_estim_number} for {$currencySymbol}{$estimate->sale_estim_final_amount}";
     

        SentLog::create([
            'log_type' => '1',
            'user_id' => Auth::guard('masteradmins')->id(),
            'id' => $estimate->sale_estim_id,
            'cust_id'=> $estimate->sale_cus_id,
            'log_msg' => $logMsg,
            'status' => 'Sent',
            'log_status' => '1', 
        ]);

      


        return redirect()->back()->with('success', 'Estimate link sent to the customer successfully.');
    }
    
    public function sendView(Request $request, $id, $slug)
    {
        try {
            $id1= $id;
            $slug1 = $slug;
            $decodedEstimateId = urldecode($id);
            $decodedUserID = urldecode($slug);
    
            $base64EstimateId = base64_decode($decodedEstimateId);
            $base64UserID = base64_decode($decodedUserID);
    
            $decryptedEstimateId = Crypt::decryptString($base64EstimateId);
            $decryptedUserID = Crypt::decryptString($base64UserID);
          
            
            $tableName = $decryptedUserID . '_py_business_details';
            
            $businessDetails = \DB::table($tableName)
                ->join('py_states', 'py_states.id', '=', $tableName . '.state_id')
                ->join('py_countries', 'py_countries.id', '=', $tableName . '.country_id')
                ->select($tableName . '.*', 'py_states.name as state_name', 'py_countries.name as country_name')
                ->first();
            
            $tableNameCustomer = $decryptedUserID . '_py_sale_customers';
            $customers = \DB::table($tableNameCustomer)
                ->where('id', $businessDetails->id)
                ->first();

            $currencys = \DB::table('py_countries')->get();

            


            // $customers = SalesCustomers::where('id', $businessDetails->id)->first();
    
            // $currencys = Countries::all();

            $tableNameEstimates = $decryptedUserID . '_py_estimates_details';
            $tableNameStates = 'py_states'; // Assuming static names for states and countries
            $tableNameCountries = 'py_countries';

            $estimates = \DB::table($tableNameEstimates)
            ->leftJoin($tableNameCustomer, $tableNameCustomer . '.sale_cus_id', '=', $tableNameEstimates . '.sale_cus_id')
            // Join states and countries for billing address
            ->leftJoin($tableNameStates . ' as bill_states', 'bill_states.id', '=', $tableNameCustomer . '.sale_bill_state_id')
            ->leftJoin($tableNameCountries . ' as bill_countries', 'bill_countries.id', '=', $tableNameCustomer . '.sale_bill_country_id')
            // Join states and countries for shipping address
            ->leftJoin($tableNameStates . ' as ship_states', 'ship_states.id', '=', $tableNameCustomer . '.sale_ship_state_id')
            ->leftJoin($tableNameCountries . ' as ship_countries', 'ship_countries.id', '=', $tableNameCustomer . '.sale_ship_country_id')
            ->where($tableNameEstimates . '.sale_estim_id', $decryptedEstimateId)
            ->select(
                $tableNameEstimates . '.*',
                $tableNameCustomer . '.*',
                'bill_states.name as bill_state_name',
                'bill_countries.name as bill_country_name',
                'ship_states.name as ship_state_name',
                'ship_countries.name as ship_country_name'
            )
            ->first();
            
            $tableNameEstimatesItems = $decryptedUserID . '_py_estimates_items';
            $tableNameProduct = $decryptedUserID . '_py_sale_product';
            $tableNameTax = $decryptedUserID . '_py_sales_tax';

            $estimatesItems = \DB::table($tableNameEstimatesItems)
            ->leftJoin($tableNameProduct, $tableNameProduct . '.sale_product_id', '=', $tableNameEstimatesItems . '.sale_product_id')
            ->leftJoin($tableNameTax, $tableNameTax . '.tax_id', '=', $tableNameEstimatesItems . '.sale_estim_item_tax')
            ->where($tableNameEstimatesItems . '.sale_estim_id', $decryptedEstimateId)
            ->select(
                $tableNameEstimatesItems . '.*',
                $tableNameProduct . '.*',
                $tableNameTax . '.*'
            )
            ->get();

            $currency = $currencys->firstWhere('id', $estimates->sale_currency_id);

            if ($request->has('download')) {
                $pdf = PDF::loadView('masteradmin.estimates.pdf', compact('businessDetails', 'currencys', 'estimates', 'estimatesItems','currency','id','slug'))
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);
            
                // return $pdf->stream('estimate.pdf');
                return $pdf->download('estimate.pdf');
                        }

            return view('masteradmin.estimates.send', compact('businessDetails', 'currencys', 'estimates', 'estimatesItems','currency','id','slug'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid estimate link.');
        }
    }

    public function authsendView(Request $request, $id, $slug)
    {
        try {
           
            $id1= $id;
            $slug1 = $slug;
    
            $base64UserID =$id;
    
            $decryptedEstimateId = $id;
            $decryptedUserID = $slug;
          

            
            $tableName = $decryptedUserID . '_py_business_details';
         
            
            try {
                $businessDetails = \DB::table($tableName)
                    ->join('py_states', 'py_states.id', '=', $tableName . '.state_id')
                    ->join('py_countries', 'py_countries.id', '=', $tableName . '.country_id')
                    ->select($tableName . '.*', 'py_states.name as state_name', 'py_countries.name as country_name')
                    ->first();
            
                if (!$businessDetails) {
                    abort(404);
                }
            
            } catch (QueryException $e) {
                if ($e->getCode() == '42S02') {
                    abort(404); 
                } else {
                    throw $e;
                }
            }
            
            $tableNameCustomer = $decryptedUserID . '_py_sale_customers';
            $customers = \DB::table($tableNameCustomer)
                ->where('id', $businessDetails->id)
                ->first();


            $currencys = \DB::table('py_countries')->get();

            // $customers = SalesCustomers::where('id', $businessDetails->id)->first();
    
            // $currencys = Countries::all();

            $tableNameEstimates = $decryptedUserID . '_py_estimates_details';
            $tableNameStates = 'py_states'; 
            $tableNameCountries = 'py_countries';

            try {
                $estimates = \DB::table($tableNameEstimates)
            ->leftJoin($tableNameCustomer, $tableNameCustomer . '.sale_cus_id', '=', $tableNameEstimates . '.sale_cus_id')
            // Join states and countries for billing address
            ->leftJoin($tableNameStates . ' as bill_states', 'bill_states.id', '=', $tableNameCustomer . '.sale_bill_state_id')
            ->leftJoin($tableNameCountries . ' as bill_countries', 'bill_countries.id', '=', $tableNameCustomer . '.sale_bill_country_id')
            // Join states and countries for shipping address
            ->leftJoin($tableNameStates . ' as ship_states', 'ship_states.id', '=', $tableNameCustomer . '.sale_ship_state_id')
            ->leftJoin($tableNameCountries . ' as ship_countries', 'ship_countries.id', '=', $tableNameCustomer . '.sale_ship_country_id')
            ->where($tableNameEstimates . '.sale_estim_id', $decryptedEstimateId)
            ->select(
                $tableNameEstimates . '.*',
                $tableNameCustomer . '.*',
                'bill_states.name as bill_state_name',
                'bill_countries.name as bill_country_name',
                'ship_states.name as ship_state_name',
                'ship_countries.name as ship_country_name'
            )
            ->first();
            
                if (!$estimates) {
                    abort(404); 
                }
            
            } catch (QueryException $e) {
                if ($e->getCode() == '42S02') {
                    abort(404);
                } else {
                    throw $e;
                }
            }

           
            
            $tableNameEstimatesItems = $decryptedUserID . '_py_estimates_items';
            $tableNameProduct = $decryptedUserID . '_py_sale_product';
            $tableNameTax = $decryptedUserID . '_py_sales_tax';

            $estimatesItems = \DB::table($tableNameEstimatesItems)
            ->leftJoin($tableNameProduct, $tableNameProduct . '.sale_product_id', '=', $tableNameEstimatesItems . '.sale_product_id')
            ->leftJoin($tableNameTax, $tableNameTax . '.tax_id', '=', $tableNameEstimatesItems . '.sale_estim_item_tax')
            ->where($tableNameEstimatesItems . '.sale_estim_id', $decryptedEstimateId)
            ->select(
                $tableNameEstimatesItems . '.*',
                $tableNameProduct . '.*',
                $tableNameTax . '.*'
            )
            ->get();

            $currency = $currencys->firstWhere('id', $estimates->sale_currency_id);

            if ($request->has('download')) {
                $pdf = PDF::loadView('masteradmin.estimates.pdf', compact('businessDetails', 'currencys', 'estimates', 'estimatesItems','currency','id','slug'))
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);
            
                // return $pdf->stream('estimate.pdf');
                return $pdf->download('estimate.pdf');
                        }

            if ($request->has('print')) {

                return view('masteradmin.estimates.print', compact('businessDetails', 'currencys', 'estimates', 'estimatesItems','currency','id','slug'));
            }            

            return view('masteradmin.estimates.print', compact('businessDetails', 'currencys', 'estimates', 'estimatesItems','currency','id','slug'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid estimate link.');
        }
    }
    
    public function viewInvoice($id, Request $request): View
    {

        $user = Auth::guard('masteradmins')->user();
      
        $businessDetails = BusinessDetails::with(['state', 'country'])->first();

        $countries = Countries::all();
        $states = collect();
        $currency = null;
        if (isset($businessDetails->bus_currency)) {
            $currency = Countries::where('id', $businessDetails->bus_currency)->first();
        }

        if ($businessDetails && $businessDetails->country_id) {
            $states = States::where('country_id', $businessDetails->country_id)->get();
        }
       

        $salecustomer = SalesCustomers::where('id', $user->id)->get();

        $customers = SalesCustomers::where('id', $user->id)->first();
     

        $products = SalesProduct::where('id', $user->id)->get();
        $currencys = Countries::get();
      
        
        $salestax = SalesTax::all();

        $estimates = Estimates::where('sale_estim_id', $id)->with('customer')->firstOrFail();

        $estimate = Estimates::where('sale_estim_id', $id)->firstOrFail();

        $validated = [
            'sale_status' => 'Converted', 
        ];

        $estimate->where('sale_estim_id', $id)->update($validated);


        $lastInvoice = InvoicesDetails::orderBy('sale_inv_id', 'desc')->first();

        $newId = $lastInvoice ? $lastInvoice->sale_inv_id + 1 : 1;
      
        $estimatesItems = EstimatesItems::where('sale_estim_id', $id)->get();

        $customer_states = collect();
        if ($customers && $customers->sale_bill_country_id) {
            $customer_states = States::where('country_id', $customers->sale_bill_country_id)->get();
        }

        $ship_state = collect();
        if ($customers && $customers->sale_ship_country_id) {
            $ship_state = States::where('country_id', $customers->sale_ship_country_id)->get();
        }

        $specificMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [1, 2, 3, 4])
        ->get();

        $HideMenus = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [5, 6, 7, 8])
        ->get();

        $HideSettings = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [10])
        ->get();
        
        $HideDescription = CustomizeMenu::with('children')
        ->whereIn('cust_menu_id', [9])
        ->get();

        $estimateCustomizeMenu = EstimateCustomizeMenu::where('sale_estim_id', $id)->get();
        // $states = States::get();

        $estimatesCustomizeMenu = EstimateCustomizeMenu::where('sale_estim_id', $id)->get();
    

        // $states = States::get();

        
        return view('masteradmin.invoices.edit-invoice', compact('businessDetails','countries','states','currency','salecustomer','products','currencys','salestax','estimates','estimatesItems','customer_states','ship_state','newId','specificMenus','HideMenus','HideSettings','HideDescription','estimateCustomizeMenu','estimatesCustomizeMenu'));

    }

    public function getTaxNames(Request $request)
{
    $request->validate([
        'tax_id' => 'required|integer|exists:taxes,id',  // Assuming you have a 'taxes' table
    ]);

    $taxId = $request->input('tax_id');
    $tax = SalesTax::find($taxId); // Assuming you have a Tax model

    // Prepare the response with tax names (you can modify this logic to get more data)
    $taxNames = $tax ? $tax->name : ''; // Assuming 'name' is the tax name column

    // Return the response as JSON
    return response()->json([
        'tax_names' => $taxNames
    ]);
}
}

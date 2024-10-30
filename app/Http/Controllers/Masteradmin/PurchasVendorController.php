<?php

namespace App\Http\Controllers\Masteradmin;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchasVendor;
use App\Models\Countries;
use App\Models\States;
use App\Models\PurchasVendorBankDetail;
use App\Models\Bills;
use App\Models\ChartAccount;
use App\Models\RecordPayment;
use App\Models\PaymentMethod;


class PurchasVendorController extends Controller
{
    //
    public function index(): View
    {
        $PurchasVendor = PurchasVendor::with('tax','bankDetails')->get();
        return view('masteradmin.vendor.index')->with('PurchasVendor', $PurchasVendor);
    }

    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        $States = States::all();

        // // Fetch ChartAccount records based on type_id
        // $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        // $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.vendor.add', compact('Country', 'States'));
    }
    public function vendorStates($country_id)
    {

        // dd($country_id);
        $states = States::where('country_id', $country_id)->get();
        return response()->json($states);
    }
   
    public function store(Request $request)
{
    $user = Auth::guard('masteradmins')->user();
    
    // Validate the incoming request
    $request->validate([
        'purchases_vendor_name' => 'required|string|max:255',
        'purchases_vendor_first_name' => 'nullable|string|max:255',
        'purchases_vendor_last_name' => 'nullable|string|max:255',
        'purchases_vendor_email' => 'nullable|string|max:255',
        'purchases_vendor_country_id' => 'nullable|string|max:255',
        'purchases_vendor_security_number'=> 'nullable|string|max:255',
        'purchases_vendor_state_id' => 'nullable|string|max:255',
        'purchases_vendor_address1' => 'nullable|string|max:255',
        'purchases_vendor_address2' => 'nullable|string|max:255',
        'purchases_vendor_city_name' => 'nullable|string|max:255',
        'purchases_vendor_zipcode' => 'nullable|string|max:255',
        'purchases_vendor_account_number' => 'nullable|string|max:255',
        'purchases_vendor_phone' => 'nullable|string|max:255',
        'purchases_vendor_mobile' => 'nullable|string|max:255',
        'purchases_vendor_website' => 'nullable|string|max:255',
        'purchases_vendor_currency_id' => 'nullable|string|max:255',
        'type' => 'required|string|in:Vendor,1099-NEC Contractor',
    ], [
        'purchases_vendor_name.required' => 'The name field is required.',
        'type.required' => 'The vendor type field is required.',
        // 'type.in' => 'The selected vendor type is invalid.',
    ]);      



    

    // Capture the selected radio button value
    $type = $request->input('type'); // This will be either 'Regular' or '1099-NEC Contractor'
   
    // Prepare the data for insertion
    $validatedData = $request->all();
    $validatedData['purchases_vendor_type'] = $type; // Store the value directly in the 'purchases_vendor_type' column
    $validatedData['id'] = $user->id;
    $validatedData['purchases_vendor_status'] = 1;
    
    // Insert the data into the database
    PurchasVendor::create([
        'purchases_vendor_name' => $validatedData['purchases_vendor_name'],
        'purchases_vendor_first_name' => $validatedData['purchases_vendor_first_name'],
        'purchases_vendor_last_name' => $validatedData['purchases_vendor_last_name'],
        'purchases_vendor_email' => $validatedData['purchases_vendor_email'],
        'purchases_vendor_country_id' => $validatedData['purchases_vendor_country_id'],
        'purchases_vendor_currency_id' => $validatedData['purchases_vendor_currency_id'],
        'purchases_vendor_state_id' => $validatedData['purchases_vendor_state_id'],
        'purchases_vendor_type' => $validatedData['purchases_vendor_type'], // Store directly
        'purchases_contractor_type' => $validatedData['purchases_contractor_type'],
        'purchases_vendor_security_number' => $validatedData['purchases_vendor_security_number'],
        'purchases_vendor_address1' => $validatedData['purchases_vendor_address1'],
        'purchases_vendor_address2' => $validatedData['purchases_vendor_address2'],
        'purchases_vendor_city_name' => $validatedData['purchases_vendor_city_name'],
        'purchases_vendor_zipcode' => $validatedData['purchases_vendor_zipcode'],
        'purchases_vendor_account_number' => $validatedData['purchases_vendor_account_number'],
        'purchases_vendor_phone' => $validatedData['purchases_vendor_phone'],
        'purchases_vendor_mobile' => $validatedData['purchases_vendor_mobile'],
        'purchases_vendor_website' => $validatedData['purchases_vendor_website'],
        'id' => $validatedData['id'],
        'purchases_vendor_status' => 1,
    ]);

    return redirect()->route('business.purchasvendor.index')->with(['purchases-vendor-add' => __('messages.masteradmin.purchases-vendor.send_success')]);
}



    public function edit($purchases_vendor_id, Request $request): View
    {
        $PurchasVendore = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();
        $Country = Countries::all(); // Fetch all countries
        $States = States::all();
        // Fetch ChartAccount records based on type_id
        // $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        // $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.vendor.edit', compact('PurchasVendore', 'Country', 'States'));
    }

    /**
     * Update the specified resource in storage.
     */
   
//     public function update(Request $request, $purchases_vendor_id): RedirectResponse
// {
//     $PurchasVendoru = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();

//     // Validate the incoming request
//     $validatedData = $request->validate([
//         'purchases_vendor_name' => 'required|string|max:255',
//         'purchases_vendor_security_number' => 'nullable|string|max:255',
//         'purchases_vendor_first_name' => 'nullable|string|max:255',
//         'purchases_vendor_last_name' => 'nullable|string|max:255',
//         'purchases_vendor_email' => 'nullable|string|max:255',
//         'purchases_vendor_country_id' => 'nullable|string|max:255',
//         'purchases_vendor_state_id' => 'nullable|string|max:255',
//         'purchases_vendor_address1' => 'nullable|string|max:255',
//         'purchases_vendor_address2' => 'nullable|string|max:255',
//         'purchases_vendor_city_name' => 'nullable|string|max:255',
//         'purchases_vendor_zipcode' => 'nullable|string|max:255',
//         'purchases_vendor_account_number' => 'nullable|string|max:255',
//         'purchases_vendor_phone' => 'nullable|string|max:255',
//         'purchases_vendor_fax' => 'nullable|string|max:255',
//         'purchases_vendor_mobile' => 'nullable|string|max:255',
//         'purchases_vendor_toll_free' => 'nullable|string|max:255',
//         'purchases_vendor_website' => 'nullable|string|max:255',
//         'purchases_vendor_currency_id' => 'nullable|string|max:255',
//         'purchases_contractor_type'=>'required|string|in:Individual,Business',
//         'type' => 'required|string|in:Vendor,1099-NEC Contractor', // Add validation for type
//     ]);

//     // Capture the selected radio button value
//     $type = $request->input('type'); 
//     $purchases_contractor_type = $request->input('purchases_contractor_type');// This will be either 'Regular' or '1099-NEC Contractor'
//     $validatedData['purchases_vendor_type'] = $type; // Store the value directly in the 'purchases_vendor_type' column
//     $validatedData['purchases_contractor_type'] = $purchases_contractor_type; 
//     // Update the vendor record with validated data
//     $PurchasVendoru->where('purchases_vendor_id', $purchases_vendor_id)->update($validatedData);

//     return redirect()->route('business.purchasvendor.edit', ['PurchasesVendor' => $PurchasVendoru->purchases_vendor_id])
//         ->with('purchases-vendor-edit', __('messages.masteradmin.purchases-vendor.edit_purchasesvendor_success'));
// }
public function update(Request $request, $purchases_vendor_id): RedirectResponse
{
    // Fetch the vendor record
    $PurchasVendoru = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();

    // Validate the incoming request
    $validatedData = $request->validate([
        'purchases_vendor_name' => 'required|string|max:255',
        'purchases_vendor_security_number' => 'nullable|string|max:255',
        'purchases_vendor_first_name' => 'nullable|string|max:255',
        'purchases_vendor_last_name' => 'nullable|string|max:255',
        'purchases_vendor_email' => 'nullable|string|max:255',
        'purchases_vendor_country_id' => 'nullable|string|max:255',
        'purchases_vendor_state_id' => 'nullable|string|max:255',
        'purchases_vendor_address1' => 'nullable|string|max:255',
        'purchases_vendor_address2' => 'nullable|string|max:255',
        'purchases_vendor_city_name' => 'nullable|string|max:255',
        'purchases_vendor_zipcode' => 'nullable|string|max:255',
        'purchases_vendor_account_number' => 'nullable|string|max:255',
        'purchases_vendor_phone' => 'nullable|string|max:255',
        'purchases_vendor_fax' => 'nullable|string|max:255',
        'purchases_vendor_mobile' => 'nullable|string|max:255',
        'purchases_vendor_toll_free' => 'nullable|string|max:255',
        'purchases_vendor_website' => 'nullable|string|max:255',
        'purchases_vendor_currency_id' => 'nullable|string|max:255',
        // 'purchases_contractor_type' => 'required|string|in:Individual,Business',
        // 'type' => 'required|string|in:Vendor,1099-NEC Contractor', // Add validation for type
    ]);
    // dd($validatedData);    // Capture the selected radio button value
    $type = $request->input('type'); 
    $purchases_contractor_type = $request->input('purchases_contractor_type'); // This will be either 'Individual' or 'Business'
    
    // Assign values to the validated data
    $validatedData['purchases_vendor_type'] = $type; // Store the value directly in the 'purchases_vendor_type' column
    $validatedData['purchases_contractor_type'] = $purchases_contractor_type; 
    
    // Update the vendor record with validated data
    $PurchasVendoru->where('purchases_vendor_id', $purchases_vendor_id)->update($validatedData);

    // Redirect with success message
    return redirect()->route('business.purchasvendor.edit', ['PurchasesVendor' => $PurchasVendoru->purchases_vendor_id])
        ->with('purchases-vendor-edit', __('messages.masteradmin.purchases-vendor.edit_purchasesvendor_success'));
}


    public function destroy($purchases_vendor_id): RedirectResponse
    {

        $user = Auth::guard('masteradmins')->user();

        $PurchasVendor = PurchasVendor::where(['purchases_vendor_id' => $purchases_vendor_id, 'id' => $user->id])->firstOrFail();

        $PurchasVendor->where('purchases_vendor_id', $purchases_vendor_id)->delete();
        return redirect()->route('business.purchasvendor.index')->with('purchases-vendor-delete', __('messages.masteradmin.purchases-vendor.delete_purchasesvendor_success'));

    }
    public function show(Request $request,$purchases_vendor_id)
    {
        // Fetch the vendor details based on the ID
        $PurchasVendor = PurchasVendor::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();
        $Country = Countries::all(); // Fetch all countries
        $States = States::all();

        $query = Bills::where('sale_vendor_id', $purchases_vendor_id)->orderBy('created_at', 'desc');

        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');   
       if ($startDate) {
            $query->whereRaw("STR_TO_DATE(sale_bill_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')", [$startDate]);
        }
    
        if ($endDate) {
            $query->whereRaw("STR_TO_DATE(sale_bill_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')", [$endDate]);
        }


        $filteredEstimates = $query->get();
        $bills = $filteredEstimates;
       
        if ($request->ajax()) {
          
            return view('masteradmin.vendor.filtered_results', compact('PurchasVendor', 'Country', 'States','bills'))->render();
        }
        $accounts = ChartAccount::select('chart_acc_id', 'chart_acc_name')->get();
        $paymethod = PaymentMethod::select('m_id', 'method_name')->get();
        // Pass the vendor details, countries, and states to the view
        return view('masteradmin.vendor.view_vendor', compact('PurchasVendor', 'Country', 'States','bills','accounts','paymethod'));
    }
  
    public function addBankDetails(Request $request, $purchases_vendor_id)
    {
        $user = Auth::guard('masteradmins')->user();
    
        // Validate the incoming request
        $request->validate([
            'purchases_routing_number' => 'required|string|size:9', // Routing number must be exactly 9 digits
            'purchases_account_number' => 'required|string|digits_between:1,17', // Account number must be between 1 and 17 digits
            'bank_account_type' => 'required|string|in:checking,savings', // Ensure this field is required and only accepts valid values
        ], [
            'purchases_routing_number.required' => 'Routing number must be 9 digits.',
            'purchases_account_number.required' => 'Account number must be 1 to 17 digits.',
        ]);
    // );
    
        $validatedData = $request->only([
            'purchases_routing_number',
            'purchases_account_number',
            'bank_account_type',
        ]);
    
        // Add user ID to validated data
        $validatedData['id'] = $user->id;
        $validatedData['purchases_vendor_id'] = $purchases_vendor_id;
    
        // Store the bank details
        PurchasVendorBankDetail::create($validatedData);
        return redirect()->route('business.purchasvendor.index')->with('purchases-vendor-bankdetail', __('messages.masteradmin.purchases-vendor.add_bankdetail_success'));
        // return redirect()->back()->with('success', 'Bank details added successfully.');
    }
    
// public function viewBankDetails($purchases_vendor_id): View
// {
//     $PurchasVendorbank = PurchasVendorBankDetail::where('purchases_vendor_id', $purchases_vendor_id)->firstOrFail();
//     return view('masteradmin.vendor.viewBankDetails', compact('PurchasVendorbank'));
// }


    public function viewBankDetails($purchases_vendor_id): View
    {
        $PurchasVendorbank = PurchasVendorBankDetail::where('purchases_vendor_id', $purchases_vendor_id)->with('vendor')->firstOrFail();
        return view('masteradmin.vendor.viewBankDetails', compact('PurchasVendorbank'));
    }



    public function paymentstore(Request $request, $id)
    {
        // Validate the form data
        $user = Auth::guard('masteradmins')->user();
        
        $validatedData = $request->validate([
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_account' => 'required|string',
            'notes' => 'required|string',
        ]);
    
        // Create a new payment record
        RecordPayment::create([
            'id' => $user->id,
            'invoice_id' => $id,  // Make sure you pass the invoice_id to this form
            'payment_date' => $validatedData['payment_date'],
            'payment_amount' => $validatedData['payment_amount'],
            'payment_method' => $validatedData['payment_method'],
            'payment_account' => $validatedData['payment_account'],
            'notes' => $validatedData['notes'],
        ]);
    
        // Fetch the relevant invoice by ID and update the sale_bill_due_amount
        $invoice = Bills::where('sale_bill_id',$id)->first();
        $invammount=0;
        if ($invoice) {
            // Deduct the payment amount from the sale_bill_due_amount
           $invammount = $invoice->sale_bill_due_amount -= $validatedData['payment_amount'];
    
            // Ensure sale_bill_due_amount doesn't go below 0
            if ($invoice->sale_bill_due_amount < 0) {
               
                $invammount= $invoice->sale_bill_due_amount = 0;
            }
    
            // Save the updated invoice
            $invoice->where('sale_bill_id', $id)->update(['sale_bill_due_amount' => $invammount]);
        }
    
        // Fetch the relevant Chart of Account record by the payment account
        $chartOfAccount = ChartAccount::where('chart_acc_name', $validatedData['payment_account'])->first();
        $chart_amount = 0;
        if ($chartOfAccount) {
            // Check if the amount is null or has a value, then update accordingly
            if (is_null($chartOfAccount->amount)) {
                $chart_amount = $chartOfAccount->amount = $validatedData['payment_amount'];
            } else {
              $chart_amount =  $chartOfAccount->amount += $validatedData['payment_amount'];
         }
    
            // Save the updated amount to the chart of account record
            $chartOfAccount->where('chart_acc_name', $validatedData['payment_account'])->update(['amount' => $chart_amount]);
        }
    
        // Redirect or return a response
        return redirect()->route('business.bill.index')->with('success', 'Payment recorded successfully and Chart of Account updated.');
    }

    
}


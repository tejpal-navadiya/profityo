<?php

namespace App\Http\Controllers\Masteradmin;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\SalesTax;

class SalesTaxController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get authenticated user and their role
        $user = Auth::guard('masteradmins')->user();
        $user_id = $user->users_id; // Fetch the role ID of the logged-in user
        $role_id = $user->role_id;

        // Fetch sales taxes
        if ($role_id == 0) { // Admin Role: Fetch all records
            $SalesTax = SalesTax::all();
        } else { // Non-Admin Role: Fetch limited data based on role
            $SalesTax = SalesTax::where('id', $user_id)->get(); 
          
        }
    
        // Pass the filtered data to the view
        return view('masteradmin.salestax.index')->with('SalesTax', $SalesTax);
    }

    

    public function create(): View
    {
        return view('masteradmin.salestax.add');
    }

    public function store(Request $request)
    {
        $user = Auth::guard('masteradmins')->user();
        $validatedData = $request->validate([
            'tax_name' => 'required|string|max:255',
            'tax_abbreviation' => 'required|string|max:255',
            'tax_number' => 'required|integer',
            'tax_desc' => 'nullable|string',
            'tax_rate' => 'required|numeric',
        ], [
            'tax_name.required' => 'The name field is required.',
            'tax_abbreviation.required' => 'The abbreviation field is required.',
            'tax_number.required' => 'The tax number field is required.',
            'tax_rate.required' => 'The tax rate field is required.',
        ]);

        // Handle checkboxes: if not checked, they won't be present in the request
        $validatedData['tax_number_invoices'] = $request->has('tax_number_invoices') ? 'on' : 'off';
        $validatedData['tax_recoverable'] = $request->has('tax_recoverable') ? 'on' : 'off';
        $validatedData['tax_compound'] = $request->has('tax_compound') ? 'on' : 'off';

        $validatedData['id'] = $user->users_id;
        $validatedData['tax_status'] = 1;

        SalesTax::create($validatedData);
        \MasterLogActivity::addToLog('SalesTax is Created.');
        return redirect()->route('business.salestax.index')->with(['salestax-add' => __('messages.masteradmin.sales-tax.send_success')]);
    }



    public function edit($tax_id, Request $request): View
    {
        $SalesTaxe = SalesTax::where('tax_id', $tax_id)->firstOrFail();

        return view('masteradmin.salestax.edit', compact('SalesTaxe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tax_id): RedirectResponse
    {
        // Find the SalesTax by tax_id
        $user = Auth::guard('masteradmins')->user();

        $SalesTaxu = SalesTax::where(['tax_id' => $tax_id, 'id' => $user->id])->firstOrFail();

        // Validate incoming request data
        $validatedData = $request->validate([
            'tax_name' => 'required|string|max:255',
            'tax_abbreviation' => 'required|string|max:255',
            'tax_number' => 'required|integer',
            'tax_desc' => 'nullable|string',
            'tax_number_invoices' => 'nullable|string',
            'tax_recoverable' => 'nullable|string',
            'tax_compound' => 'nullable|string',
            'tax_rate' => 'required|numeric',
        ], [
            'tax_name.required' => 'The name field is required.',
            'tax_abbreviation.required' => 'The abbreviation field is required.',
            'tax_number.required' => 'The tax number field is required.',
            'tax_rate.required' => 'The tax rate field is required.',
        ]);

        // Handle checkboxes: if not checked, they won't be present in the request
        $validatedData['tax_number_invoices'] = $request->has('tax_number_invoices') ? 'on' : 'off';
        $validatedData['tax_recoverable'] = $request->has('tax_recoverable') ? 'on' : 'off';
        $validatedData['tax_compound'] = $request->has('tax_compound') ? 'on' : 'off';

        // Update the SalesTax attributes based on validated data
        // $SalesTaxu->update($validatedData);
        $SalesTaxu->where('tax_id', $tax_id)->update($validatedData);
        // \LogActivity::addToLog('Admin SalesTax Edited.');
        \MasterLogActivity::addToLog('SalesTax is Edited.');
        // Redirect back to the edit form with a success message
        return redirect()->route('business.salestax.edit', ['SalesTax' => $SalesTaxu->tax_id])
            ->with('salestax-edit', __('messages.masteradmin.sales-tax.edit_sales_success'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tax_id): RedirectResponse
    {
        //
        $user = Auth::guard('masteradmins')->user();

        $SalesTax = SalesTax::where(['tax_id' => $tax_id, 'id' => $user->id])->firstOrFail();

        // Delete the SalesTax
        $SalesTax->where('tax_id', $tax_id)->delete();

        \MasterLogActivity::addToLog('Admin SalesTax Deleted.');

        return redirect()->route('business.salestax.index')->with('salestax-delete', __('messages.masteradmin.sales-tax.delete_sales_success'));

    }
}

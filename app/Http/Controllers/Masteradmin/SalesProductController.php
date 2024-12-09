<?php

namespace App\Http\Controllers\Masteradmin;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\SalesProduct;
use App\Models\Countries;
use App\Models\SalesTax;
use App\Models\ChartAccount;
use Illuminate\Http\JsonResponse;
use App\Models\States;



class SalesProductController extends Controller
{
    public function index(): View
    {
        $SalesProduct = SalesProduct::with(['tax','currency'])->get();
        $currencys = Countries::get();
        return view('masteradmin.product.index')
        ->with('SalesProduct', $SalesProduct)
        ->with('currencys', $currencys);
    
    }

    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        $SalesTax = SalesTax::all();

        // Fetch ChartAccount records based on type_id
        $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.product.add', compact('Country', 'SalesTax', 'IncomeAccounts', 'ExpenseAccounts'));
    }
    public function store(Request $request)
    {

        $user = Auth::guard('masteradmins')->user();
        $request->validate([
            'sale_product_name' => 'required|string|max:255',
            'sale_product_price' => 'nullable|string|max:255',
            'sale_product_desc' => 'nullable|string|max:255',
        ], [
            'sale_product_name.required' => 'Please enter name.',
            'sale_product_price.required' => 'The Price field is required.',
            'sale_product_tax.required' => 'The Tax field is required.',
        ]);

        // Prepare the data for insertion
        $validatedData = $request->all();
        $validatedData['sale_product_sell'] = $request->has('sale_product_sell') ? 'on' : 'off';
        $validatedData['sale_product_buy'] = $request->has('sale_product_buy') ? 'on' : 'off';

        $validatedData['id'] = $user->id; // Use the correct field name for user ID
        $validatedData['sale_product_status'] = 1;

        // Insert the data into the database
        SalesProduct::create([
            'sale_product_name' => $validatedData['sale_product_name'],
            'sale_product_price' => $validatedData['sale_product_price'],
            'sale_product_tax' => $validatedData['sale_product_tax'],
            'sale_product_income_account' => $validatedData['sale_product_income_account'],
            'sale_product_expense_account' => $validatedData['sale_product_expense_account'],
            'sale_product_desc' => $validatedData['sale_product_desc'],
            'sale_product_currency_id' => $validatedData['sale_product_currency_id'],
            'sale_product_sell' => $validatedData['sale_product_sell'],
            'sale_product_buy' => $validatedData['sale_product_buy'],
            'id' => $validatedData['id'], // Use the correct field name for user ID
            'sale_cus_status' => 1,
        ]);

        return redirect()->route('business.salesproduct.index')->with(['sales-product-add' => __('messages.masteradmin.sales-product.send_success')]);
    }


    public function edit($sale_product_id, Request $request): View
    {
        $SalesProducte = SalesProduct::where('sale_product_id', $sale_product_id)->firstOrFail();
        $Country = Countries::all(); // Fetch all country from the countries table
        $SalesTax = SalesTax::all();

        // Fetch ChartAccount records based on type_id
        $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.product.edit', compact('SalesProducte', 'Country', 'SalesTax', 'IncomeAccounts', 'ExpenseAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sale_product_id): RedirectResponse
    {
        // dd($request);
        $SalesProductu = SalesProduct::where('sale_product_id', $sale_product_id)->firstOrFail();

        $validatedData = $request->validate([
            'sale_product_name' => 'required|string|max:255',
            'sale_product_price' => 'nullable|string|max:255',
            'sale_product_currency_id' => 'nullable|string|max:255',
            'sale_product_income_account' => 'nullable|numeric',
            'sale_product_expense_account' => 'nullable|numeric',
            'sale_product_desc' => 'nullable|string|max:255',
            'sale_product_tax' => 'nullable',
        ],[
            'sale_product_name.required' => 'Please enter name.',
            'sale_product_price.required' => 'The Price field is required.',
            'sale_product_tax.required' => 'The Tax field is required.',
        ]);

        $validatedData['sale_product_sell'] = $request->has('sale_product_sell') ? 'on' : 'off';
        $validatedData['sale_product_buy'] = $request->has('sale_product_buy') ? 'on' : 'off';

        // Set income account to null if sell checkbox is unchecked
        if ($validatedData['sale_product_sell'] === 'off') {
            $validatedData['sale_product_income_account'] = null;
        }

        // Set expense account to null if buy checkbox is unchecked
        if ($validatedData['sale_product_buy'] === 'off') {
            $validatedData['sale_product_expense_account'] = null;
        }

        $SalesProductu->where('sale_product_id', $sale_product_id)->update($validatedData);

        return redirect()->route('business.salesproduct.edit', ['SalesProduct' => $SalesProductu->sale_product_id])
            ->with('sales-product-edit', __('messages.masteradmin.sales-product.edit_salesproduct_success'));
    }

    public function destroy($sale_product_id): RedirectResponse
    {

        $user = Auth::guard('masteradmins')->user();

        $SalesProduct = SalesProduct::where(['sale_product_id' => $sale_product_id, 'id' => $user->id])->firstOrFail();

        $SalesProduct->where('sale_product_id', $sale_product_id)->delete();
        return redirect()->route('business.salesproduct.index')->with('sales-product-delete', __('messages.masteradmin.sales-product.delete_salesproduct_success'));

    }

    public function productStates($countryId): JsonResponse
    {
        $states = States::where('country_id', $countryId)->get();

        return response()->json($states);
    }

    
    
}

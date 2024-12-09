<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\PurchasProduct;
use App\Models\Countries;
use App\Models\SalesTax;
use App\Models\ChartAccount;
class PurchasProductController extends Controller
{
    //
    public function index(): View
    {
        $PurchasProduct = PurchasProduct::with(['tax', 'currency'])->get();
        $currencys = Countries::get();

        return view('masteradmin.product_purchas.index')->with('PurchasProduct', $PurchasProduct)->with('currencys', $currencys);
    }

    public function create(): View
    {
        $Country = Countries::all(); // Fetch all countries
        $SalesTax = SalesTax::all();

        // Fetch ChartAccount records based on type_id
        $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.product_purchas.add', compact('Country', 'SalesTax', 'IncomeAccounts', 'ExpenseAccounts'));
    }
    public function store(Request $request)
    {

        $user = Auth::guard('masteradmins')->user();
        $request->validate([
            'purchases_product_name' => 'required|string|max:255',
            'purchases_product_price' => 'nullable|string|max:255',
            'purchases_product_desc' => 'nullable|string|max:255',
        ], [
            'purchases_product_name.required' => 'Please enter item name.',
            'purchases_product_price.required' => 'The Price field is required.',
            'purchases_product_tax.required' => 'The Tax field is required.',
        ]);

        // Prepare the data for insertion
        $validatedData = $request->all();
        $validatedData['purchases_product_sell'] = $request->has('purchases_product_sell') ? 'on' : 'off';
        $validatedData['purchases_product_buy'] = $request->has('purchases_product_buy') ? 'on' : 'off';

        $validatedData['id'] = $user->id; // Use the correct field name for user ID
        $validatedData['purchases_product_status'] = 1;

        // Insert the data into the database
        PurchasProduct::create([
            'purchases_product_name' => $validatedData['purchases_product_name'],
            'purchases_product_price' => $validatedData['purchases_product_price'],
            'purchases_product_tax' => $validatedData['purchases_product_tax'],
            'purchases_product_income_account' => $validatedData['purchases_product_income_account'],
            'purchases_product_expense_account' => $validatedData['purchases_product_expense_account'],
            'purchases_product_desc' => $validatedData['purchases_product_desc'],
            'purchases_product_currency_id' => $validatedData['purchases_product_currency_id'],
            'purchases_product_sell' => $validatedData['purchases_product_sell'],
            'purchases_product_buy' => $validatedData['purchases_product_buy'],
            'id' => $validatedData['id'], // Use the correct field name for user ID
            'purchases_product_status' => 1,
        ]);

        return redirect()->route('business.purchasproduct.index')->with(['purchases-product-add' => __('messages.masteradmin.purchases-product.send_success')]);
    }


    public function edit($purchases_product_id, Request $request): View
    {
        $PurchasProducte = PurchasProduct::where('purchases_product_id', $purchases_product_id)->firstOrFail();
        $Country = Countries::all(); // Fetch all country from the countries table
        $SalesTax = SalesTax::all();

        // Fetch ChartAccount records based on type_id
        $IncomeAccounts = ChartAccount::where('type_id', 3)->get();
        $ExpenseAccounts = ChartAccount::where('type_id', 4)->get(); // Assuming type_id 4 for expenses, change as necessary

        return view('masteradmin.product_purchas.edit', compact('PurchasProducte', 'Country', 'SalesTax', 'IncomeAccounts', 'ExpenseAccounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $purchases_product_id): RedirectResponse
    {
        // dd($request);
        $PurchasProductu = PurchasProduct::where('purchases_product_id', $purchases_product_id)->firstOrFail();

        $validatedData = $request->validate([
            'purchases_product_name' => 'required|string|max:255',
            'purchases_product_price' => 'nullable|string|max:255',
            'purchases_product_currency_id' => 'nullable|string|max:255',
            'purchases_product_income_account' => 'nullable|numeric',
            'purchases_product_expense_account' => 'nullable|numeric',
            'purchases_product_desc' => 'nullable|string|max:255',
            'purchases_product_tax' =>'nullable',
        ],[
            'purchases_product_name.required' => 'Please enter item name.',
            'purchases_product_price.required' => 'The Price field is required.',
            'purchases_product_tax.required' => 'The Tax field is required.',
        ]);

        $validatedData['purchases_product_sell'] = $request->has('purchases_product_sell') ? 'on' : 'off';
        $validatedData['purchases_product_buy'] = $request->has('purchases_product_buy') ? 'on' : 'off';

        // Set income account to null if sell checkbox is unchecked
        if ($validatedData['purchases_product_sell'] === 'off') {
            $validatedData['purchases_product_income_account'] = null;
        }

        // Set expense account to null if buy checkbox is unchecked
        if ($validatedData['purchases_product_buy'] === 'off') {
            $validatedData['purchases_product_expense_account'] = null;
        }

        $PurchasProductu->where('purchases_product_id', $purchases_product_id)->update($validatedData);

        return redirect()->route('business.purchasproduct.edit', ['PurchasesProduct' => $PurchasProductu->purchases_product_id])
            ->with('purchases-product-edit', __('messages.masteradmin.purchases-product.edit_purchasesproduct_success'));
    }

    public function destroy($purchases_product_id): RedirectResponse
    {

        $user = Auth::guard('masteradmins')->user();

        $PurchasProduct = PurchasProduct::where(['purchases_product_id' => $purchases_product_id, 'id' => $user->id])->firstOrFail();

        $PurchasProduct->where('purchases_product_id', $purchases_product_id)->delete();
        return redirect()->route('business.purchasproduct.index')->with('purchases-product-delete', __('messages.masteradmin.purchases-product.delete_purchasesproduct_success'));

    }
}

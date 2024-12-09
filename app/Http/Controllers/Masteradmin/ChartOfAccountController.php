<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Add this to use DB facade
use Illuminate\View\View;
use App\Models\Countries;
use App\Models\ChartAccount;



class ChartOfAccountController extends Controller
{

    // public function index(): View
    // {
    //     // Fetching all countries
    //     $Country = Countries::all();
    
    //     // Fetching different account types
    //     $assets = DB::table('py_chart_account_menu')
    //         ->where('menu_id', 3) // Assets
    //         ->where('chart_menu_status', 1)
    //         ->get();
    // // dd($assets);
    //     $liabilitiesAndCreditCards = DB::table('py_chart_account_menu')
    //         ->where('menu_id', 2)  
    //         ->where('chart_menu_status', 1)
    //         ->get();
    
    //     $income = DB::table('py_chart_account_menu')
    //         ->where('menu_id', 4)  // Income
    //         ->where('chart_menu_status', 1)
    //         ->get();
    
    //     $equity = DB::table('py_chart_account_menu')
    //         ->where('menu_id', 5) // Equity
    //         ->where('chart_menu_status', 1)
    //         ->get();
    
    //     $expenses = DB::table('py_chart_account_menu')
    //         ->where('menu_id', 1) // Expenses
    //         ->where('chart_menu_status', 1)
    //         ->get();
    
    //     // Getting the currently authenticated user
    //     $user = Auth::guard('masteradmins')->user();
    //     $uniq_id = $user->user_id; // Fetching the unique ID of the logged-in user
    
    //     // Fetching accounts and grouping them by 'acc_type_id'
    //     $list = ChartAccount::where('sale_product_status', 1)
    //         ->get()
    //         ->groupBy('acc_type_id');
    
    //     // Pass all data to the view
    //     return view('masteradmin.chartofaccount.index', compact(
    //         'assets', 
    //         'liabilitiesAndCreditCards', 
    //         'income', 
    //         'equity', 
    //         'expenses', 
    //         'Country',
    //         'list'
    //     ));
    // }
    
    public function index(): View
    {
        // Fetching all countries
        $Country = Countries::all();
    
        // Fetching different account types
        $assets = DB::table('py_chart_account_menu')
            ->where('menu_id', 1) // Assets
            ->where('chart_menu_status', 1)
            ->get();
    // dd($assets);
        $liabilitiesAndCreditCards = DB::table('py_chart_account_menu')
            ->where('menu_id', 2)  
            ->where('chart_menu_status', 1)
            ->get();
    
        $income = DB::table('py_chart_account_menu')
            ->where('menu_id', 3)  // Income
            ->where('chart_menu_status', 1)
            ->get();
    
        $equity = DB::table('py_chart_account_menu')
            ->where('menu_id', 5) // Equity
            ->where('chart_menu_status', 1)
            ->get();
    
        $expenses = DB::table('py_chart_account_menu')
            ->where('menu_id', 4) // Expenses
            ->where('chart_menu_status', 1)
            ->get();

            $tabs = DB::table('py_chart_account_menu')
            ->where('chart_menu_status', 1)
            ->whereIn('menu_id', [0]) // Assuming 0=Expenses, 1=Assets, 2=Liabilities, 3=Income, 4=Equity
            ->get();
            // dd($tabs);
    
        // Getting the currently authenticated user
        $user = Auth::guard('masteradmins')->user();
        $uniq_id = $user->user_id; // Fetching the unique ID of the logged-in user
    
        // Fetching accounts and grouping them by 'acc_type_id'
        $list = ChartAccount::where('sale_product_status', 1)
            ->get()
            ->groupBy('acc_type_id');

      
        // Counting records
         $counts = ChartAccount::select('type_id', DB::raw('count(*) as count'))
        ->where('sale_product_status', 1)
        ->groupBy('type_id')
        ->pluck('count', 'type_id');
        
        //list all perent and child data
        $subMenus = DB::table('py_chart_account_menu')
        ->where('chart_menu_status', 1)
        ->whereIn('menu_id', [0, 1, 2, 3, 4, 5])
        ->get()
        ->groupBy('menu_id'); 
        
        // Pass all data to the view
        return view('masteradmin.chartofaccount.index', compact(
            'assets', 
            'liabilitiesAndCreditCards', 
            'income', 
            'equity', 
            'expenses', 
            'Country',
            'list',
            'tabs',
            'counts',
            'subMenus'
        ));
    }

    public function store(Request $request)
    {
        // dd($request);
        $user = Auth::guard('masteradmins')->user(); // Get the authenticated user
        $validatedData = $request->validate([
            // 'type_id' => 'required|integer',
            'acc_type_id' => 'nullable|integer',
            'chart_acc_name' => 'required|string|max:255',
            'currency_id' => 'nullable|integer',
            'chart_account_id' => 'nullable|string|max:255',
            'sale_acc_desc' => 'nullable|string|max:255',
            // 'sale_product_status' => 'required|boolean',
        ], [
            'acc_type_id.required' => 'The account type field is required.',
            'chart_acc_name.required' => 'The account name field is required.',
            'currency_id.required' => 'The currency field is required.',
        ]);
        $validatedData['id'] = $user->id; 
        $validatedData['sale_product_status'] = 1; 
        $query = DB::table('py_chart_account_menu')
            ->where('chart_menu_id',$request->acc_type_id) // Assets
            ->where('chart_menu_status', 1)
            ->first();
            // dd($query);
            $validatedData['type_id'] = $query->menu_id; 
        ChartAccount::create($validatedData);

        return redirect()->back()->with('chart-of-account-add', __('messages.masteradmin.chart-of-account.send_success'));
    }

    // Add this method to fetch the data for the modal
    public function edit($chart_acc_id)
    {

        $account = ChartAccount::find($chart_acc_id);
        // dd($chart_acc_id);
        return response()->json($account);
    
    }

    // Add this method to handle the update request
    public function update(Request $request,$chart_acc_id)
    {
    // dd($chart_acc_id);
        $validatedData = $request->validate([
            'chart_acc_name' => 'nullable|string|max:255',
            'currency_id' => 'nullable|integer',
            'chart_account_id' => 'nullable|string|max:255',
            'sale_acc_desc' => 'nullable|string|max:255',
            'archive_account' => 'nullable|integer',
        ]);

        $account = ChartAccount::where('chart_acc_id', $chart_acc_id)->firstOrFail();
        // $account->update($validatedData);
        // dd($account);
        $account->where('chart_acc_id', $chart_acc_id)->update($validatedData);
    // dd($account);
        return redirect()->back()->with('success', 'Account updated successfully.');
    }


}

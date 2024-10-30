<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InvoicesDetails;
use App\Models\PurchasVendor;
use App\Models\SalesCustomers;
use App\Models\Bills;
use App\Models\RecordPayment;
use App\Models\ChartAccount;
use Carbon\Carbon;




class HomeController extends Controller
{
    //
    public function create()
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
        if (!$user) {
            return redirect()->route('business.login'); 
        }

        $masterUser = $user->masterUser()->first(); 
        // dd($masterUser);
        $plan = $masterUser->sp_id;

        if (!$plan) {
            session()->flash('showModal', 'Please purchase a plan first.');
        }elseif ($masterUser->sp_expiry_date < now()) {
            session()->flash('showModal', 'Your plan has expired. Please purchase a new plan.');
        }
        // $masterUser = $user->masterUser()->first(); 

        $totalBills = Bills::where('id',$user->id)->count();
        $totalcustomer = SalesCustomers::where('id',$user->id)->count();
        $totalInvoices = InvoicesDetails::where('id',$user->id)->count();
        $totalvendor = PurchasVendor::where('id',$user->id)->count();
        $accounts = ChartAccount::all();

        $recordPayments = RecordPayment::with( 'chartOfAccount')->where('id', $user->id)->get();
        // dd($recordPayments);
        $invoices = InvoicesDetails::where('id', $user->id)
    ->with('customer') // Eager load the customer relationship
    ->latest('sale_inv_date')
    ->take(5)
    ->get()
    ->map(function ($invoice) {
        $invoice->sale_inv_date = Carbon::parse($invoice->sale_inv_date);
        $invoice->sale_inv_valid_date = Carbon::parse($invoice->sale_inv_valid_date);
        return $invoice;
    });
        $bill = Bills::where('id', $user->id)
        ->with('vendor')
        ->latest('sale_bill_date') // Adjust 'sale_inv_date' if you want to sort by a different date column
        ->take(5)
        ->get()
        ->map(function ($bill) {
            $bill->sale_bill_date = Carbon::parse($bill->sale_bill_date);
            $bill->sale_bill_valid_date = Carbon::parse($bill->sale_bill_valid_date);
            return $bill;
        });
         // Weekly and Monthly Invoices Stats
    $today = now();
    $startOfWeek = $today->copy()->startOfWeek();
    $startOfMonth = $today->copy()->startOfMonth();

    // Weekly Invoices
    $weeklyInvoices = InvoicesDetails::where('id', $user->id)
        ->whereBetween('sale_inv_date', [$startOfWeek, $today])
        ->get();
    
    $totalWeeklyInvoicesGenerated = $weeklyInvoices->count();
    $totalWeeklyPaid = $weeklyInvoices->where('sale_status', 'Paid')->sum('sale_inv_final_amount'); // Assuming 'status' column holds Paid status
    $totalWeeklyDue = $weeklyInvoices->where('sale_status', '!=', 'Paid')->sum('sale_inv_final_amount');

    // Monthly Invoices
    $monthlyInvoices = InvoicesDetails::where('id', $user->id)
        ->whereBetween('sale_inv_date', [$startOfMonth, $today])
        ->get();

    $totalMonthlyInvoicesGenerated = $monthlyInvoices->count();
    $totalMonthlyPaid = $monthlyInvoices->where('sale_status', 'Paid')->sum('sale_inv_final_amount');
    $totalMonthlyDue = $monthlyInvoices->where('sale_status', '!=', 'Paid')->sum('sale_inv_final_amount');
    // dd($totalMonthlyInvoicesGenerated);   
    return view('masteradmin.auth.home', compact('totalInvoices','totalvendor','totalcustomer','totalBills','masterUser','recordPayments','accounts','invoices','bill', 'totalWeeklyInvoicesGenerated', 'totalWeeklyPaid', 'totalWeeklyDue', 
        'totalMonthlyInvoicesGenerated', 'totalMonthlyPaid', 'totalMonthlyDue'));
    }

}

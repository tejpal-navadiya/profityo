<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RecordPayment;
use App\Models\ChartAccount;


class TransectionController extends Controller
{
    //
    public function index(): View
    {
        //
        // dd('hii');
        $RecordPayment = RecordPayment::all();
        $accounts = ChartAccount::select('chart_acc_id', 'chart_acc_name')->get();
        $totalPaymentAmount = $RecordPayment->sum('payment_amount');

        return view('masteradmin.transection.index',compact('RecordPayment', 'accounts','totalPaymentAmount'));
    }
    public function filterTransactions(Request $request)
{
    // Fetch accounts for the dropdown
    $accounts = ChartAccount::all();
    
    // If a payment account is selected, filter the transactions
    $query = RecordPayment::query();
    
    if ($request->has('payment_account') && !empty($request->payment_account)) {
        $query->where('payment_account', $request->payment_account);
    }

    // Get the filtered data
    $RecordPayment = $query->get();
    $totalPaymentAmount = $RecordPayment->sum('payment_amount');


    return view('masteradmin.transection.index', compact('accounts', 'RecordPayment','totalPaymentAmount'));
}

public function edit( Request $request): View
    {
       
        return view('masteradmin.transection.edit');
    }
}

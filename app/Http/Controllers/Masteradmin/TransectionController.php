<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RecordPayment;
use App\Models\ChartAccount;
use Illuminate\Support\Facades\DB;  // Add this to use DB facade


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
        // $accounts = ChartAccount::select('chart_acc_id', 'chart_acc_name')->get();
        $tabs = DB::table('py_chart_account_menu')
        ->where('chart_menu_status', 1)
        ->whereIn('menu_id', [0]) // Assuming 0=Expenses, 1=Assets, 2=Liabilities, 3=Income, 4=Equity
        ->get();
        // dd($tabs);
        
         //list all perent and child data
        $subMenus = DB::table('py_chart_account_menu')
        ->where('chart_menu_status', 1)
        ->whereIn('menu_id', [0, 1, 2, 3, 4, 5])
        ->get()
        ->groupBy('menu_id'); 
        return view('masteradmin.transection.index',compact('RecordPayment', 'tabs','subMenus','accounts','totalPaymentAmount'));
    }
    public function filterTransactions(Request $request)
{
    // Fetch accounts for the dropdown
    $accounts = ChartAccount::all();
     // $accounts = ChartAccount::select('chart_acc_id', 'chart_acc_name')->get();
     $tabs = DB::table('py_chart_account_menu')
     ->where('chart_menu_status', 1)
     ->whereIn('menu_id', [0]) // Assuming 0=Expenses, 1=Assets, 2=Liabilities, 3=Income, 4=Equity
     ->get();
     // dd($tabs);
     
      //list all perent and child data
     $subMenus = DB::table('py_chart_account_menu')
     ->where('chart_menu_status', 1)
     ->whereIn('menu_id', [0, 1, 2, 3, 4, 5])
     ->get()
     ->groupBy('menu_id'); 
    // If a payment account is selected, filter the transactions
    $query = RecordPayment::query();
    
    if ($request->has('payment_account') && !empty($request->payment_account)) {
        $query->where('payment_account', $request->payment_account);
    }

    // Get the filtered data
    $RecordPayment = $query->get();
    $totalPaymentAmount = $RecordPayment->sum('payment_amount');


    return view('masteradmin.transection.index', compact('tabs','subMenus','accounts', 'RecordPayment','totalPaymentAmount'));
}



    public function storeIncome(Request $request)
    {
        // dd($request->all());
        // Validate the incoming data
        $request->validate([
            'payment_account' => 'required', // Ensure valid account
            'payment_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'type' => 'required|string',
            'category' => 'required|string',
            'recipt' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
    
        // Save the payment record (RecordPayment)
        $payment = new RecordPayment();
        $payment->payment_account  = $request->payment_account;
        $payment->payment_amount = $request->payment_amount;
        $payment->payment_date = $request->payment_date;
        $payment->notes = $request->notes;
        $payment->description = $request->description;
        $payment->type = $request->type;
        $payment->category = $request->category;
        $payment->recipt = $request->recipt;
        $payment->mark_as_review = $request->has('mark_as_review') ? true : false;
        $payment->status = 1; // Adjust the status based on your logic
        $payment->save();
        // dd($request->payment_account);
        // Now update the corresponding account's balance (amount field)
        $account = ChartAccount::where('chart_acc_id', $request->payment_account)->first();
        // dd($account);
            // dd( $account);
            // if ($account) {
            //     // Update the amount based on the payment type
            //     if ($request->type == 1) {
            //       // Subtract for type 2
            //       $account->amount += $request->payment_amount;
            //     } else {
            //         $account->amount -= $request->payment_amount;  // Add for other types
            //     }
            //     $account->save();
            // }
        // if ($account) {
        //     // Update the amount based on the payment (e.g., add the payment amount)
        //     $account->amount += $request->payment_amount;
        //     $account->save();
        // }
        if ($account) {
            // Calculate the new amount
            $newAmount = $account->amount + $request->payment_amount;
        
            // Update the account with the new amount
            $account->where('chart_acc_id', $request->payment_account)
                ->update(['amount' => $newAmount]);
        }
        
        return redirect()->route('business.transection.index')->with('Transaction-add', __('messages.masteradmin.transaction.add_income_success'));
    }
    public function storeExpense(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'payment_account' => 'required', // Ensure valid account
            'payment_amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            'type' => 'required|string',
            'category' => 'required|string',
            'recipt' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
    
        // Save the payment record (RecordPayment)
        $payment = new RecordPayment();
        $payment->payment_account = $request->payment_account;
        $payment->payment_amount = $request->payment_amount;
        $payment->payment_date = $request->payment_date;
        $payment->notes = $request->notes;
        $payment->description = $request->description;
        $payment->type = $request->type;
        $payment->category = $request->category;
        $payment->recipt = $request->recipt;
        $payment->mark_as_review = $request->has('mark_as_review') ? true : false;
        $payment->status = 1; // Adjust the status based on your logic
        $payment->save();
    
        // Now update the corresponding account's balance (amount field)
        $account = ChartAccount::where('chart_acc_id', $request->payment_account)->first();
    
        // if ($account) {
        //     // Update the amount based on the payment type
        //     if ($request->type == 2) {
        //         $account->amount -= $request->payment_amount; // Subtract for type 2
        //     } else {
        //         $account->amount += $request->payment_amount; // Add for other types
        //     }
        //     $account->save();
        // }
        if ($account) {
            // Calculate the updated amount
            if ($request->type == 2) {
                $newAmount = $account->amount - $request->payment_amount; // Subtract for type 2
            } else {
                $newAmount = $account->amount + $request->payment_amount; // Add for other types
            }
        
            // Update the amount in the database
            $account->where('chart_acc_id', $request->payment_account)->update(['amount' => $newAmount]);
        }
        
        return redirect()->route('business.transection.index')->with('Transaction-add-expense', __('messages.masteradmin.transaction.add_expens_success'));
    }
    public function edit($record_payment_id, Request $request): View
    {
        // dd($record_payment_id);
        $RecordPayment = RecordPayment::get(); // Fetch all records
        $payment = RecordPayment::where('record_payment_id', $record_payment_id)->first();
    
        $accounts = ChartAccount::select('chart_acc_id', 'chart_acc_name')->get();
        $totalPaymentAmount = $RecordPayment->sum('payment_amount');
        
        $tabs = DB::table('py_chart_account_menu')
            ->where('chart_menu_status', 1)
            ->whereIn('menu_id', [0]) // Filter by menu_id, assuming 0=Expenses, etc.
            ->get();
    
        // List parent and child data
        $subMenus = DB::table('py_chart_account_menu')
            ->where('chart_menu_status', 1)
            ->whereIn('menu_id', [0, 1, 2, 3, 4, 5])
            ->get()
            ->groupBy('menu_id'); 
    
        return view('masteradmin.transection.edit', compact('payment', 'RecordPayment', 'tabs', 'subMenus', 'accounts', 'totalPaymentAmount'));
    }
    
  
public function updateTransactiondata1(Request $request, $record_payment_id)
{
    // Validate the incoming request data
    $request->validate([
        'payment_account' => 'required', // Ensure valid account
        'payment_amount' => 'required|numeric',
        'payment_date' => 'required|date',
        'notes' => 'nullable|string',
        'type' => 'required|string',
        'category' => 'required|string',
        'recipt' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    try {
        // Update the transaction fields directly
        RecordPayment::where('record_payment_id', $record_payment_id)->update([
            'payment_date' => $request->input('payment_date'),
            'description' => $request->input('description'),
            'payment_account' => $request->input('payment_account'),
            'category' => $request->input('category'),
            'payment_amount' => $request->input('payment_amount'),
            'notes' => $request->input('notes'),
            'type' => $request->input('type'),
            'recipt' => $request->input('recipt'),
        ]);

        // Redirect back with a success message
        return redirect()->route('business.transection.index')->with('success', 'Transaction updated successfully!');
    } catch (ModelNotFoundException $e) {
        // Handle case when transaction is not found
        return redirect()->back()->withErrors('Transaction not found.');
    } catch (Exception $e) {
        // Handle any other exceptions
        return redirect()->back()->withErrors('An error occurred while updating the transaction. Please try again.');
    }
}

public function updateTransactiondata(Request $request, $record_payment_id)
{
    // Validate the incoming request data
    $request->validate([
        'payment_account' => 'required', // Ensure valid account
        'payment_amount' => 'required|numeric',
        'payment_date' => 'required|date',
        'notes' => 'nullable|string',
        'type' => 'required|string',
        'category' => 'required|string',
        'recipt' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    try {
        // Find the associated chart account
        $account = ChartAccount::find($request->payment_account);
        if (!$account) {
            \Log::error('ChartAccount not found:', ['payment_account' => $request->payment_account]);
            return redirect()->back()->withErrors('Account not found.');
        }

        // Ensure payment_amount is not null and numeric
        $paymentAmount = $request->payment_amount ?? 0;

        // Fetch the existing transaction to adjust account amount correctly
        $existingTransaction = RecordPayment::findOrFail($record_payment_id);
        $existingAmount = $existingTransaction->payment_amount;

        if ($existingTransaction->type == 2) {
            $account->amount -= $existingAmount; // Revert the previous amount adjustment
        } else {
            $account->amount += $existingAmount; // Revert for other types
        }

        if ($request->type == 1) {
            $account->amount += $paymentAmount; // Add amount for type 1
        } else {
            $account->amount -= $paymentAmount; // Subtract amount for other types
        }

        $account->save();

        // Update the transaction fields directly
        RecordPayment::where('record_payment_id', $record_payment_id)->update([
            'payment_date' => $request->input('payment_date'),
            'description' => $request->input('description'),
            'payment_account' => $request->input('payment_account'),
            'category' => $request->input('category'),
            'payment_amount' => $paymentAmount,
            'notes' => $request->input('notes'),
            'type' => $request->input('type'),
            'recipt' => $request->input('recipt'),
        ]);

        // Redirect back with a success message
        return redirect()->route('business.transection.index')->with('success', 'Transaction updated successfully!');
    } catch (ModelNotFoundException $e) {
        // Handle case when transaction is not found
        return redirect()->back()->withErrors('Transaction not found.');
    } catch (Exception $e) {
        // Handle any other exceptions
        return redirect()->back()->withErrors('An error occurred while updating the transaction. Please try again.');
    }
}

public function updateTransaction(Request $request, $paymentId)
{
    // \Log::info('Request received:', [
    //     'paymentId' => $paymentId,
    //     'requestData' => $request->all(),
    // ]);

    // Validate incoming request
    $request->validate([
        'payment_account' => 'nullable',
        'payment_amount' => 'nullable|numeric',
        'payment_date' => 'nullable|date',
        'description' => 'nullable|string',
        'category' => 'nullable|string',
    ]);

    // Find the payment record
    $payment = RecordPayment::find($paymentId);

    if ($payment) {
        // Update the payment record
        $payment->payment_account = $request->payment_account;
        $payment->payment_amount = $request->payment_amount;
        $payment->payment_date = $request->payment_date;
        $payment->description = $request->description;
        $payment->category = $request->category;
        $payment->save();

        // Find the associated chart account
        $account = ChartAccount::find($request->payment_account);
        if (!$account) {
            \Log::error('ChartAccount not found:', ['payment_account' => $request->payment_account]);
            return response()->json(['success' => false, 'message' => 'Account not found']);
        }

        // Ensure payment_amount is not null and numeric
        $paymentAmount = $request->payment_amount ?? 0;
       
        if ($payment->type == 1) {
            $account->amount += $paymentAmount; // Add amount for type 1
        } else {
            $account->amount -= $paymentAmount; // Subtract amount for other types
        }

      
        $account->save();
      
        session()->flash('success', 'Transaction updated successfully.');
        // return redirect()->route('business.transection.index');
        // return response()->json(['success' => true, 'message' => 'Transaction updated successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Transaction not found']);
}


}

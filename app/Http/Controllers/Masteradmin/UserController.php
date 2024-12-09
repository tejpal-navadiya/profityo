<?php

namespace App\Http\Controllers\Masteradmin;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterUserDetails;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Notifications\UsersDetails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    //
    public function index(): View
    {
        // Get the authenticated user
        $user = Auth::guard('masteradmins')->user();

        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($user->user_id);

        $userdetail = $userDetails->get();
        
        $userdetail->each(function($detail) {
            $detail->load('userRole');
        });
        
        // dd($userdetail);

        return view('masteradmin.userdetails.index')->with('userdetail', $userdetail);

    }
    public function create(): View
    {
        $roles = UserRole::all(); 
        return view('masteradmin.userdetails.add', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::guard('masteradmins')->user();
        // dd($user);
    //    $validatedData = $request->validate([
    //         'users_name' => 'required|string|max:255',
    //         'users_email' => 'required|string|email|max:255', 
    //         'users_phone' => 'required|digits_between:10,15', 
    //         'users_password' => 'nullable|string|min:8', 
    //         'role_id' => 'required|integer',
    //     ], [
    //         'users_name.required' => 'The name field is required.',
    //         'users_email.required' => 'The email field is required.',
    //         'users_email.email' => 'The email must be a valid email address.', 
    //         'users_phone.required' => 'The phone field is required.',
    //         'users_phone.digits_between' => 'The phone number must be between 10 and 15 digits.', 
    //         'role_id.required' => 'The role field is required.',
    //         'role_id.integer' => 'The role must be an integer.', 
    //     ]);

    $tableName = $user->user_id . '_py_users_details'; // Dynamically set table name


    $validatedData = $request->validate([
        'users_name' => 'required|string|max:255',
        'users_email' => [
            'required',
            'string',
            'email',
            'max:255',
            // Ensure the email is unique in the 'users' table, except for the current user's email if updating
            Rule::unique($tableName, 'users_email')->ignore($user->user_id) // Ensure unique constraint
        ],
        'users_phone' => 'required|digits_between:10,15',
        'users_password' => 'nullable|string|min:8',
        'role_id' => 'required|integer',
    ], [
        'users_name.required' => '  Please enter name.',
        'users_email.required' => 'Please enter email.',
        'users_email.email' => 'The email must be a valid email address.',
        'users_email.unique' => 'The email has already been taken.',
        'users_phone.required' => 'Please enter phone number.',
        'users_phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
        'role_id.integer' => 'Please enter role.',
        // 'role_id.integer' => 'Please enter role.',
    ]);

        
        
        if (!empty($validatedData['users_password'])) {
            $validatedData['users_password'] = Hash::make($validatedData['users_password']);
        }
        $validatedData['id'] = $user->id;
        $validatedData['user_id'] = $user->user_id;
        $validatedData['users_status'] = 1;
        $validatedData['users_image'] = '';
        $validatedData['country_id'] = 0;
        $validatedData['state_id'] = 0;
        $validatedData['users_city_name'] = '';
        $validatedData['users_pincode'] = '';

        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($user->user_id);
      
        $userDetails->create($validatedData);

        \MasterLogActivity::addToLog('Admin userdetail Created.');

        $loginUrl = route('business.userdetail.changePassword', ['email' => $request->users_email, 'user_id' => $user->user_id]);
        try {
            Mail::to($request->users_email)->send(new UsersDetails($user->user_id, $loginUrl, $request->users_email));
            session()->flash('link-success', __('messages.masteradmin.user.link_send_success'));
        } catch (\Exception $e) {
            session()->flash('link-error', __('messages.masteradmin.user.link_send_error'));
        }
    
        return redirect()->route('business.userdetail.index')->with(['user-add' => __('messages.masteradmin.user.send_success')]);
        
    }
    

    public function edit($users_id, Request $request): View
    {
       
        $user = Auth::guard('masteradmins')->user();
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($user->user_id);

        $userdetaile = $masteruser->where('users_id', $users_id)->firstOrFail();
        $roles = UserRole::all(); 

        return view('masteradmin.userdetails.edit', compact('userdetaile', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $users_id): RedirectResponse
    {
        // dd($request);
        $user = Auth::guard('masteradmins')->user();
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($user->user_id);
        $tableName = $masteruser->getTable();
      
        $userdetailu = $masteruser->where(['users_id' => $users_id,'id' => $user->id])->firstOrFail();

        $validatedData = $request->validate([
            'users_name' => 'required|string|max:255',
            'users_email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Ensure the email is unique in the 'users' table, except for the current user's email if updating
                Rule::unique($tableName, 'users_email')->ignore($users_id, 'users_id')
            ],
            'users_phone' => 'required|digits_between:10,15',
            'users_password' => 'nullable|string|min:8',
            'role_id' => 'required|integer',
        ], [
            'users_name.required' => '  Please enter name.',
        'users_email.required' => 'Please enter email.',
        'users_email.email' => 'The email must be a valid email address.',
        'users_email.unique' => 'The email has already been taken.',
        'users_phone.required' => 'Please enter phone number.',
        'users_phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
        'role_id.integer' => 'Please enter role.',
        // 'role_id.integer' => 'Please enter role.',
        ]);
        

        if (!empty($validatedData['users_password'])) {
            $validatedData['users_password'] = Hash::make($validatedData['users_password']);
        }else{
            $validatedData['users_password'] = $userdetailu->users_password;
        }
    
        $userdetailu->where('users_id', $users_id)->update($validatedData);
        
        \MasterLogActivity::addToLog('Admin userdetail Edited.');

    
        return redirect()->route('business.userdetail.edit', ['userdetaile' => $userdetailu->users_id])->with('user-edit', __('messages.masteradmin.user.edit_user_success'));
    }


    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy($users_id): RedirectResponse
    {
        //
        $user = Auth::guard('masteradmins')->user();
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($user->user_id);
      
        $userdetail = $masteruser->where(['users_id' => $users_id,'id' => $user->id])->firstOrFail();


        // Delete the userdetail
        $userdetail->where('users_id', $users_id)->delete();
        \MasterLogActivity::addToLog('Admin userdetail Deleted.');
        // \LogActivity::addToLog('Admin userdetail Deleted.');

        return redirect()->route('business.userdetail.index')->with('user-delete', __('messages.masteradmin.user.delete_user_success'));

    }

    public function changePassword(Request $request): View
    {
        $email = $request->query('email');
        $user_id = $request->query('user_id');
        return view('masteradmin.userdetails.change-password', ['email' => $email ,'user_id' => $user_id ]);
    }

    public function storePassword(Request $request, $user_id): RedirectResponse
    {
        $userId = $user_id;
        // dd($user_id);
        $credentials = $request->only('user_email', 'user_password');
    
        $validator = \Validator::make($credentials, [
            'user_email' => ['required', 'email'],
            'user_password' => ['required', 'string', Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()],
        ], [
            'user_email.required' => 'The email field is required.',
            'user_email.email' => 'The email must be a valid email address.',
            'user_password.required' => 'The password field is required.',
        ]);

        
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($userId);
        // dd($masteruser);
        try {
            // \DB::enableQueryLog();

            $userdetailu = $masteruser->where([
                'users_email' => $credentials['user_email'],
                'user_id' => $userId
            ])->first();
    
            if (!$userdetailu) {
                RateLimiter::hit($this->throttleKey());
                return redirect()->back()->withErrors([
                    'user_email' => 'The email ID provided is incorrect or user does not exist.',
                ])->withInput();
            }
    
            $userdetailu->where('users_email', $credentials['user_email'])->update(['users_password' => Hash::make($credentials['user_password'])]);
            // dd(\DB::getQueryLog()); 
            return redirect()->route('business.login')->with([
                'forgotpassword-success' => __('messages.masteradmin.user.link_send_success')
            ]);
    
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'user_email' => 'The email ID provided is incorrect or user does not exist.',
            ])->withInput();
        }

        
    }
    
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('user_email')).'|'.$this->ip()); // changed to 'user_email'
    }
    public function updateStatus($users_id)
    {
        // Fetch the logged-in user
        $user = Auth::guard('masteradmins')->user();
    
        // Set the table dynamically based on the logged-in user's ID
        $masteruser = new MasterUserDetails();
        $masteruser->setTableForUniqueId($user->user_id);
        
        // Fetch the user detail by the provided $users_id and logged-in user's ID
        $userdetailu = $masteruser->where(['users_id' => $users_id, 'id' => $user->id])->firstOrFail();
    
        // Toggle the status (if 1, set to 0; if 0, set to 1)
        $newStatus = $userdetailu->users_status == 1 ? 0 : 1;
    
        // Update the status
        $userdetailu->update(['users_status' => $newStatus]);
    
        // Return JSON response with the updated status
        return response()->json(['status' => 'success', 'new_status' => $newStatus]);
    }
    

    // end by dxx...

    
    
    
}

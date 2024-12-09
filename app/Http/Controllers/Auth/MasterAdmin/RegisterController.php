<?php

namespace App\Http\Controllers\Auth\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\MasterUser;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use App\Models\Plan;
use DB;
use App\Models\MasterUserDetails;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserRegistered;

class RegisterController extends Controller
{
    //
    public function create(): View
    {     
        return view('masteradmin.auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
      
        $request->validate([
            'user_first_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['required', 'string', 'max:255'],
            'user_business_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.MasterUser::class],
            'user_password' => ['required', 'string', '', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            'password_confirmation' => ['required', 'string', '', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ],[
            'user_first_name.required' => 'The First Name field is required.',
            'user_phone.required' => 'The Phone field is required.',
            'user_business_name.required' => 'The Business Name field is required.',
            'user_email.required' => 'The Email field is required.',
            'user_email.email' => 'The Email must be a valid email address.',
            'user_email.unique' => 'The Email has already been taken.',
            'user_password.required' => 'The Password field is required.',
            'password_confirmation.required' => 'The Confirm Password field is required.'
        ]);

        $plan = Plan::where('sp_id', '20')->firstOrFail();

        $startDate = Carbon::now();
        $months = $plan->sp_month;
        $expirationDate = $startDate->addMonths($months);
        $expiryDate = $expirationDate->toDateString();

        $admin = MasterUser::create([
            'user_first_name' => $request->user_first_name,
            'user_email' => $request->user_email,
            'user_phone' => $request->user_phone,
            'user_image' => '',
            'user_business_name' => $request->user_business_name,
            'buss_unique_id' => '',
            'sp_id' => $plan->sp_id,
            'user_password' => Hash::make($request->user_password),
            'sp_expiry_date' => $expiryDate,
            'country_id' => 0,
            'state_id' => 0,
            'user_city_name' => '',
            'user_pincode' => '',
            'isActive' => 1,
            'user_status' => 1
        ]);

        // Generate the unique buss_unique_id
        $buss_unique_id = $this->generateUniqueId(trim($request->user_business_name), $admin->id);

        // Update the record with the final unique ID
        $admin->buss_unique_id = $buss_unique_id;
        $admin->save();

        // Uncomment this line if you want to log in the user after registration
        
        $this->createTable($admin->id);

       // Create MasterUserDetails and set table name
        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($buss_unique_id);
        $userDetails->create([
            'users_name' => $request->user_first_name,
            'users_email' => $request->user_email,
            'users_phone' => $request->user_phone,
            'users_password' => Hash::make($request->user_password),
            'id' => $admin->id,
            'role_id' => 0,
            'user_id' => $buss_unique_id,
            'users_status' => '1'
        ]);

        // login URL
        $loginUrl = route('business.login');

        try {
            Mail::to($request->user_email)->send(new UserRegistered($buss_unique_id, $loginUrl, $request->user_email));

            return back()->with(['link-success' => __('messages.masteradmin.register.link_send_success')]);
        } catch (\Exception $e) {
            return back()->with(['link-error' => __('messages.masteradmin.register.link_send_error')]);
        }
    }

    
    private function generateUniqueId(string $user_business_name, int $id): string
    {
        // Clean the business name by removing non-alphabetic characters and whitespace
        $cleaned_name = preg_replace('/[^a-zA-Z]/', '', $user_business_name);

        // Generate the prefix from the first 4 characters of the cleaned name
        $prefix = strtolower(substr($cleaned_name, 0, 4));

        // Ensure the ID is zero-padded to a length of 2 digits
        $formattedId = sprintf("%02d", $id);

        // Combine the prefix and formatted ID
        $uniqueId = $prefix . $formattedId;

        return $uniqueId;

    }

    
}

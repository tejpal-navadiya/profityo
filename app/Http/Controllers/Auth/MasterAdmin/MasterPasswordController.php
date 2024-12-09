<?php

namespace App\Http\Controllers\Auth\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUser;
use App\Models\MasterUserDetails;

class MasterPasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        dd($request->all());
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'string', 'max:255'],
            'password_confirmation' => ['required', 'string', 'max:255'],
            'user_password' => ['required', 'string', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ], [
            'user_password.required' => 'The Password field is required.',
            'password_confirmation.required' => 'The Password field is required.',
        ]);

        $user = Auth::guard('masteradmins')->user();
        
        $userDetails = new MasterUserDetails();
        $userDetails->setTableForUniqueId($user->user_id);

        $existingUser = $userDetails->where('users_id', $user->users_id)->first();

        // dd($existingUser);
        if (!$existingUser) {
            return back()->withErrors(['user' => 'User not found.']);
        }

        if (!Hash::check($request->current_password, $existingUser->users_password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $updateData = [
            'users_password' => Hash::make($request->user_password),
        ];

        $userDetails->where('users_id', $existingUser->users_id)->update($updateData);

        \MasterLogActivity::addToLog('Master Admin Password has been updated.');

        return back()->with('status', 'password-updated');
    }

}

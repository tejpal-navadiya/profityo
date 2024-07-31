<?php

namespace App\Http\Controllers\Auth\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\Auth\Masteradmin\MasterLoginRequest;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    //
    

    public function create(): View
    {
        // dd('hiii');
        $rememberedId = Cookie::get('user_id', '');
        $rememberedEmails = Cookie::get('user_email', '');
        $rememberedPasswords = Cookie::get('user_password', '');
        $rememberedRemebers = Cookie::get('user_remember', '');
        // dd($rememberedEmail);
        return view('masteradmin.auth.login',compact('rememberedEmails', 'rememberedPasswords', 'rememberedRemebers','rememberedId'));
    }

    public function store(MasterLoginRequest $request): RedirectResponse
    {
        // dd($request);
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::MASTER_HOME);
    }

    public function destroy(Request $request): RedirectResponse
    {
        // dd($request->session());
        Auth::guard('masteradmins')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();
        

        return redirect('/business/login/');
    }

}

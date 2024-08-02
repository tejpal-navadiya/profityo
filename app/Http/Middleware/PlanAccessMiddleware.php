<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUserDetails;
use Illuminate\Support\Facades\View;

class PlanAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = 'masteradmins';

        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            // dd($user);
            // Set the table for MasterUserDetails model based on the user's unique ID
            $userDetails = new MasterUserDetails();
            $userDetails->setTableForUniqueId($user->buss_unique_id);

            $existingUser = $userDetails->where('user_id', $user->user_id)->first();
            
            if ($existingUser) {
                $userRole = $existingUser->userRole;

                if ($userRole) {
                    // Fetch access rights for the role
                    $access = $userRole->masterUserAccess->pluck('is_access', 'mname')->toArray();
                    View::share('access', $access);
                } else {
                    View::share('access', []);
                }
            } else {
                View::share('access', []);
            }
        } else {
            View::share('access', []);
        }

        return $next($request);
    }

}
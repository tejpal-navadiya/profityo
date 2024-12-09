<?php

namespace App\Http\Requests;

use App\Models\MasterUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
class MasterProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    //  public function rules(): array
    // {
    //     $user = Auth::guard('masteradmins')->user();
    //     // dd($user );
    //     return [
    //         'users_name' => ['required', 'string', 'max:255'],
    //         'users_city_name' => ['required', 'string', 'max:255'],
    //         'users_pincode' => ['required', 'string', 'max:255'],
    //         'country_id' => ['required', 'integer'],
    //         'state_id' => ['required', 'integer'],
    //     ];
    // }
    public function rules(): array
{
    $user = Auth::guard('masteradmins')->user();
    // Debugging the user if needed
    // dd($user);

    return [
        'users_name' => ['required', 'string', 'max:255'],
        'users_city_name' => ['nullable', 'string', 'max:255'],
        'users_pincode' => ['nullable', 'string', 'max:255'],
        'country_id' => ['required', 'integer'],
        'state_id' => ['required', 'integer'],
    ];
}

/**
 * Custom error messages for validation.
 *
 * @return array
 */
public function messages(): array
{
    return [
        'users_name.required' => 'Please enter user name .',
        'country_id.integer' => 'Please enter country.',
        'state_id.required' => 'Please enter state.',
    ];
}

    
}

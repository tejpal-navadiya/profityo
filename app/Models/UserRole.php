<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['id','role_name', 'role_status','description'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::guard('masteradmins')->user();
        // dd($user);
        $uniq_id = $user->user_id;
        $this->setTable($uniq_id . '_py_users_role');
    }

    public function masterUserDetails()
    {
        return $this->hasMany(MasterUserDetails::class, 'role_id', 'role_id');
    }

    public function masterUserAccess()
    {
        return $this->hasMany(MasterUserAccess::class, 'u_id', 'id');
    }


}

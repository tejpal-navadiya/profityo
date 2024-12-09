<?php

namespace App\Http\Controllers\Masteradmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminMenu;
use App\Models\MasterUserAccess;

class UserRoleController extends Controller
{
    //
    public function index(): View
    {
        $user = Auth::guard('masteradmins')->user();
        $roles = UserRole::where(['role_status' => 1, 'id' => $user->id])->get();
        return view('masteradmin.role.index', compact('roles'));
    }

    public function create(): View
    {
        return view('masteradmin.role.add');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::guard('masteradmins')->user();
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ], [
            'role_name.required' => 'Please enter role name.',
        ]);

        $validatedData['id'] = $user->id;
        $validatedData['role_status'] = 1;
        UserRole::create($validatedData);
        \MasterLogActivity::addToLog('Master Admin Users Role Created.');

        return redirect()->route('business.role.index')->with(['role-add' =>__('messages.masteradmin.user-role.add_role_success')]);
    }

    public function edit($role_id, Request $request): View
    {   
        $user = Auth::guard('masteradmins')->user();
        $role = UserRole::where(['role_id' => $role_id , 'id' => $user->id])->firstOrFail();

        return view('masteradmin.role.edit', compact('role'));
    }

    public function update(Request $request, $role_id): RedirectResponse
    {   
        // Find the plan by sp_id
        $user = Auth::guard('masteradmins')->user();
        $roles = UserRole::where(['role_id' => $role_id, 'id' => $user->id])->firstOrFail();

        // Validate incoming request data
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ], [
            'role_name.required' => 'Please enter role name.',
        ]);

        // Update the plan attributes based on validated data
        $roles->where('role_id', $role_id)->update($validatedData);
        \MasterLogActivity::addToLog('Master Admin User Role is Edited.');

        // Redirect back to the edit form with a success message
        return redirect()->route('business.role.edit', ['role' => $roles->role_id])
                        ->with('role-edit', __('messages.masteradmin.user-role.edit_role_success'));

    }

    public function destroy($role_id): RedirectResponse
    {
        //
        // dd($role_id);
        $user = Auth::guard('masteradmins')->user();
        $roles = UserRole::where(['role_id' => $role_id, 'id' => $user->id])->firstOrFail();

        // Delete the plan
        $roles->where('role_id', $role_id)->delete();

        \MasterLogActivity::addToLog('Master Admin User role is Deleted.');
         
        return redirect()->route('business.role.index')
                        ->with('role-delete', __('messages.masteradmin.user-role.delete_role_success'));

    }


    
    // add by dxx.............
    public function Userrole($role_id): View
    {
        $user = Auth::guard('masteradmins')->user();
        
        $userrole = UserRole::where(['role_id' => $role_id, 'id' => $user->id])->firstOrFail();
        // $permissions = AdminMenu::where('pmenu', 0)
        //     ->where('is_deleted', 0)
        //     ->whereIn('mid', array_merge(range(1, 20), [114]))
        //     ->get();
        $permissions = AdminMenu::where('pmenu', 0)
        ->where('is_deleted', 0)
        ->where('mid', '!=', 21) // Exclude parent ID 21
        ->get();
        $reports = AdminMenu::where('pmenu', 21)
            ->where('is_deleted', 0)
            ->get();
// dd($permissions);
        foreach ($permissions as $permission) {
            $this->setPermissionAccess($permission, $role_id);
        }

        foreach ($reports as $report) {
            $this->setPermissionAccess($report, $role_id);
        }

        // Check if the parent Reports checkbox should be checked
        $reports_parent_checked = $this->getIsAccess('reports_parent', $role_id);

        return view('masteradmin.role.user_role_access', compact('permissions', 'reports', 'userrole', 'reports_parent_checked'));
    }

    private function setPermissionAccess(&$item, $role_id)
    {
        $item->is_access = $this->getIsAccess($item->mname, $role_id);
        $item->is_access_add = $this->getIsAccess('add_' . $item->mname, $role_id);
        $item->is_access_view = $this->getIsAccess('view_' . $item->mname, $role_id);
        $item->is_access_update = $this->getIsAccess('update_' . $item->mname, $role_id);
        $item->is_access_delete = $this->getIsAccess('delete_' . $item->mname, $role_id);
    }

    private function getIsAccess($permissionName, $roleId)
    {
        $access = MasterUserAccess::where('role_id', $roleId)
            ->where('mname', $permissionName)
            ->first();

        return $access ? $access->is_access : 0;
        // dd($access);
    }

    public function updaterole(Request $request, $role_id): RedirectResponse
    {
        // dd($request->all()); 
        $user = Auth::guard('masteradmins')->user();
        MasterUserAccess::where(['role_id' => $role_id, 'u_id' => $user->id])->delete();

        // Fetch all admin menu items
        $menus = AdminMenu::where('is_deleted', 0)->get();

        // Fetch the reports data
        $reports = AdminMenu::where('pmenu', 21)
            ->where('is_deleted', 0)
            ->get();

        // Process permissions checkboxes
        foreach ($menus as $menu) {
            $mname = $menu->mname;
            $mtitle = $menu->mtitle;
            $mid = $menu->mid;
            $is_access = $request->has($mname) ? 1 : 0;

            // Insert or update user access
            MasterUserAccess::create([
                'role_id' => $role_id,
                'u_id' => $user->id,
                'mid' => $mid,
                'mtitle' => $mtitle,
                'mname' => $mname,
                'is_access' => $is_access,
            ]);
        }

        // Process reports parent checkbox
        $reports_parent_checked = $request->has('reports_parent') ? 1 : 0;

        // Insert or update user access for reports parent
        MasterUserAccess::create([
            'role_id' => $role_id,
            'u_id' => $user->id,
            'mid' => 21,
            'mtitle' => 'Reports',
            'mname' => 'reports_parent', // Adjust as per your naming convention
            'is_access' => $reports_parent_checked,
        ]);

        // Process individual report checkboxes
        foreach ($reports as $report) {
            $report_name = $report->mname;
            $report_checked = $request->has($report_name) ? 1 : 0;

            // Insert or update user access for each report
            MasterUserAccess::create([
                'role_id' => $role_id,
                'u_id' => $user->id,
                'mid' => $report->mid,
                'mtitle' => $report->mtitle,
                'mname' => $report_name,
                'is_access' => $report_checked,
            ]);
        }
        \MasterLogActivity::addToLog('Master Admin User role Assigned.');
        return redirect()->route('business.role.userrole', ['userrole' => $role_id])
        ->with('user-role', __('messages.masteradmin.user-role.roll_user_access_success'));
    }
   
    

    
}

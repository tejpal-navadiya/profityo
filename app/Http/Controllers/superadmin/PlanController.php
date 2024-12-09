<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Plan;
use App\Models\AdminMenu;
use App\Models\UserAccess;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        // dd('hii');
        $plan = Plan::all();
        return view('superadmin.plans.index')->with('plan',$plan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('superadmin.plans.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $value  = $request->authenticate();
        $validatedData = $request->validate([
            'sp_name' => 'required|string|max:255',
            'sp_amount' => 'required|numeric',
            // 'sp_month' => 'required|integer',
            'sp_desc' => 'nullable|string',
            'sp_user' => 'nullable|integer',
        ], [
            'sp_name.required' => 'The name field is required.',
            'sp_amount.required' => 'The amount field is required.',
            // 'sp_month.required' => 'The validity field is required.',
            'sp_desc.string' => 'The description must be a string.',
            'sp_user.integer' => 'The user field must be an integer.',
        ]);

        // Assuming you have a Plan model to handle database interactions
        Plan::create($validatedData);
        \LogActivity::addToLog('Admin Plan Created.');

        return redirect()->route('plans.index')->with(['plan-add' =>__('messages.admin.plan.add_plan_success')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($sp_id, Request $request): View
    {
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();

        return view('superadmin.plans.edit', compact('plan'));
    }  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sp_id): RedirectResponse
    {
        // Find the plan by sp_id
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();

        // Validate incoming request data
        $validatedData = $request->validate([
            'sp_name' => 'required|string|max:255',
            'sp_amount' => 'required|numeric',
            // 'sp_month' => 'required|integer',
            'sp_desc' => 'nullable|string',
            'sp_user' => 'nullable|integer',
        ], [
            'sp_name.required' => 'The name field is required.',
            'sp_amount.required' => 'The amount field is required.',
            // 'sp_month.required' => 'The validity field is required.',
            'sp_desc.string' => 'The description must be a string.',
            'sp_user.integer' => 'The user field must be an integer.',
        ]);

        // Update the plan attributes based on validated data
        $plan->where('sp_id', $sp_id)->update($validatedData);
        \LogActivity::addToLog('Admin Plan Edited.');

        // Redirect back to the edit form with a success message
        return redirect()->route('plans.edit', ['plan' => $plan->sp_id])
                        ->with('plan-edit', __('messages.admin.plan.edit_plan_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sp_id): RedirectResponse
    {
        //
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();

        // Delete the plan
        $plan->where('sp_id', $sp_id)->delete();

        \LogActivity::addToLog('Admin Plan Deleted.');
         
        return redirect()->route('plans.index')
                        ->with('plan-delete', __('messages.admin.plan.delete_plan_success'));

    }
    public function planrole($sp_id): View
    {
        $plan = Plan::where('sp_id', $sp_id)->firstOrFail();
        $permissions = AdminMenu::where('pmenu', 0)
            ->where('is_deleted', 0)
            ->where('mid', '!=', 21)
            ->get();
        $reports = AdminMenu::where('pmenu', 21)
            ->where('is_deleted', 0)
            ->get();

        foreach ($permissions as $permission) {
            $this->setPermissionAccess($permission, $sp_id);
        }

        foreach ($reports as $report) {
            $this->setPermissionAccess($report, $sp_id);
        }

        // Check if the parent Reports checkbox should be checked
        $reports_parent_checked = $this->getIsAccess('reports_parent', $sp_id);

        return view('superadmin.plans.plan_role_access', compact('permissions', 'reports', 'plan', 'reports_parent_checked'));
    }

    private function setPermissionAccess(&$item, $sp_id)
    {
        $item->is_access = $this->getIsAccess($item->mname, $sp_id);
        $item->is_access_add = $this->getIsAccess('add_' . $item->mname, $sp_id);
        $item->is_access_view = $this->getIsAccess('view_' . $item->mname, $sp_id);
        $item->is_access_update = $this->getIsAccess('update_' . $item->mname, $sp_id);
        $item->is_access_delete = $this->getIsAccess('delete_' . $item->mname, $sp_id);
    }

    private function getIsAccess($permissionName, $roleId)
    {
        $access = UserAccess::where('sp_id', $roleId)
            ->where('mname', $permissionName)
            ->first();

        return $access ? $access->is_access : 0;
    }



    public function updaterole(Request $request, $sp_id): RedirectResponse
    {
        UserAccess::where('sp_id', $sp_id)->delete();

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
            UserAccess::create([
                'sp_id' => $sp_id,
                'mid' => $mid,
                'mtitle' => $mtitle,
                'mname' => $mname,
                'is_access' => $is_access,
            ]);
        }

        // Process reports parent checkbox
        $reports_parent_checked = $request->has('reports_parent') ? 1 : 0;

        // Insert or update user access for reports parent
        UserAccess::create([
            'sp_id' => $sp_id,
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
            UserAccess::create([
                'sp_id' => $sp_id,
                'mid' => $report->mid,
                'mtitle' => $report->mtitle,
                'mname' => $report_name,
                'is_access' => $report_checked,
            ]);
        }

        return redirect()->route('plans.planrole', ['plan' => $sp_id])
            ->with('plan-role', __('messages.admin.plan.roll_plan_access_success'));
    }


}

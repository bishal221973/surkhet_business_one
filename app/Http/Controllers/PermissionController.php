<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index($roleId){
        $role=Role::find($roleId)->load('permissions');

        return view('hr.permission',[
            'role'=>$role,
        ]);
    }

    public function store(Request $request){
        $permissions = $request->permissions;

        // Find the role you want to assign permissions to
        $role = Role::find($request->role_id); // replace 3 with your role ID if needed

        // Sync permissions
        $role->syncPermissions($permissions);
        createTimeline(
            'Change Role Permission',
            'Permission of role ' . $role->name . ' has been updated by ' . auth()->user()->name,
            'key'
        );
        return redirect()->back()->with('success', 'Permissions have been assigned successfully');
    }
}

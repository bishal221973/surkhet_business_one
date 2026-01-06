<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::where('organization_id', organization()->id)->latest()->get();
        return view('hr.role',[
            'roles'=>$roles,
            'role'=>new Role(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate([
            'name' => 'required',
        ]);

        $data['organization_id'] = organization()->id;

        // Role::create($data);

        $role = Role::query()->insertGetId([
            'name' => $data['name'],
            'guard_name' => 'web',
            'organization_id' => organization()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->back()->with('success', 'Role has been created successfully');
    }

    public function edit($id)
    {
        // return $id;
        $role=Role::find($id);
        $roles = Role::where('organization_id', organization()->id)->latest()->get();
        return view('hr.role', [
            'roles' => $roles,
            'role' => $role
        ]);
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
        ]);


        // Role::create($data);
        $role = Role::find($id);
        $role->update([
            'name' => $data['name'],
        ]);


        return redirect()->route('role.index')->with('success', 'Role has been created successfully');
    }

    public function destroy($id){
        Role::find($id)->delete();
        return redirect()->route('role.index')->with('success', 'Role has been deleted successfully');
    }
}

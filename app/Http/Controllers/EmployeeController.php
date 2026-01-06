<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $roles=Role::where('organization_id', organization()->id)->get();
        $employees=Employee::latest()->where('organization_id', organization()->id)->with('user')->get();
        return view('hr.employee', [
            'employee'=>new Employee(),
            'employees'=>$employees,
            'roles'=>$roles
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Employee::rules());

        try {
            DB::transaction(function () use ($data, $request) {


                // Update organization main table
                if ($request->hasFile('profile')) {
                    $data['profile'] = $request->file('profile')->store('organization_logos', 'public');
                }
                $user=User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' =>Hash::make($data['password']),
                    'profile' => $data['profile'],
                ]);

                Employee::create([
                    'user_id'=>$user->id,
                    'salary'=>$data['salary'],
                    'joining_date'=>getAdDate($data['joining_date']),
                ]);
                $user->syncRoles($data['role']);

                createTimeline('New employee created', "New employee ".$data['name'] . "have been created by ".auth()->user()->name, 'user');
            });

            return back()->with('success', 'New employee has been created successfully!');

        } catch (\Exception $e) {
            // Optional: log error
            Log::error('Organization update failed: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong. Please try again.');
        }

    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
            'status' => 'required|boolean',
        ]);

        $employee = Employee::findOrFail($request->id);
        $employee->user->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'status' => $request->status,
        ]);
    }

    public function edit(Employee $employee)
    {
        $roles=Role::where('organization_id', organization()->id)->get();
        $employees=Employee::latest()->where('organization_id', organization()->id)->with('user')->get();
        return view('hr.employee', [
            'employee'=>$employee,
            'employees'=>$employees,
            'roles'=>$roles
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'profile' => 'nullable',
            'salary' => 'required',
            'role' => 'required',
            'joining_date' => 'required',
        ]);

        try {
            DB::transaction(function () use ($data, $request, $employee) {


                // Update organization main table
                if ($request->hasFile('profile')) {
                    $data['profile'] = $request->file('profile')->store('organization_logos', 'public');
                    $employee->user->update([
                        'profile' => $data['profile'],
                    ]);
                }
                $employee->user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);

                $employee->update([
                    'salary' => $data['salary'],
                    'joining_date' => getAdDate($data['joining_date']),
                ]);

                $employee->user->syncRoles($data['role']);


                createTimeline('Employee updated', "Selected employee " . $data['name'] . "have been updated by " . auth()->user()->name, 'user');
            });

            return redirect()->route('employee.index')->with('success', 'New employee has been created successfully!');

        } catch (\Exception $e) {
            // Optional: log error
            Log::error('Organization update failed: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    public function destroy(Employee $employee)
    {
        try {
            DB::transaction(function () use ($employee) {
                $employee->user->delete();
                $employee->delete();

                createTimeline('Employee deleted', "Selected employee " . $employee->user->name . "have been deleted by " . auth()->user()->name, 'user');
            });

            return redirect()->route('employee.index')->with('success', 'Employee has been deleted successfully!');

        } catch (\Exception $e) {
            // Optional: log error
            Log::error('Employee deletion failed: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}

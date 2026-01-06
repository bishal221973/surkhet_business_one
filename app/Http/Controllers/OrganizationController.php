<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrganizationSetting;
use Illuminate\Support\Facades\Log;

class OrganizationController extends Controller
{
    public function index(){
        $settings=OrganizationSetting::where('organization_id',auth()->user()->organization_id)->get();
        return view('settings.organization',[
            'settings'=>$settings
        ]);
    }


    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'vat_number' => 'nullable',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'date_type' => 'required',
            'date_format' => 'required',
            'logo' => 'nullable|max:2048',
        ]);

        try {
            DB::transaction(function () use ($data, $request) {

                $org = auth()->user()->organization;

                // Update organization main table
                if($request->hasFile('logo')) {
                    $data['logo'] = $request->file('logo')->store('organization_logos','public');
                    $org->update(['logo' => $data['logo']]);
                }
                $org->update([
                    'name' => $data['name'],
                    'vat_number' => $data['vat_number'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                ]);

                // Update organization settings
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'date_type')
                    ->update(['value' => $data['date_type']]);

                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'date_format')
                    ->update(['value' => $data['date_format']]);

                createTimeline('Update Organization Setting',null,'organization');
                });

            return back()->with('success', 'Organization updated successfully!');

        } catch (\Exception $e) {
            // Optional: log error
            Log::error('Organization update failed: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }


}

<?php

namespace App\Http\Controllers;

use App\Jobs\DemoMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrganizationSetting;
use Illuminate\Support\Facades\Log;

class EmailSettingController extends Controller
{
    public function index()
    {
        $settings = OrganizationSetting::where('organization_id', auth()->user()->organization_id)->get();
        return view('settings.email', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'email_provider' => 'required',
            'email_host' => 'required',
            'email_port' => 'required',
            'email_username' => 'required',
            'email_password' => 'required',
            'email_encryption' => 'required',
            'email_from_adress' => 'required',
            'email_from_name' => 'required',
        ]);

        try {
            DB::transaction(function () use ($data, $request) {

                $org = auth()->user()->organization;

                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_provider')
                    ->update(['value' => $data['email_provider']]);

                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_host')
                    ->update(['value' => $data['email_host']]);
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_port')
                    ->update(['value' => $data['email_port']]);
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_username')
                    ->update(['value' => $data['email_username']]);
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_password')
                    ->update(['value' => $data['email_password']]);
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_encryption')
                    ->update(['value' => $data['email_encryption']]);
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_from_adress')
                    ->update(['value' => $data['email_from_adress']]);
                OrganizationSetting::where('organization_id', $org->id)
                    ->where('key', 'email_from_name')
                    ->update(['value' => $data['email_from_name']]);
                createTimeline('Update Email Setting', null, 'email');

            });

            return back()->with('success', 'Email Setting has been updated successfully!');

        } catch (\Exception $e) {
            // Optional: log error
            Log::error('Organization update failed: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function demoMail(Request $request){
        $data= $request->validate([
            'subject' => 'required',
            'to' => 'required',
            'message' => 'required',
        ]);
        try{
            DemoMailJob::dispatch($data['to'], $data['subject'], $data['message']);
            createTimeline('Send Demo Mail', null, 'email');

        }catch(\Exception $e){
            Log::error('Demo mail send failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->back()->with('success', 'Demo email has been sent successfully!');
    }

}

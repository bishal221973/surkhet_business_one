<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function employeeWelcomeMailFormat(){
        $settings = \App\Models\NotificationSetting::where('organization_id', organization()->id)->get();
        return view('settings.notification',[
            'settings' => $settings
        ]);
    }


    public function store(Request $request)
    {
        $organizationId = auth()->user()->organization_id; // or however you get it

        $notifications = [
            'employee_welcome_mail',
            'client_welcome_mail',
            'invoice_created_mail',
            'payment_received_mail',
            'upcoming_due_mail',
            'overdues_mail',
        ];

        foreach ($notifications as $notification) {
            \App\Models\NotificationSetting::updateOrCreate(
                [
                    'organization_id' => $organizationId,
                    'notification' => $notification,
                ],
                [
                    'status' => $request->has($notification) ? 1 : 0,
                ]
            );
        }

        return back()->with('success', 'Notification settings updated successfully.');
    }
}

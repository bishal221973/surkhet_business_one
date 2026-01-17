<?php

namespace App\Http\Controllers;

use App\Models\MailFormat;
use App\Mail\DemoFormatMail;
use Illuminate\Http\Request;
use App\Models\OrganizationSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationFormatController extends Controller
{
    public function employeeWelcomeMailFormat(){
        $formats=MailFormat::where('organization_id',1)->get();
        return view('settings.formats.mail.employeeMail',[
            'formats'=>$formats
        ]);
    }

    public function employeeWelcomeMailFormatStore(Request $request){
        $data=$request->validate([
            'subject' => 'required',
            'body' => 'required',
            'type' => 'required',
        ]);

        MailFormat::updateOrCreate(
            ['type' => $data['type']], // search condition
            [
                'subject' => $data['subject'],
                'body' => $data['body'],
            ]
        );
        return redirect()->back()->with('success', 'Mail format created successfully.');
    }

    public function sendDemoMail(Request $request){
        $data= $request->validate([
            'type' => 'required',
            'to' => 'required',
        ]);
        try{
            $mailFormat=MailFormat::where('type', $data['type'])->where('organization_id',organization()->id)->first();
            Mail::to($data['to'])->send(new DemoFormatMail($mailFormat, organization()));
            createTimeline('Send Demo Mail', null, 'email');

        }catch(\Exception $e){
            return $e->getMessage();
            Log::error('Demo mail send failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->back()->with('success', 'Demo email has been sent successfully!');
    }
}

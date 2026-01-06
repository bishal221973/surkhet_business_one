<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timeline;
use Ramsey\Uuid\Type\Time;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function myProfile(){
        $timelines=Timeline::where('user_id',auth()->user()->id)->get()->groupBy('date');
        return view('settings.profile',[
            'timelines'=>$timelines,
        ]);

    }

    public function updateProfile(Request $request){
        $data=$request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        $user=User::find(auth()->user()->id);
        if($request->hasFile('profile')) {
            $data['profile'] = $request->file('profile')->store('profile','public');
            $user->update(['profile' => $data['profile']]);
        }
        $user->update($data);
        createTimeline('Update profile', null, 'user');

        return back()->with('success','Your profile have been updated successfully');
    }
}

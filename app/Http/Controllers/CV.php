<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Model\FamilyMember;
use App\Model\Bio;
use App\Model\Education;
use Illuminate\Foundation\Auth\User;
use App\Model\Photo;
use App\Model\State;
use App\Model\WorkHistory;
use App\Model\Project;
use Mail;

class CV extends Controller {

    public function index() {
        $data = [];
        $users = FamilyMember::leftJoin('photos', function ($join) {
                    $join->on('family_members.nickname', '=', 'photos.username')
                            ->where('photos.for_section', '=', 'profile');
                })->get();

        //if it is a single member all all the members
        $data['member'] = false;
        $data['family'] = $users;
        return view('welcome', $data);
    }

    public function display(FamilyMember $family) {
        $data = [];
        $data['member'] = true;
        $state = State::where('id', unserialize($family->address)['state'] + 1)
                        ->first()['state'];
        $data['address'] = array_merge(array_slice(unserialize($family->address), 0, 3), ['state' => $state]);
        //Match social media icons with their proper urls
        $social_media = explode(',', str_replace('~', '/', $family->social_media));
        $social_media_icons = ['linkedin' => 'linkedin', 'plus.google' => 'google-plus', 'facebook' => 'facebook', 'twitter' => 'twitter'];
        foreach ($social_media as $value) {
            foreach ($social_media_icons as $key => $icon) {
                $data['social_media'][] = [
                    'url' => $value,
                    'icon' => (str_contains($value, $key)) ? $icon : ''];
            }
        }


        $data['family'] = $family;
        $data['user'] = User::where('name', '=', $family->nickname)->first();
        $data['bio'] = Bio::where('username', '=', $family->nickname)->first();
        $data['edus'] = Education::where('username', '=', $family->nickname)->get();
        $data['works'] = WorkHistory::where('username', '=', $family->nickname)->get();
        $data['projects'] = Project::where('username', '=', $family->nickname)->get();
        $data['pic'] = Photo::where('for_section', 'profile')
                ->where('username', $family->nickname)
                ->first();
        
        return view('family.display', $data);
    }

    public function sendMail(Request $request, FamilyMember $family) {
    
        $user = User::where('name', '=', $family->nickname)->first();
     

        Mail::send('family.mail', ['user' => $request->name, 'family' => $family,'msg'=>explode("\n",$request->message)], function ($m) use ($user, $request) {
            $m->from($request->email, $request->name);
            $m->to($user->email, $user->name)->subject('cv contact');
        });

        if (Mail::failures()) {   
            return back()->withErrors('There were errors sending your message...');
        } 
            $request->session()->flash('alert-success', 'Thank you for your message. It has been sent!');
             return back(); 
        }

}

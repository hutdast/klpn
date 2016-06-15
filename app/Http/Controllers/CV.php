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
        $users = FamilyMember::leftJoin('photos as p', function ($join) {
                    $join->on('family_members.nickname', '=', 'p.username')
                            ->where('p.for_section', '=', 'profile');
                            
                })->orderBy('family_members.seniority','ASC')
                        ->get();

                
                
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
        $data['edus'] = Education::where('username', '=', $family->nickname)
                ->orderBy('start_date', 'asc')
                ->get();
        $data['works'] = WorkHistory::where('username', '=', $family->nickname)
                ->orderBy('start_date', 'asc')
                ->get();
        $data['projects'] = Project::where('username', '=', $family->nickname)
                ->orderBy('title', 'desc')
                ->get();
        $data['pic'] = Photo::where('for_section', 'profile')
                ->where('username', $family->nickname)
                ->first();

        return view('family.display', $data);
    }

    public function sendMail(Request $request, FamilyMember $family) {

        $user = User::where('name', '=', $family->nickname)->first();
        $data =[];
        $data['guest'] = $request;
        $data['family'] = $family;
        $data['msg'] = explode("\n", $request->message);
        
        Mail::send('family.mail',$data, function ($m) use ($user, $request) {
            $m->from('hutdast@yahoo.com', $request->email);//hudast@yahoo.com is verified email address, in order to avoid code 553 errors
            $m->to($user->email, $user->name)->subject('From my profile');
        });

        $request->session()->flash('alert-success', 'Thank you for your message. It has been sent!');
        return back();
    }

}

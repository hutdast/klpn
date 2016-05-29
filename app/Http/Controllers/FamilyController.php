<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\State;
use App\Http\Requests;
use Auth;
use \Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Redirect;
use App\Model\FamilyMember;
use App\Model\Bio;
use App\Model\Education;
use Illuminate\Foundation\Auth\User;
use App\Model\Photo;
use App\Model\WorkHistory;
use App\Model\Project;
use Session;
use DB;
use Hash;

class FamilyController extends Controller {

    public function index() {
        $data = [];
        if (Auth::check() && Auth::user()->name == 'admin') {

            $data['family'] = FamilyMember::all();
            $data['state'] = State::lists('state_code');
            $data['username'] = '';
            Session::put('disabled', 'disabled');
            return view('family.edit', $data);
        } elseif (Auth::check() && Auth::user()->name != 'admin') {

            return Redirect::route('edit', [Auth::user()->name]);
        } else {
            $users = FamilyMember::leftJoin('photos', function ($join) {
            $join->on('family_members.nickname','=','photos.username')
                 ->where('photos.for_section','=', 'profile');
        })->get();
        
            $data['family'] = $users;
            return view('welcome', $data);
        }
    }

    public function store(Request $request) {
        $rules = [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'nickname' => 'string|required|unique:family_members',
            'lastname' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'address_1' => 'required',
            'city' => 'required|string',
            'zip' => 'required',
            'social_media' => 'required',
            'birthday' => 'required'
        ];

        /*
         * 'password' => 'required|min:6',
         */
        $input = $request->capture()->toArray();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator->messages());
        } elseif (FamilyMember::where('nickname', '=', $request->input('nickname'))->count() > 0) {
            return Redirect::back()->withInput()->withErrors('username is already taken');
        } else {
            $user = new \App\User();
            $user->name = $request->input('nickname');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $family = new FamilyMember();
            $family->firstname = $request->input('firstname');
            $family->lastname = $request->input('lastname');
            $family->nickname = $request->input('nickname');
            $family->birthday = Carbon::parse($request->input('birthday'));
            $family->social_media = $request->input('social_media');
            $family->phone = $request->input('phone');
            
            $address = [
                'address_1' => $request->input('address_1'),
                'address_2' => $request->input('address_2'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip' => $request->input('zip')];
            $family->address = serialize($address);
            $family->created_at = Carbon::now();
            $family->save();
            $bio = new Bio();
            $bio->username = $family->nickname;
            $bio->motto = $request->input('motto');
            $bio->short_intro = $request->input('short_intro');
            $bio->self_description = $request->input('self_description');
            $bio->save();
            $edu_input = emptyArray($request->input('education')) ? [] : $request->input('education');
            $size_arr = isset($edu_input['title']) ? sizeof($edu_input['title']) : 0;
            $edu_arr = [];
            if ($size_arr > 0) {
                $format = 'Y-m-d';

                for ($i = 0; $i < $size_arr; $i++) {
                    $start = explode("/", trim($edu_input['start_date'][$i]));
                    $end = explode("/", $edu_input['end_date'][$i]);
                    $start = Carbon::create($start[2], $start[0], $start[1]);
                    $end = Carbon::create($end[2], $end[0], $end[1]);
                    $edu_arr[] = array(
                        'username' => $family->nickname,
                        'title' => $edu_input['title'][$i],
                        'school' => $edu_input['school'][$i],
                        'start_date' => $start->format($format),
                        'end_date' => $end->format($format),
                        'location' => $edu_input['location'][$i]
                    );
                }
                 Education::insert($edu_arr);
            }//end of checking if user did input any entry in education
           

            return redirect()->route('edit', [$family->nickname]);
        }
    }

    public function update(Request $request, $family) {
        $rules = [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required',
            'address_1' => 'required',
            'city' => 'required|string',
            'zip' => 'required',
            'social_media' => 'required',
            'birthday' => 'required'
        ];
        $input = $request->capture()->toArray();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            return Redirect::back()->withInput()->withErrors($validator->messages());
        } else {
           
           
            $address = [
                'address_1' => $request->input('address_1'),
                'address_2' => $request->input('address_2'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip' => $request->input('zip')];
//            
            $family_arr = array(
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'birthday' => Carbon::parse($request->input('birthday')),
                'social_media' => str_replace("/", "~", $request->input('social_media')),
                'phone' => $request->input('phone'),
                'address' => serialize($address),
                'created_at' => Carbon::now()
            );
            FamilyMember::where('nickname', $family->nickname)->update($family_arr);
            $bio_arr = array(
                'username' => $family->nickname,
                'motto' => $request->input('motto'),
                'short_intro' => $request->input('short_intro'),
                'self_description' => $request->input('self_description')
            );
            //Since it not requred at the creation of the account 
            //there would not be any username in dashboard page
            $bio = Bio::where('username', $family->nickname);
            if ($bio->count() == 1) {
                $bio->update($bio_arr);
            } else {
                Bio::insert($bio_arr);
            }

            $work_input = $request->input('work');
            $project_input = $request->input('project');
            $edu_input = $request->input('education');
            $this->updateEdu($edu_input, $family);
            $this->updateWork($work_input, $family);
            $this->updateProject($project_input, $family);

   
             $request->session()->flash('alert-success', 'profile updated!');
            return redirect()->route('edit', [$family->nickname]);
        }
    }

    /*
     * Updating education table
     */

    
    public function updateEdu($edu_input, $family) {
        
        $size_arr = count(array_filter($edu_input['title'], function($x) { return !empty($x); }));
        $edu_arr = [];

        if ($size_arr > 0) {

            $format = 'Y-m-d';
            for ($i = 0; $i < $size_arr; $i++) {
                    $end = Carbon::parse($edu_input['end_date'][$i]);
                    $start = Carbon::parse($edu_input['start_date'][$i]);

                $edu_arr = array(
                    'username' => $family->nickname,
                    'title' => $edu_input['title'][$i],
                    'school' => $edu_input['school'][$i],
                    'start_date' => $start->format($format),
                    'end_date' => $end->format($format),
                    'location' => $edu_input['location'][$i]
                );    
                 
               if(isset($edu_input['id'][$i])){
                   Education::where('id',$edu_input['id'][$i])->update($edu_arr);
             //Else there is no such id in the datatabase, hence we save the new entry
                }else{
                    Education::insert($edu_arr);
                }  
              
            }
           
        }//end of checking if $edu_input is set, check if user did modify any entry  in education

      
    }

//end of updateEdu
    /*
     * Update work history table
     */

    public function updateWork($work_input, $family) {
        
        $work_arr = [];
        $size_arr =  count(array_filter($work_input['company'], function($x) { return !empty($x); }));
        if ($size_arr > 0) {
       
            $format = 'Y-m-d';
            for ($i = 0; $i < $size_arr; $i++) {
                    $end = Carbon::parse($work_input['end_date'][$i]);
                    $start = Carbon::parse($work_input['start_date'][$i]);
      

                $work_arr = array(
                    'username' => $family->nickname,
                    'company' => $work_input['company'][$i],
                    'position' => $work_input['position'][$i],
                    'start_date' => $start->format($format),
                    'end_date' => $end->format($format),
                    'job_description' => $work_input['job_description'][$i]
                );
                if(isset($work_input['id'][$i])){
                    WorkHistory::where('id',$work_input['id'][$i])->update($work_arr);
             //Else there is no such id in the datatabase, hence we save the new entry
                }else{
                    WorkHistory::insert($work_arr);
                }
                
          
            }//end of for loop
        }//end of  if ($size_arr > 0){ for $work_input
    }

    /*
     * Update project table
     */

    public function updateProject($project_input, $family) {

        $project_arr = [];

        $size_arr =  count(array_filter($project_input['title'], function($x) { return !empty($x); }));
        if ($size_arr > 0) {
            for ($i = 0; $i < $size_arr; $i++) {
                
                $project_arr = array(
                    'username' => $family->nickname,
                    'title' => (!empty($project_input['title'][$i]) ? $project_input['title'][$i] : 'not_set'),
                    'url' => (!empty($project_input['url'][$i]) ? $project_input['url'][$i] : 'not_set'),
                    'description' => $project_input['description'][$i]
                );
                 
                if(isset($project_input['id'][$i])){
      Project::where('id',$project_input['id'][$i])->update($project_arr);
             //Else there is no such id in the datatabase, hence we save the new entry
                }else{
                     Project::insert($project_arr);
                }
                
            }//end of for loop
        }//end of  if ($size_arr > 0){ for $project_input
    }

    /*
     * reset password, username and email
     */

    public function updateCredentials(Request $request) {
        $rules = [
            'nickname' => 'string',
            'email' => 'email|max:255',
            'password' => 'min:6'];
        $input = $request->capture()->toArray();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->messages());
        } else {
            if ($request->nickname && ($request->user != $request->nickname)) {
                Bio::where('username', $request->user)->update(['username' => $request->nickname]);
                Education::where('username', $request->user)->update(['username' => $request->nickname]);
                Photo::where('username', $request->user)->update(['username' => $request->nickname]);
                FamilyMember::where('nickname', $request->user)->update(['nickname' => $request->nickname]);
                User::where('name', $request->user)->update(['name' => $request->nickname]);
            } elseif ($request->email && ($request->email != $request->oldemail)) {
                User::where('name', $request->user)->update(['email' => $request->email]);
                DB::table('password_resets')->where('email', $request->oldemail)
                        ->update(['email' => $request->email]);
            } elseif ($request->password) {
                User::where('name', $request->user)->update(['password' => Hash::make($request->password)]);
            }

            return redirect()->route('edit', [$request->user])->with('message', 'You info is updated');
        }
    }

    public function showHome(Request $request, $family) {

        $data = [];
        $data['state'] = State::lists('state');
        $data['address'] = unserialize($family->address);
        $data['family'] = $family;
        $data['user'] = User::where('name', '=', $family->nickname)->first();
        $data['bio'] = Bio::where('username', '=', $family->nickname)->first();
        $data['edus'] = Education::where('username', '=', $family->nickname)->get();
        $data['pics'] = Photo::where('username', $family->nickname)->get();
        $data['works'] = WorkHistory::where('username', $family->nickname)->get();
        $data['projects'] = Project::where('username', $family->nickname)->get();
        return view('home', $data);
    }

    /*
     * Delete Row when editing CV
     */

    public function deleteRow(Request $request) {
        $result = '';
        if ($request->table == 'education') {
            Education::where('id', $request->id)
                    ->delete();
            $result = 'successfully deleted!';
        } elseif ($request->table == 'work') {
            WorkHistory::where('id', $request->id)
                    ->delete();
            $result = 'successfully deleted!';
        } elseif ($request->table == 'project') {
            Project::where('id', $request->id)
                    ->delete();
            $result = 'successfully delete project!';
        } else {
            $result = 'Nothing get deleted';
        }

        return response()->json(['result' => $result]);
    }

    /**
     * delete photos
     */
    public function modifyPhoto(Request $request) {
        if ($request->action == 'delete') {
            Photo::where('id', $request->id)
                    
                    ->delete();
           $result = 'successfully deleted!';
        } elseif ($request->action == 'update') {
            $section = Photo::where('username', Auth::user()->name)
                            ->where('for_section', 'profile')
                    ->count();
                  
             if ( $section ==1 && $request->for_section =='profile') {
                 $result = 'A profile picture already exist, change the tag to something else'; 
                }elseif($section == 0 || $request->for_section !='profile'){
                      Photo::where('id',$request->id)
            ->update(['for_section'=>$request->for_section]);
                     $result = 'successfully updated! ';     
                }
           
      
        }
        
        return response()->json(['result' => $result]);
    }

    /**
     * Upload function
     */
    public function upload() {
        $pic = new Photo();
        //Get the file from the request
        $file = array('image' => Input::file('image'));
        //Rules for acceptable extension
        $rules = ['image' => 'required',
            'mimes: JPEG jpg png bmp  max_size:1920000'];

        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {

            return Redirect::to('/')->withErrors($validator);
        } else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $destinationPath = 'images/family';
                $extension = Input::file('image')->getClientOriginalExtension();
                $filename = pathinfo(Input::file('image'), PATHINFO_FILENAME);
                //Name each picture after their ownwer firstname and id

                $name = $filename . Auth::user()->name . Auth::user()->id;
                $fileName = $name . '.' . $extension;
                $pic->username = Auth::user()->name;
                $pic->url = $destinationPath . '/' . $fileName;
                /**
                 * if this user (username) has not yet have a profile picture,
                 * then this picture will the profile picture.
                 */
                $section = Photo::where('username', Auth::user()->name)
                        ->where('for_section', 'profile')
                        ->first();
                if (!$section) {
                    $pic->for_section = 'profile';
                }
                $pic->save();

                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                Session::flash('success', 'Upload successfully');
                return Redirect::to('/');
            } else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('/');
            }
        }
    }

}

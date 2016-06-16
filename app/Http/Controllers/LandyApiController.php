<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\FamilyMember;
use App\Http\Requests;
use \Illuminate\Foundation\Auth\User;
use Auth;//Auth must be imported before using auth::attempt()

class LandyApiController extends Controller
{
   /**
    * apiAccess(Request $request, FamilyMember $family) authenticates user and once authneticated a token is returned
    * to the user else a notification of failed authentication is sent. 
    * 
    */
   function apiAccess(Request $request) 
   {
       
            $user = User::where('name','=',$request->username)
                    ->first();
       if(!isset($user)){
           return response()->json(['response'=>'invalid']);
       }
    
       if (Auth::attempt(['email'=>$user->email,'password'=>$request->password])){
           
           return response()->json(['response'=>'success']);
       }else{
          return response()->json(['response'=>'unauthorized']);
       }
      
   }//End of apiAccess(Request $request)
   
   /**
    * Testing api
    */
  
   function test(Request $request) {

         return response()->json(['token'=>csrf_token()]);
   }
   
}

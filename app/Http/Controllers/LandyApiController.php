<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\FamilyMember;
use App\Http\Requests;

class LandyApiController extends Controller
{
   /**
    * apiAccess(Request $request, FamilyMember $family) authenticates user and once authneticated a token is returned
    * to the user else a notification of failed authentication is sent. 
    * 
    */
   function apiAccess(Request $request, FamilyMember $family) 
   {
       
   }//End of apiAccess(Request $request, FamilyMember $family)
   
   /**
    * Testing api
    */
   function api(Request $request, FamilyMember $family) 
   {
       return ['success','api','went','thru'];
   }
   
   
}

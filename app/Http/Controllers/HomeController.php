<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
     
        if(Auth::check()){
             
        $data['message'] = 'testing variables';
        $data['state'] = \App\Model\State::lists('state');
         $data['disabled'] = ' ';
        return view('home',$data);
        }else{
            return view('welcome');
        }
      
    }
    
    
    
    
    
    
}

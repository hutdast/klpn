<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::bind('family',function($value){
    return \App\Model\FamilyMember::where('nickname',$value)->first();
});



Route::get('/','FamilyController@index');
Route::post('createinfo', ['middleware' => 'auth','as'=>'save_info','uses'=>'FamilyController@store']);
Route::post('update/{family}',['middleware' => 'auth','as'=>'update_user','uses'=>'FamilyController@update']);
Route::post('credential',['middleware' => 'auth','as'=>'update_credential','uses'=>'FamilyController@updateCredentials']);
Route::get('photo',['middleware' => 'auth','as'=>'modify_pic','uses'=>'FamilyController@modifyPhoto']);
Route::get('dashboard/{family}', ['middleware' => 'auth','as'=>'edit','uses'=>'FamilyController@showHome']);
Route::post('upload',['middleware' => 'auth','as'=>'upload','uses'=>'FamilyController@upload']);
Route::get('education_delete',['middleware' => 'auth','as'=>'delete_row','uses'=>'FamilyController@deleteRow']);
Route::get('cv',['as'=>'all_cvs','uses'=>'CV@index']);
Route::get('cv/{family}',['as'=>'member_cv','uses'=>'CV@display']);
Route::post('mail/{family}',['as'=>'send_mail','uses'=>'CV@sendMail']);

//API routes
Route::get('api',['as'=>'api','uses'=>'LandyApiController@index']);
Route::post('api/login',['as'=>'api_access','uses'=>'LandyApiController@apiAccess']);


Route::auth();



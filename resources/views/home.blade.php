@extends('layouts.app')

@section('title')
Create an entry 
@stop

@section('content')
<section  style="margin-top: 10%;">
    @if($family->nickname != 'admin')
    
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
  </div> <!-- end .flash-message -->

    <div class="panel-heading" data-toggle="collapse" data-target="#edit-info">
        <button class="btn btn-primary"> Edit your info below <i class="fa fa-chevron-down"></i></button>  
        <a class="pull-right" href="{{ URL::route('member_cv',[$family->nickname]) }}"> {{$family->nickname }} 's CV</a>

    </div>

    <div id="edit-info" class="panel-body collapse">
        {!! Form::open(['route'=>['update_user',$family->nickname]]) !!}
        <div class="form-group required">
            {!! Form::label('firstname', 'Firstname:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::text('firstname',$family->firstname, ['class' => 'form-control', 'placeholder'=>'Firstname']) !!}
            {!! $errors->first('firstname', '<span style="color:red;" >:message</span>') !!}
        </div>

        <div class="form-group required">
            {!! Form::label('lastname', 'Lastname:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::text('lastname',$family->lastname,['class' => 'form-control']) !!}
            {!! $errors->first('lastname', '<span style="color:red;" >:message</span>') !!}
        </div>


        <div class="form-group required">
            {!! Form::label('phone', 'Primary Phone:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::input('phone','phone', $family->phone, ['class' => 'form-control']) !!}
            {!! $errors->first('phone', '<span style="color:red;" >:message</span>') !!}
        </div>


        @if($address) 

        <div class="form-group required">
            {!! Form::label('address', 'Address:',['class' => 'col-sm-2 control-label', 'placeholder'=>'address','style' => 'width:10%;']) !!}
            <span> Street: </span>{!! Form::text('address_1', $address['address_1'], ['style' => 'width:20%;']) !!}
            <span> Apt#: </span>{!! Form::text('address_2',$address['address_2'], ['style' => 'width:6%;']) !!}
            {!! $errors->first('street', '<span style="color:red;" >:message</span>') !!}
            <span  style="padding-left: 10px;"> City: </span> {!! Form::text('city',$address['city'], ['style' => 'width:10%;']) !!}
            {!! $errors->first('city', '<span style="color:red;" >:message</span>') !!}
            <span style="padding-left: 10px;"> State: </span> 
            {!! Form::select('state', $state, $address['state'],['style' => 'width:10%;']) !!}
            {!! $errors->first('state', '<span style="color:red;" >:message</span>') !!}
            <span  style="padding-left: 10px;"> Zip: </span> {!! Form::text('zip',$address['zip'], ['style' => 'width:10%;']) !!}
            {!! $errors->first('zip', '<span style="color:red;" >:message</span>') !!}
        </div>
        @endif



        <div class="form-group required">
            {!! Form::label('social_media (seperate by a comma)', null,['class' => 'col-sm-2 control-label', 'placeholder'=>'Twitter/facebook']) !!}
            {!! Form::text('social_media',str_replace("~","/",$family->social_media), ['class' => 'form-control']) !!}
            {!! $errors->first('social_media', '<span style="color:red;" >:message</span>') !!}
        </div>

        <div class="form-group required">
            {!! Form::label('birthday', 'Date of birth:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::text('birthday',$family->birthday, ['class' => 'form-control datepicker']) !!}
            {!! $errors->first('birthday', '<span style="color:red;" >:message</span>') !!}
        </div>



        @if(isset($bio->motto))
        <div class="form-group required">
            {!! Form::label('motto', 'Motto:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::text('motto',$bio->motto, ['class' => 'form-control', 'placeholder'=>'Do what you know, Do what what you must!']) !!}
        </div>
        @else
        <div class="form-group required">
            {!! Form::label('motto', 'Motto:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::text('motto',null, ['class' => 'form-control', 'placeholder'=>'Do what you know, Do what what you must!']) !!}
        </div>
        @endif

        @if(isset($bio->short_intro))
        <div class="form-group required">
            {!! Form::label('quick_description', 'The lead sentences:',['class' => 'col-sm-2 control-label','placeholder'=>'sentence that grab employers']) !!}
            {!! Form::text('short_intro', $bio->short_intro, ['class' => 'form-control']) !!}
        </div>
        @else
        <div class="form-group required">
            {!! Form::label('quick_description', 'The lead sentences:',['class' => 'col-sm-2 control-label','placeholder'=>'sentence that grab employers']) !!}
            {!! Form::text('short_intro',null, ['class' => 'form-control']) !!}
        </div>
        @endif

        @if(isset($bio->self_description))
        <div class="form-group required">
            {!! Form::label('self_description', 'Self-Description:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::textArea('self_description', $bio->self_description, ['class' => 'form-control']) !!}
        </div>
        @else
        <div class="form-group required">
            {!! Form::label('self_description', 'Self-Description:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::textArea('self_description',null, ['class' => 'form-control']) !!}
        </div>
        @endif

       

        <h3  style="margin-top: 10%;">Educations</h3>
        <table  class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td>Title </td>
                    <td>Start date </td>
                    <td>End Date </td>
                    <td>School </td>
                    <td>Url </td>
                    <td>Action </td>
                </tr>
            </thead>
            <tbody id="educations">

                @if(isset($edus))
                @foreach($edus as $edu)
                <tr class="edu-row">
                     {!! Form::input('hidden','education[id][]',$edu->id, []) !!}
                    <td style="width: 25%;">{!! Form::text('education[title][]',$edu->title, ['placeholder'=>'high school/trade school']) !!}</td>
                    <td style="width: 15%;">{!! Form::text('education[start_date][]',$edu->start_date, ['class'=>'datepicker edu-update']) !!}</td>
                        
                    <td style="width: 15%;">{!! Form::text('education[end_date][]',$edu->end_date, ['class'=>'datepicker']) !!}</td>
                        
                    <td style="width: 20%;">{!! Form::text('education[school][]',$edu->school, []) !!}</td>
                        
                    <td style="width: 20%;">{!! Form::text('education[location][]',$edu->location, ['placeholder'=>'URL']) !!}</td>
                        
                    <td><button style="width:2%;" value=".edu-row" id="{!! URL::route('delete_row',['table'=>'education','id'=>$edu->id])!!}" type="button"  
                                class="delete-row btn btn-primary pull-right" ><i class="fa fa-trash-o"></i></button></td>
                </tr>

                @endforeach
                @endif<!-- the if ends here so there is always an extra tray left even there is no entry in db -->
                <tr class="edu-row" >
                    <td style="width: 25%;">{!! Form::text('education[title][]',null, ['placeholder'=>'high school/trade school']) !!}</td>
                                        
                    <td style="width: 15%;">{!! Form::text('education[start_date][]',null, ['class'=>'datepicker edu-update']) !!}</td>
                        
                    <td style="width: 15%;">{!! Form::text('education[end_date][]',null, ['class'=>'datepicker edu-update']) !!}</td>
                        
                    <td style="width: 20%;">{!! Form::text('education[school][]',null, []) !!}</td>
                        
                    <td style="width: 20%;">{!! Form::text('education[location][]',null, ['placeholder'=>'URL']) !!}</td>
                        
                    <td></td>      
                </tr>

            </tbody>
        </table>

        <button type="button" id="add-education" class="btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i>Add Another education</button>

        <!-- Work history  -->
                <h3>Work history</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td>Company </td>
                    <td>Start date </td>
                    <td>End Date </td>
                    <td>Position </td>
                    <td> Job Description </td>
                    <td>Action </td>
                </tr>
            </thead>
            <tbody id="work">
                @if(isset($works))
                @foreach($works as $work)
                <tr class="work-row">
                    {!! Form::input('hidden','work[id][]',$work->id, []) !!}
                    <td style="width: 25%;">{!! Form::text('work[company][]',$work->company,['placeholder'=>'Military Service/Company']) !!}</td>
                    <td style="width: 15%;">{!! Form::text('work[start_date][]',$work->start_date, ['class'=>'datepicker']) !!}</td>
                    <td style="width: 15%;">{!! Form::text('work[end_date][]',$work->end_date, ['class'=>'datepicker']) !!}</td>
                    <td style="width: 10%;">{!! Form::text('work[position][]',$work->position, ['placeholder'=>'last one']) !!}</td>
                    <td style="width: 30%;">{!! Form::textArea('work[job_description][]',$work->job_description, ['rows'=>'4','cols'=>'50']) !!}</td>
                    <td><button style="width:2%;" value=".work-row" id="{!! URL::route('delete_row',['table'=>'work','id'=>$work->id])!!}" type="button"  
                                class="delete-row btn btn-primary pull-right" ><i class="fa fa-trash-o"></i></button></td>
                </tr>

                @endforeach
                @endif<!-- the if ends here so there is always an extra tray left even there is no entry in db -->
                <tr class="work-row" >
                    <td style="width: 25%;">{!! Form::text('work[company][]',null, ['placeholder'=>'Military Service/Company']) !!}</td>
                    <td style="width: 15%;">{!! Form::text('work[start_date][]',null, ['class'=>'datepicker']) !!}</td>
                    <td style="width: 15%;">{!! Form::text('work[end_date][]',null, ['class'=>'datepicker']) !!}</td>
                    <td style="width: 10%;">{!! Form::text('work[position][]',null, ['placeholder'=>'last one']) !!}</td>
                    <td style="width: 30%;">{!! Form::textArea('work[job_description][]',null, ['rows'=>'4','cols'=>'50']) !!}</td>
                    <td></td>      
                </tr>

            </tbody>
        </table>
    <button type="button" id="add-work" class="btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i>Add Another work history</button>
        <!-- Work history ends -->
        
         <!-- Projects  -->
          <h3>Projects</h3>
          <table class="table table-bordered table-hover">
            <thead>
                <tr class="">
                    <td>Title </td>
                    <td>Url</td>
                    <td>Description </td>
                    <td>Action </td>
                </tr>
            </thead>
            <tbody id="project">
                @if(isset($projects))
                @foreach($projects as $project)
                <tr class="project-row">
                    {!! Form::input('hidden','project[id][]',$project->id, []) !!}
                    <td style="width: 25%;">{!! Form::text('project[title][]',$project->title, ['placeholder'=>'A unique name for each project']) !!}</td>
                    <td style="width: 30%;">{!! Form::text('project[url][]',$project->url, []) !!}</td>
                    <td style="width: 40%;">{!! Form::textArea('project[description][]',$project->description, ['rows'=>'4','cols'=>'50']) !!}</td>                
                    <td><button style="width:2%;" value=".project-row" id="{!! URL::route('delete_row',['table'=>'project','id'=>$project->id])!!}" type="button"  
                                class="delete-row btn btn-primary pull-right" ><i class="fa fa-trash-o"></i></button></td>
                
                </tr>

                @endforeach
                @endif<!-- the if ends here so there is always an extra tray left even there is no entry in db -->
                <tr class="project-row" >
                    <td style="width: 25%;">{!! Form::text('project[title][]',null, ['placeholder'=>'A unique name for each project']) !!}</td>
                    <td style="width: 30%;">{!! Form::text('project[url][]',null, []) !!}</td>
                    <td style="width: 40%;">{!! Form::textArea('project[description][]',null, ['rows'=>'4','cols'=>'50']) !!}</td>
                    <td ></td>      
                </tr>
                
            </tbody>
        </table>
  <button type="button" id="add-project" class="btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i>Add Another project</button>
          <!-- Projects  ends. -->
        <div class="pull-right" >
             <i class="fa fa-save"></i>{!! Form::submit('Update info',['class' => 'btn btn-primary', 'title' => 'Update info']) !!}      
        </div>
        {!! Form::close() !!}
          
    </div>

    <!-- Updating credentials  -->
    <div class="panel-heading" data-toggle="collapse" data-target="#edit-credential">
        <button class="btn btn-primary"> Update your credential below <i class="fa fa-chevron-down"></i></button>   
    </div>
    <div id="edit-credential" class="panel-body collapse">
        {!! Form::open(['route'=>'update_credential']) !!}
        <div class="form-group ">
            {!! Form::label('nickname', 'Username:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::text('nickname',$user->name, ['class' => 'mod-cre form-control']) !!}
            {!! $errors->first('nickname', '<span style="color:red;" >:message</span>') !!}
        </div>

        <div class="form-group ">
            {!! Form::label('email', 'Email',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::input('email','email',$user->email, ['class' => 'mod-cre form-control']) !!}
            {!! $errors->first('email', '<span style="color:red;" >:message</span>') !!}
        </div>
        <div class="form-group ">
            {!! Form::label('password', 'Password:',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::input('password','password', null,['class' => 'mod-cre form-control']) !!}
            {!! $errors->first('password', '<span style="color:red;" >:message</span>') !!}
        </div>
         {!! Form::input('hidden','_token',csrf_token(),[]) !!}
         {!! Form::input('hidden','oldemail',$user->email,[]) !!}
         {!! Form::input('hidden','user',$user->name,[]) !!}
        {!! Form::submit('Update',['class' => 'btn btn-primary','style'=>'width:10%;']) !!}
        {!! Form::close() !!}
    </div>

    <!-- Post a new photo -->
    <div class="panel-heading" data-toggle="collapse" data-target="#edit-photo">
        <button class="btn btn-primary"> Click to update your photos <i class="fa fa-chevron-down"></i></button>   
    </div>
    <div id="edit-photo" class="panel-body collapse">
        <!-- Display all pictures and means to delete each picture -->
        
        <div class="row"> 

            @foreach($pics as $pic)
            <div  class="col-sm-4 img-thumbnail del-photo">
               
                <img src="{{ URL::asset($pic->url) }}" class="col-lg-3"/>
                <div class="form-group">
                   
                    {!! Form::text('for_section',$pic->for_section, 
           ['class' => 'photo-section form-control', 'placeholder'=>'Photo TAG ex: profile','id'=>URL::route('modify_pic',['id'=>$pic->id,'action'=>'update']) ]) !!}
                 <button type="button" id="{!! URL::route('modify_pic',['id'=>$pic->id,'action'=>'delete'])!!}"  class="btn-primary photo" style="margin-top: 10px;"><i class="fa fa-trash-o"></i></button>    
                </div>

            </div>
            @endforeach
        </div>
          <!--  picture upload form -->
             <div class="pull-right form-group" >
             <p class="errors">{!!$errors->first('image')!!}</p>
            @if(Session::has('error')) 
           
            <p class="errors">{!! Session::get('error') !!}</p>
            @endif
            @if(Session::has('success'))
            <div class="alert-box success"> 
                <h2>{!! Session::get('success') !!}</h2> 
            </div>
            @endif
             <button id="btn-pic" class="btn btn-primary">click to upload a new picture</button>
            </div>
        <!-- Picture upload area end. -->
    </div>

 
    @else
    <div style="margin-left: 30%">
        Congradulations you have completed your profile, now you can login into your dashboard.
    </div>

    @endif  
</section>
@stop

@section('script')

$(function(){
setTimeout(function(){
$('.flash-message').remove();
},2500);
});




//Add education row in education table
$('#add-education').on('click',function(){
$("#educations").append($("#educations").children().first().clone());
});
//Add work history row in work table
$('#add-work').on('click',function(){
$("#work").append($("#work").children().first().clone());
});
//Add project row in the project table
$('#add-project').on('click',function(){
$("#project").append($("#project").children().first().clone());
});


//Update photo
$('.photo-section').on('blur',function(){
var url = $(this).attr('id')+'&for_section='+$(this).val();
$.ajax({
url: url,
type: 'get',
success: function(json) {
alert(json['result']);
}});
});

// delete photos
$('.photo').on('click',function(){
var photo_url = $(this).attr('id');
$.ajax({
url: photo_url,
type: 'get',
success: function(json) {
alert(json['result']);
}});
$(this).parents(".del-photo").animate("fast").animate({
opacity : "hide"
}, "slow");
});

//Delete row from education table
$('.delete-row').on('click',function(){
var url = $(this).attr('id');
var child = $(this).val();
if(confirm('are you sure?')){
$.ajax({
url: url,
type: 'get',
success: function(json) {
alert(json['result']);
}});
$(this).parents(child).animate("fast").animate({
opacity : "hide"
}, "slow");

}//end of confirm
return false;
});
@stop


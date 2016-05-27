

@extends('layouts.app')

@section('title')
Create an entry 
@stop

@section('content')
<section id="about" class="about">
    <div class="about-top">
        <div class="section-padding">
        
           

<div class="panel-heading" data-toggle="collapse" data-target="#member-info">
    <button  class="btn btn-primary"> Enter all your info below <i class="fa fa-chevron-down"></i></button>
    
</div>
        <div id="member-info" class="panel-body collapse">
{!! Form::open(['route'=>'save_info']) !!}
<div class="form-group required">
  
    {!! Form::label('firstname', 'Firstname:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::text('firstname',null, ['class' => 'form-control', 'placeholder'=>'Firstname']) !!}
    {!! $errors->first('firstname', '<span style="color:red;" >:message</span>') !!}
</div>

<div class="form-group required">
    {!! Form::label('lastname', 'Lastname:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::text('lastname',null,['class' => 'form-control']) !!}
    {!! $errors->first('lastname', '<span style="color:red;" >:message</span>') !!}
</div>

<div class="form-group required">
    {!! Form::label('nickname', 'Username:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::text('nickname',null, ['class' => 'form-control']) !!}
    {!! $errors->first('nickname', '<span style="color:red;" >:message</span>') !!}
</div>

<div class="form-group required">
    {!! Form::label('phone', 'Primary Phone:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::input('phone','phone', null, ['class' => 'form-control']) !!}
    {!! $errors->first('phone', '<span style="color:red;" >:message</span>') !!}
</div>

<div class="form-group required">
    {!! Form::label('email', 'Email:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::input('email','email', null, ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<span style="color:red;" >:message</span>') !!}
</div>


<div class="form-group required">
    {!! Form::label('address', 'Address:',['class' => 'col-sm-2 control-label', 'placeholder'=>'address','style' => 'width:10%;']) !!}
 <span> Street: </span>{!! Form::text('address_1', null, ['style' => 'width:20%;']) !!}
 <span> Apt#: </span>{!! Form::text('address_2', null, ['style' => 'width:6%;']) !!}
 {!! $errors->first('street', '<span style="color:red;" >:message</span>') !!}
  <span  style="padding-left: 10px;"> City: </span> {!! Form::text('city',null, ['style' => 'width:10%;']) !!}
  {!! $errors->first('city', '<span style="color:red;" >:message</span>') !!}
 <span style="padding-left: 10px;"> State: </span> 
 {!! Form::select('state', $state, ['style' => 'width:10%;']) !!}
 {!! $errors->first('state', '<span style="color:red;" >:message</span>') !!}
    <span  style="padding-left: 10px;"> Zip: </span> {!! Form::text('zip', null, ['style' => 'width:10%;']) !!}
    {!! $errors->first('zip', '<span style="color:red;" >:message</span>') !!}

    
</div>

<div class="form-group required">
    {!! Form::label('social_media (seperate by a comma)', null,['class' => 'col-sm-2 control-label', 'placeholder'=>'Twitter/facebook']) !!}
    {!! Form::text('social_media', null, ['class' => 'form-control']) !!}
    {!! $errors->first('social_media', '<span style="color:red;" >:message</span>') !!}
</div>

<div class="form-group required">
    {!! Form::label('birthday', 'Date of birth:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::text('birthday',null, ['class' => 'form-control datepicker']) !!}
    {!! $errors->first('birthday', '<span style="color:red;" >:message</span>') !!}
</div>

<div class="form-group required">
    {!! Form::label('password', 'Password:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::input('password','password', null,['class' => 'form-control']) !!}
    {!! $errors->first('password', '<span style="color:red;" >:message</span>') !!}
</div>



<div class="form-group required">
  
    {!! Form::label('motto', 'Motto:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::text('motto',null, ['class' => 'form-control', 'placeholder'=>'Do what you know, Do what what you must!']) !!}

</div>

<div class="form-group required">
    {!! Form::label('quick_description', 'The lead sentences:',['class' => 'col-sm-2 control-label','placeholder'=>'sentence that grab employers']) !!}
    {!! Form::text('short_intro', null, ['class' => 'form-control']) !!}
    
</div>

<div class="form-group required">
    {!! Form::label('self_description', 'Self-Description:',['class' => 'col-sm-2 control-label']) !!}
    {!! Form::textArea('self_description', null, ['class' => 'form-control']) !!}
    
</div>


<h3>Educations</h3>
<div id="educations" class="form-group" >
    <div class="row" style="margin-top: 10px;">
 <span> Title: </span>{!! Form::text('education[title][]', null, ['style' => 'width:25%;','placeholder'=>'high school/trade school']) !!}
 <span style="padding-left: 10px;"> start date: </span> {!! Form::text('education[start_date][]', null, ['class'=>'datepicker','style' => 'width:10%;']) !!}
 <span style="padding-left: 10px;"> End date: </span> {!! Form::text('education[end_date][]', null, ['class'=>'datepicker','style' => 'width:10%;']) !!}
    <span  style="padding-left: 10px;"> School: </span> {!! Form::text('education[school][]', null, ['style' => 'width:10%;']) !!}
    <span  style="padding-left: 10px;"> location: </span> {!! Form::text('education[location][]', null, ['style' => 'width:10%;','placeholder'=>'P-au-P Haiti']) !!}
 </div>
  
</div>
<button  type="button" id="add-education" class="btn-primary" style="margin-top: 10px;"><i class="fa fa-plus"></i>Add Another education</button>


<div class="pull-right">
    {!! Form::submit('Save info',['class' => 'btn btn-primary', 'title' => 'save info']) !!}
 <i class="fa fa-save"></i>

</div>
{!! Form::close() !!}
</div>
        
            </div>
        </div>
    </section>
@stop

@section('script')

$('#add-education').on('click',function(){
$("#educations").append($("#educations").children().first().clone());
});





@stop
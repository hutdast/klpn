@extends('layouts.app')
@section('title')
@if($member)
welcome to {{ $family->firstname }} 's page
@else
Welcome to our page
@endif
@stop

<!-- This is the profile area -->

@section('content')
@if($member)


    <div class="row row-offcanvas row-offcanvas-left separator">

        <!-- sidebar -->
        <div class="sidestyle col-xs-6 col-sm-3 ">

            <!-- Inside sidebar -->
            <div class="container-fluid text-center"> 
                <h3>{{ ucfirst($family->firstname).'  '.ucfirst($family->lastname) }}</h3>
                <div class="row">
                    <div class="col-md-12"> 
                        @if($pic)
                        <img src="{{ URL::asset($pic->url) }}" class="img-responsive img-thumbnail" >
                        @endif
                    </div>
                    <div class="col-md-12 "> 
                        @if($social_media)
                        @foreach($social_media as $social_medium)

                        <a target="_blank" href="{{ $social_medium['url'] }}"><i class="fa fa-{{ $social_medium['icon'] }}"></i></a>
                        @endforeach
                        @endif
                    </div>

                    <div class="motto" >
                        @if($bio)
                        <small> {{ $bio->motto }}</small>
                        @else
                        <h1>Motto</h1>
                        @endif
                    </div>

                </div>
            </div><!-- end Info inside sidebar -->

        </div>

        <!-- main area -->
        <div class="col-xs-12 col-sm-9 main-content">

            
            <div class="container-fluid bg-3 text-center"> 

                <div class="row" >
                    <!-- Jumbotron -->
                    <div class="jumbotron col-xs-12">

                        @if($bio)
                        @foreach(explode(',',$bio->short_intro) as $mybio)
                        <h3 align="left"> {{ $mybio }}</h3>
                        @endforeach
                       
                        @else
                        <h3>Lead sentences</h3>
                        @endif
                    </div>
                    <!-- Jumbotron end. -->
                  
                    <article class="author-bio-container col-xs-12">
                    @if($bio)
                    @foreach(explode("\n",$bio->self_description) as $aboutme )
                    <p class="col-md-12" align="left">{!! $aboutme !!}</p>
                    @endforeach
                    @else
                    <p class="col-md-12" align="left">About ME</p>
                    @endif
                  </article>
                    
                    <hr>
                    
                    <!-- Work history -->
                    @if($works)
                    <h3  class="big-seperator section-title">Work History</h3>
                    <table class="table table-hover col-xs-12">
                        <thead>
                            <tr class="section-description">
                                <td>Company </td>
                                <td>Start date </td>
                                <td>End Date </td>
                                <td>Position </td>
                                <td> Job Description </td>

                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($works as $work)
                            <tr  class="section-description">
                                <td>{{ $work->company }} </td>
                                <td >{{ $work->start_date->toFormattedDateString() }} </td>
                                <td>{{ ($work->end_date->year == -1)?'Present': $work->end_date->toFormattedDateString() }} </td>
                                <td>{{ $work->position }} </td>
                                <td>{{ $work->job_description }} </td>
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                     @endif
                    <!-- Work history end. -->

                    <!-- Education  -->
                    @if($edus)
                    <h3  class="big-seperator section-title">Education</h3>
                    <table class="table table-hover col-xs-12">
                        <thead>
                            <tr class="section-description">
                                <td>Title </td>
                                <td>Start date </td>
                                <td>End Date </td>
                                <td>School </td>
                               

                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($edus as $edu)
                            <tr class="section-description">
                                <td>{{ $edu->title }} </td>
                                <td>{{ $edu->start_date->toFormattedDateString() }} </td>
                                <td>{{ ($edu->end_date->year == -1)?'Present': $edu->end_date->toFormattedDateString() }} </td>
                                <td><a target="_blank" href="{{ $edu->location }}">{{ $edu->school }}</a> </td>
                               
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                     @endif
                     
                    <!-- Education end -->
                    
                    
                    <!-- projects -->
                    @if($projects)
                    <h3  class="big-separator section-title">Projects</h3>
                    <table class="table table-hover col-xs-12">
                        <thead>
                            <tr class="section-description">

                                <td>Project link</td>
                                <td>Description </td>

                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($projects as $project)
                            <tr class="section-description">
                                <td><a target='_blank' href="{{ $project->url }}">{{ $project->title }} </a> </td>
                                <td>{{ $project->description }} </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    @endif
                    <!-- Projects end -->

                </div>
            </div><!-- end Info inside sidebadr -->

            <!-- Error or success mail -->
            <div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
  </div>
            
             @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- Error or success mail end. -->
            <div class="col-md-12 text-center  wow animated fadeInRight" data-wow-delay=".75s"">
                <a id="contact-mail" class="section-title big-separator"> Contact me <i class="fa fa-hand-o-right" aria-hidden="true"></i> {{$user->email}}</a><!-- /.section-title -->
            </div><!-- /.form-area -->

            
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
    

@else
<!-- All members' CV links displayed along with their pictures -->
<div class="row">
    @foreach($pics as $pic)
    <div  class="img-thumbnail col-md-4">

        <a href="{{ URL::route('member_cv',[$pic->username]) }}"><img id="{{ $pic->username }}" src="{{ URL::asset($pic->url) }}" class="img-circle"/></a>
        <label for="{{ $pic->username }}">{{ $pic->username }}</label>
    </div>
    @endforeach
    @endif
</div>

@stop

@section('script')

$('#contact-mail').on('click',function(){
var data = '<div> {!! Form::open(['route'=>['send_mail',$family->nickname], 'id' => 'contactform', 'class'=>'contactform']) !!}';
data +='{!! Form::text('name',null, ['class' => 'pull-left', 'placeholder'=>'Name','id'=>'name', 'requred']) !!}';
data +='{!! Form::text('email',null, ['class' => 'pull-left', 'placeholder'=>'email','id'=>'email', 'requred']) !!} ';
data +=' {!! Form::textArea('message',null, ['class' => 'pull-left','id'=>'message', 'requred']) !!}';
data +=' {!! Form::submit('Send Message',['class' => 'btn submit-btn','id'=>'submit']) !!}';
data +=' {!! Form::close() !!} </div>';

    html = '<div id="modal-mail" class="modal">';
    html += '  <div class="modal-dialog">';
    html += '    <div class="modal-content">';
    html += '      <div class="modal-header">';
    html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    html += '      </div>';
    html += '      <div class="modal-body">' + data + '</div>';
    html += '    </div';
    html += '  </div>';
    html += '</div>';
            $('body').append(html);
        $('#modal-mail').modal('show');
    
});


    

  
@stop

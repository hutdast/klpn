<!DOCTYPE html>
<html lang="en">
<head>
     
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="kenel laraque,nerlande viaud,paul midi, nikenson midi, oge viaud, leonard viaud">
        <meta name="description" content="klpnfamily">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <script  src="{{ URL::asset('jquery/jquery-2.1.1.min.js') }}" ></script>
        <script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="{{ URL::asset('jquery/jquery.countdown.min.js') }}" ></script>
        <script  src="{{ URL::asset('bootstrap/css/modernizr-2.8.3-respond-1.4.2.min.js') }}" ></script>
        <script  src="{{ URL::asset('bootstrap/js/bootstrap.js') }}" ></script>
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap-theme.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/jquery.bxslider.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/css/responsive.min.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

        <title class="page-title">

            @yield('title')
        </title>
 
</head>
<body >

    
 <!--    <nav class="navbar navbar-default navbar-static-top"> -->
 <header class="masthead navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header ">       
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                   Home 
                </a> 
                     @if (Auth::guest())
                     <!--  <a class="navbar-brand" href="{{ url('/login') }}">Login</a> -->
                     <a class="navbar-brand" id="login">Login</a>
<li><a  href="{{ url('/register') }}">Register</a></li>

                    @elseif(isset($family))
                              
  <a class="navbar-brand" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
   Welcome {{ isset($family->nickname) ? $family->nickname : 'admin'}}  
    @endif
 
            
                 
            </div>

           
        </div>
</header>     
    <!-- </nav> -->
    
    
    <div id="display-container" class="container">
         @yield('content')        
    </div>

   
    <!-- Scroll to the top of the page -->
    <div id="scroll-to-top" class="scroll-to-top" style="display: block;">
    <span>
      <i class="fa fa-chevron-up"></i>    
    </span>
  </div>
     <!-- Scroll to the top of the page end. -->
      <footer >
        <div class="footer-bottom section-padding row">
          <ul class="nav nav-stacked">             
            </ul>
        </div>
    </footer> 
     
</body>
<script>
    @yield('script')
    $('#scroll-to-top').on('click',function(){
        $('html, body').animate({scrollTop : 0},800);
    });
    
    $('#btn-pic').on('click',function(){
   
   var data ='<div >Upload your file</div> {!! Form::open(['route'=>'upload','method'=>'POST', 'files'=>true]) !!}';
     data +='<div class="control-group"> <div class="controls"> {!! Form::file('image') !!} ';
      data +=' </div> </div><div id="success"> </div>';
       data +='{!! Form::submit('Upload', ['class'=>'btn btn-primary']) !!} {!! Form::close() !!} </div></div></div>';

    //Variable for the html element and append the data
 var  html = '<div id="modal-pic"  class="modal"  style="margin-top: 50px;">';
    html += '  <div class="modal-dialog">';
    html += '    <div class="modal-content">';
    html += '      <div class="modal-header">';
    html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    html += '        <h4 class="modal-title"> <span style="font-family:Lato;" class="pull-right"> Upload your best</span> </h4>';
    html += '      </div>';
    html += '      <div class="modal-body">' + data + '</div>';
    html += '    </div';
    html += '  </div>';
    html += '</div>';
     $('body').append(html);  
        $('#modal-pic').modal('show');
});



$(function() {
    $( ".datepicker" ).datepicker({
    container:$(this),

    dateFormat:'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      clearBtn: true,
      autoclose: true
    });
    //Countdown script
  $("#getting-started").countdown("2016/07/24", function(event) {
                                   $(this).text( event.strftime('%D days %H:%M:%S')); });

//Login dialog
$('#login').on('click',function(){
    var data ='<div class="row"><div class="col-md-8 col-md-offset-2"><div class="panel panel-default"><div class="panel-heading">Login</div>';
     data +='<div class="panel-body"><form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">{{ csrf_field() }}';
      data +='<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"><label class="col-md-4 control-label">E-Mail Address</label>';
   data +='<div class="col-md-6"><input type="email" class="form-control" name="email" value="{{ old('email') }}">@if ($errors->has('email'))';
   data +='<span class="help-block"> <strong>{{ $errors->first('email') }}</strong></span>@endif</div></div><div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">';
   data +='<label class="col-md-4 control-label">Password</label><div class="col-md-6"><input type="password" class="form-control" name="password">';
   data +='@if ($errors->has('password')) <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span> @endif</div></div>';
   data +='<div class="form-group"><div class="col-md-6 col-md-offset-4"><div class="checkbox"><label><input type="checkbox" name="remember"> Remember Me';
   data +='</label></div></div></div><div class="form-group"><div class="col-md-6 col-md-offset-4"><button type="submit" class="btn btn-primary">';
   data +='<i class="fa fa-btn fa-sign-in"></i>Login</button><a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>';
   data +=' </div></div></form></div></div></div></div>';
   

    //Variable for the html element and append the data
 var  html = '<div id="modal-login"  class="modal"  style="margin-top: 50px;">';
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
        $('#modal-login').modal('show');
    
    
});

    //pull-down class
       $('.pull-down').each(function() {       
 $(this).css('margin-top', $(this).parents('#display-container').height() - $(this).height()-100);
});

  });//end of main function  
</script>
<script type="text/javascript">
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});


</script>
</html>

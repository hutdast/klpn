<!DOCTYPE html>
<html lang="en">
<head>
     
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="kenel nerlande viaud midi klpn">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <script  src="{{ URL::asset('jquery/jquery-2.1.1.min.js') }}" ></script>
       <script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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

  

    <style type="text/css">
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
       
.ui-datepicker {
   background: #333;
   border: 1px solid #555;
   color: #EEE;
 }

    </style>
    
    
    
    
</head>
<body id="app-layout">
    <!-- Facebook comment API -->
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Facebook API ends -->
    
 <!--    <nav class="navbar navbar-default navbar-static-top"> -->
 <header class="masthead navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header ">       
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                   Home 
                </a> 
                     @if (Auth::guest())
                  <a class="navbar-brand" href="{{ url('/login') }}">Login</a>

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

    <footer class="footer">
        <div class="footer-bottom section-padding row">
          <ul class="nav nav-stacked">             
            </ul>
        </div>
    </footer> 
    <!-- Scroll to the top of the page -->
    <div id="scroll-to-top" class="scroll-to-top" style="display: block;">
    <span>
      <i class="fa fa-chevron-up"></i>    
    </span>
  </div>
     <!-- Scroll to the top of the page end. -->
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
    //Footer to remain at the bottom of the screen
//    $('.footer').each(function(){
//     // $(this).css('margin-top', $(document).height());
//    });
    

    
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

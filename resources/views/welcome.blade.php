@extends('layouts.app')
@section('title')
Welcome
@stop

@section('content')


     <section id="about" class="about">
    <div class="about-top">
      <div class="section-padding">
        <div class="container">
          <div class="row">
            <div class="col-md-7">
              <div class="know-about-us wow animated fadeInLeft" data-wow-delay=".5s">
                  <h2 class="section-title">Meet the <span>Gang</span>!</h2><h5 style=" font-family: 'Lato';">{!! Session::get('message') !!}
</h5><!-- /.section-title -->
               
              
              </div><!-- /.know-about-us -->
            </div>

           
          </div><!-- /.row -->
        </div><!-- /.container -->
      </div><!-- /.section-padding -->
    </div><!-- /.about-top -->

    <div class="about-middle row">
     @foreach($family as $family_member)
        <div class="col-md-3 col-sm-6" >
          <div class="item media wow animated fadeInLeft" data-wow-delay=".35s" >
             
              <div class="section-padding" >
                  <div class="item-details media-body text-center" >
                <div class="item-icon" >
              <a href="{{ URL::route('member_cv',[$family_member->nickname]) }}">
                  @if($family_member->url)
                  <img src="{{$family_member->url}}" class="img-circle"  />
                 @else
                 <span> No Photo Available</span>
                 @endif        
              </a>       
                </div><!-- /.item-icon --> 
                 <span>{{ $family_member->nickname}}</span>
              </div><!-- /.item-details -->           
            </div><!-- /.section-padding -->
          </div><!-- /.item -->
        </div>
      @endforeach
    </div>


    <div class="about-bottom">
      <div class="section-padding">
       
        <div class="col-sm-6">
          <div class="about-work wow animated fadeInRight" data-wow-delay=".5s">
              <h2 class="section-title"><span style="font-family: lato;">Family Newsweek</span> </h2><!-- /.section-title -->
<p>Sophia is here!</p>
<!----<img src="" class="img-thumbnail" />---->
   <div class="fb-comments" data-href="https://www.facebook.com/twinsANgryPaNda" data-numposts="5"></div>
              
          </div><!-- /.about-work -->
        </div>
      </div><!-- /.section-padding -->
    </div><!-- /.about-bottom -->
    
    
  </section><!-- /#about -->

  before script
@stop
<script>
alert("about to call ajax");
 $.ajax({
        url: 'http://klpnfamily.com/api/test',
        dataType: 'text',
        type: 'post',
        contentType: 'application/x-www-form-urlencoded',
        
        success: function(response, textStatus, jQxhr ){
            alert(response );
        },
        error: function( jqXhr, textStatus, errorThrown ){
            alert( errorThrown );
        }
    });
</script>
@section('script')

@stop
<script>
    





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

$('#add-education').on('click',function(){
$("#educations").append($("#educations").children().first().clone());
});

$(function(){
    alert("about to call ajax");
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
var url = $(this).attr('data-url')+'&for_section='+$(this).val();
$.ajax({
url: url,
type: 'get',
success: function(json) {
alert(json['result']);
}});
});

// delete photos
$('.photo').on('click',function(){
var photo_url = $(this).attr('data-url');
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
                               
    </script>
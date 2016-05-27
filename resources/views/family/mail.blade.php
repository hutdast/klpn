

<h4>From {{ $user }}</h4>
<h5>Message</h5>
@foreach($msg as $message)
<p> {{ $message }}</p>
@endforeach
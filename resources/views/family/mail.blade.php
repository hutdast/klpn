

<h4>From {{ $guest->name.', email: '. $guest->email}}</h4>
<h5>Message</h5>
@foreach($msg as $message)
<p> {{ $message }}</p>
@endforeach
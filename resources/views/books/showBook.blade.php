@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
		<div class="row col-xs-8 col-xs-offset-2 img-rounded text-center" style="background-color: #eee;">
			<div ><h2>{{ $book->title }}</h2></div>
			<div >{{ $book->description }}</div>
			<div class="blockquote-reverse">Published by -{{ $book->author }}</div>
			<button class="btn btn-default"><a href="{{ url('/book') }}">Back to Home</a></button>
			<br><br>
		</div>
	</div>
</div>
@endsection
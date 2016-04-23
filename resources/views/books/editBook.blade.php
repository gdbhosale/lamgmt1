@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			<h1>Edit {{ $book->title }}</h1>
			{!! Form::model($book, ['route' => ['book.update', $book->id ], 'method'=>'PUT']) !!}
            <div class="form-group">
                {!! Form::label('title', 'Title :') !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Description :') !!}
                {!! Form::textarea('description', null,  ['class'=>'form-control', 'placeholder'=>'Description']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('author', 'Author name :') !!}
                {!! Form::text('author', null,  ['class'=>'form-control', 'placeholder'=>'Author Name']) !!}
            </div>
            <br>
            <div class="form-group">
                {!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url('/book') }}">Back to Home</a></button>            </div>

            {!! Form::close() !!}
            @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
		</div>
	</div>
</div>
@endsection
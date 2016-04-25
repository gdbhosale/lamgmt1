@extends('layouts.app')
@section('content')
<div class="container">
	<a class="btn btn-primary btn-sm pull-right" href="{{ route('book.create')  }}">Add New Book</a>
	<!--<a class="btn btn-primary btn-sm pull-right" href="{{ URL::to('book/create') }}">Add New Book</a>-->
	<br><br>
	<div class="list-group">
	@foreach($allBooks as $book)
		<div class="list-group-item">
			{!! Html::linkRoute('book.show', $book->title, array($book->id)) !!} ({{$book->author }})
			<span class="pull-right">
				{!! Html::linkRoute('book.edit', 'Edit', array($book->id), ['class'=>'btn btn-success btn-xs', 'style'=>'display:inline']) !!}
				{!! Form::open(['route' => ['book.destroy', $book->id], 'method' => 'delete', 'style'=>'display:inline']) !!}
				<input class="btn btn-danger btn-xs" type="submit" value="Delete" />
				{!! Form::close() !!}
			</span>
		</div>
	@endforeach
	</div>
</div>
@endsection
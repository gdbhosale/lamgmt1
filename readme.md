# Laravel + jQuery + Bootstrap + Font Awesome

This library is latest compilation of best UI libraries with Laravel Backend.

Components:

Laravel (5.2.29) from http://laravel.com

jQuery (2.1.4) from http://jquery.com/download

Bootstrap (3.3.6) from http://getbootstrap.com

Font Awesome (4.5.0) from http://fortawesome.github.io/Font-Awesome/icons

This library is also customed with Template Pattern easy to start any new project.

Commands used:

```
# create Laravel Project
composer create-project --prefer-dist laravel/laravel falabs

# Create Authentication
php artisan make:auth

# Generate the databases for auth
php artisan migrate

# Check laravel version
php artisan --version

// create route entry app/Http/routes.php
Route::resource('book', 'BookController');

// Create Book Controller
php artisan make:controller BookController

// List Book CRUD methods
php artisan route:list

// Create methods in BookCOntroller
public function __construct() {
    // for authentication (optional)
    $this->middleware('auth');
}
public function index() {}
public function create() {}
public function store() {}
public function show($id) {}
public function edit($id) {}
public function update($id) {}
public function destroy($id) {}

// Create Book Model
php artisan make:model Book

// Define Book Model
    protected $table = 'books';
	protected $fillable = [
        'title',
        'description',
        'author'
    ];

// Create Migration for Book Table
php artisan make:migration create_books_table

// This will create migration file 2016_04_22_161225_create_books_table
// Edit Migration file
    public function up() {
        Schema::create('books', function(Blueprint $table) {
			$table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('author');
			$table->timestamps();
		});
    }

    public function down() {
        Schema::drop('books');
    }

// Generate DB Table
php artisan migrate

// Create Request
php artisan make:request PublishBookRequest

    public function authorize() {
		return true;
	}
    
    public function rules() {
		return [
			'title' => 'required',
			'description' => 'required',
			'author' => 'required'
		];
	}

// Create Listing file resources/views/books/bookList.blade.php
@extends('layouts.app')
@section('content')
<div class="container">
	<a class="btn btn-primary btn-sm pull-right" href="{{ route('book.create')  }}">Add New Book</a>
	<br><br>
	<div class="list-group">
	@foreach( $allBooks as $book )
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

// Define model in BookController
use App\Book;

// BookController Linking to View
    public function index() {
		$allBooks = Book::all();
        return View('books.bookList', compact('allBooks'));
	}

// Create add view in resources/views/books/addBook.blade.php
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			<h1>Add New Book</h1>
			{!! Form::open(['action' => 'BookController@store']) !!}

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
					{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url('/book') }}">Back to Home</a></button>
				</div>
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

// Create Add View Liking
    public function create() {
        return view('books.addBook');
    }

// Requires Form Collective - Method 1 =======================================
// Update composer.json
"require": {
    "laravelcollective/html": "~5.0"
}

// Put command
composer update

// open config/app.php
'providers' => [
    Collective\Html\HtmlServiceProvider::class,
],
'aliases' => [
    'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class
],
// Requires Form Collective End =======================================

// Requires Form Illuminate - Method 2 =======================================
// Put command
composer require illuminate/html

// open config/app.php
'providers' => [
    Illuminate\Html\HtmlServiceProvider::class,
],
'aliases' => [
    'Form' => Illuminate\Html\FormFacade::class,
    'Html' => Illuminate\Html\HtmlFacade::class
],
// Requires Form Illuminate End =======================================

// Create Save Add Data
    public function store(PublishBookRequest $requestData) {
		//Insert Query
        $book = new Book;
        $book->title= $requestData['title'];
        $book->description= $requestData['description'];
        $book->author= $requestData['author'];
        $book->save();

        //Send control to index() method where it'll redirect to bookList.blade.php
        return redirect()->route('book.index');
	}

// Create Show View resources/views/books/showBook.blade.php
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
		<div class="row col-xs-8 col-xs-offset-2 img-rounded text-center" style="background-color: #eee;">
			<div ><h2>{{ $book->title }}</h2></div>
			<div >{{ $book->description }}</div>
			<div class="blockquote-reverse">Published by -{{ $book->author }}</div>
			<button class="btn btn-default"><a href="{{ url('/book') }}">Back to Home</a></button><br><br>
		</div>
	</div>
</div>
@endsection

// Create Show View Linking
    public function show($id) {
		$book = Book::find($id);
        return view('books.showBook')->with('book',$book);
	}

// Create Edit View resources/views/books/editBook.blade.php
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

// Create edit view linking
    public function edit($id) {
		$book = Book::find($id);
        return view('books.editBook')->with('book',$book);
	}

// Create update
    public function update($id, PublishBookRequest $requestData) {
		$book = Book::find($id);
        
        //Update Query
        $book->title = $requestData['title'];
        $book->description = $requestData['description'];
        $book->author = $requestData['author'];
        $book->save();
        
        //Redirecting to index() method of BookController class
        return redirect()->route('book.index');
	}

// Create Delete (Link already made in bookList.blade.php)
    public function destroy($id) {
		Book::find($id)->delete();
        
        //Redirecting to index() method
        return redirect()->route('book.index');
	}








----------------------------------------------------------------------
// create model migration
php artisan make:migration create_student_table --table=students --create

// ???
php artisan make:model Students

    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 255);
			$table->string('phone', 255);
			$table->string('class', 255);
            $table->integer('age');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('students');
    }

// creating db classes automatically
php artisan migrate

// Make controller
php artisan make:controller StudentsController

// Route listing with processing route file
php artisan route:list

```

Note:
- Database file saved in database folder 

References:
- http://devartisans.com/articles/CRUD-book-library-laravel5
- https://scotch.io/tutorials/simple-laravel-crud-with-resource-controllers
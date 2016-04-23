<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use App\Http\Requests\PublishBookRequest;

class BookController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$allBooks = Book::all();
        return View('books.bookList', compact('allBooks'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return view('books.addBook');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$book = Book::find($id);
        return view('books.showBook')->with('book',$book);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		$book = Book::find($id);
        return view('books.editBook')->with('book',$book);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		Book::find($id)->delete();
        
        //Redirecting to index() method
        return redirect()->route('book.index');
	}
}

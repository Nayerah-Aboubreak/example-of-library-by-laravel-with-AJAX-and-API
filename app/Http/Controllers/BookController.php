<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(3);
        //dd($books);
        return view('books.index', [
            'books'=> $books
        ]);
    }

    public function create()
    {
        $authors = Author::select('id','name')->get();

        return view('books.create',[
            'authors'=>$authors
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'desc'=>'required|string',
            'img' =>'required|image|mimes:jpg,jpeg,png|max:2048',
            'price'=>'required|numeric',
            'author_id'=>'required|exists:authors,id',
        ]);

        //move image to uploads files

        $img=$request->img;
        $ext=$img->getClientOriginalExtension();
        $img_name="book-".uniqid().".$ext";
        $img->move(public_path('uploads'),$img_name);


       // dd($request->all());
       $name=$request->name;
       $desc=$request->desc;

       Book::create([
           'name'=>$name,
           'desc'=>$desc,
           'img'=>$img_name,
           'price'=>$request->price,
           'author_id'=>$request->author_id,

       ]);

       return redirect(route('books.index'));
    }

    public function show($id)
    {
        $book = Book::find($id);// find used with primary key only

        
        return view('books.show', [
            'book'=> $book
        ]);
    }


    
    public function edit($id)
    {
        $book = Book::find($id); // find used with primary key only
        $authors = Author::select('id','name')->get();


        return view('books.edit', [
            'book' => $book,
            'authors'=>$authors,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'desc'=>'required|string',
            'img' =>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price'=>'required|numeric',
            'author_id'=>'required|exists:authors,id',

        ]);


        $book = Book::find($id);
        $img_name = $book->img;

        if($request->hasFile('img')) {
            if($book->img !== null){
                //delete the old
                unlink(public_path("uploads/$img_name"));
            }

            // move the new
            $img = $request->img;
            $ext = $img->getClientOriginalExtension();
            $img_name = "book-".uniqid().".$ext";
            $img->move(public_path('uploads'), $img_name);
        }


        $name = $request->name;
        $desc = $request->desc;

        $book->update([
            'name' => $name,
            'desc' => $desc,
            'img'=>$img_name,
           'price'=>$request->price,
           'author_id'=>$request->author_id,
        ]);

        return back();
    }

    public function delete($id)
    {

        $book = Book::find($id);
        $img_name =$book->img;

        if($img_name != null){
            unlink(public_path("uploads/$img_name"));
        }
        
        $book->delete();

        return redirect(route('books.index'));   
    }
}

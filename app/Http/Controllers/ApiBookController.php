<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ApiBookController extends Controller
{
    public function index()
    {
        $books =Book::get();
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function store(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'desc'=>'required|string',
            'img' =>'required|image|mimes:jpg,jpeg,png|max:2048',
            'price'=>'required|numeric',
            'author_id'=>'required|exists:authors,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()        
            ]);
        }

        //move image to uploads files

        $img=$request->img;
        $ext=$img->getClientOriginalExtension();
        $img_name="book-".uniqid().".$ext";
        $img->move(public_path('uploads'),$img_name);


       // dd($request->all());
       $name=$request->name;
       $desc=$request->desc;

       $book= Book::create([
        'name'=>$name,
        'desc'=>$desc,
        'img'=>$img_name,
        'price'=>$request->price,
        'author_id'=>$request->author_id,

       ]);
        return response()->json([
            'success' => 'book created successfully',
            'book'=> $book
            ]);
    }

    public function update(Request $request, $id)
    {
         //validation
         $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'desc'=>'required|string',
            'img' =>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price'=>'required|numeric',
            'author_id'=>'required|exists:authors,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()        
            ]);
        }
        $book = Book::find($id);
        $img_name =$book->img;

        if($request->hasFile('img'))
        {
            //delete the old
            if($img_name !== null){

                unlink(public_path("uploads/$img_name"));
            }
            

            // move the new
            $img=$request->img;
        $ext=$img->getClientOriginalExtension();
        $img_name="books-".uniqid().".$ext";
        $img->move(public_path('uploads'),$img_name);

        }
        

        $name=$request->name;
        $desc=$request->desc;


        $book->update([
            'name' => $name,
            'desc' => $desc,
            'img'=>$img_name,
           'price'=>$request->price,
           'author_id'=>$request->author_id,
        ]);

        return response()->json([
            'success' => 'book created successfully',
            'author'=> $book
            ]);
    }


    public function delete( $id)
    {

        $book = Book::find($id);
        $img_name =$book->img;

        if($img_name !== null){
        unlink(public_path("uploads/$img_name"));
        }
        
        $book->delete();

        return response()->json([
            'success' => 'book deleted successfully',
            ]);
    }
}

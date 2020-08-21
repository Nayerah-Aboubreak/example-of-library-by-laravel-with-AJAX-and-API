<?php

namespace App\Http\Controllers;
use App\Author;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAuthorController extends Controller
{
    public function index()
    {
        $authors =Author::with('books')->get();
        return response()->json($authors);
    }

    public function show($id)
    {
        $author = Author::with('books')->find($id);
        return response()->json($author);
    }

    public function store(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'bio'  => 'required|string',
            'img'  => 'required|image|mimes:jpg,jpeg,png'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()        
            ]);
        }

        //move image to uploads files

        $img=$request->img;
        $ext=$img->getClientOriginalExtension();
        $img_name="author-".uniqid().".$ext";
        $img->move(public_path('uploads'),$img_name);


       // dd($request->all());
       $name=$request->name;
       $bio=$request->bio;

       $author= Author::create([
           'name'=>$name,
           'bio'=>$bio,
           'img'=>$img_name

       ]);
        return response()->json([
            'success' => 'author created successfully',
            'author'=> $author
            ]);
    }

    public function update(Request $request, $id)
    {
         //validation
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'bio'  => 'required|string',
            'img'  => 'required|image|mimes:jpg,jpeg,png'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()        
            ]);
        }
        $author = Author::find($id);
        $img_name =$author->img;

        if($request->hasFile('img'))
        {
            //delete the old
            if($img_name !== null){

                unlink(public_path("uploads/$img_name"));
            }
            

            // move the new
            $img=$request->img;
        $ext=$img->getClientOriginalExtension();
        $img_name="author-".uniqid().".$ext";
        $img->move(public_path('uploads'),$img_name);

        }
        

        $name=$request->name;
        $bio=$request->bio;


        $author->update([
            'name'=>$name,
            'bio'=>$bio,
            'img'=>$img_name
        ]);

        return response()->json([
            'success' => 'author created successfully',
            'author'=> $author
            ]);
    }


    public function delete( $id)
    {

        $author = Author::find($id);
        $img_name =$author->img;

        if($img_name !== null){
        unlink(public_path("uploads/$img_name"));
        }
        
        $author->delete();

        return response()->json([
            'success' => 'author deleted successfully',
            ]);
    }
}

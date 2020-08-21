<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::paginate(3);
        //dd($authors);
        return view('authors.index', [
            'authors' => $authors
        ]);
    }
    public function test()
    {
        /*
        $authors = Author::select('name','bio')
        //->where('id','>=',3)
        ->orderBy('id','DESC')
        ->take(3)
        ->get();

        return view('authors.test', [
            'authors'=> $authors
        ]);
        */

        $author = Author::select('name', 'bio')
            //->where('id','>=',3)
            ->orderBy('id', 'DESC')
            ->first();


        return view('authors.test', [
            'author' => $author
        ]);
    }

    public function latest()
    {
        $authors = Author::orderBy('id', 'DESC')
            ->take(3)
            ->get();


        return view('authors.latest', [
            'authors' => $authors
        ]);
    }

    public function show($id)
    {
        $author = Author::find($id); // find used with primary key only


        return view('authors.show', [
            'author' => $author
        ]);
    }


    public function search($word)
    {
        $authors = Author::where('name', 'like', "%$word%")->get();


        return view('authors.search', [
            'authors' => $authors
        ]);
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'bio' => 'required|string',
            'img' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        //move image to uploads files

        $img = $request->img;
        $ext = $img->getClientOriginalExtension();
        $img_name = "author-" . uniqid() . ".$ext";
        $img->move(public_path('uploads'), $img_name);


        // dd($request->all());
        $name = $request->name;
        $bio = $request->bio;

        Author::create([
            'name' => $name,
            'bio' => $bio,
            'img' => $img_name

        ]);

        return redirect(route('authors.index'));
    }

    public function edit($id)
    {
        $author = Author::find($id); // find used with primary key only


        return view('authors.edit', [
            'author' => $author
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'bio' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);


        $author = Author::find($id);
        $img_name = $author->img;

        if($request->hasFile('img')) {
            if($img_name !== null){
                //delete the old
                unlink(public_path("uploads/$img_name"));
            }

            // move the new
            $img = $request->img;
            $ext = $img->getClientOriginalExtension();
            $img_name = "author-".uniqid().".$ext";
            $img->move(public_path('uploads'), $img_name);
        }


        $name = $request->name;
        $bio = $request->bio;

        $author->update([
            'name' => $name,
            'bio' => $bio,
            'img' => $img_name,
        ]);

        return back();
    }


    public function delete($id)
    {

        $author = Author::find($id);
        $img_name = $author->img;

        if($img_name != null){
            unlink(public_path("uploads/$img_name"));
        }

        $author->delete();

        return redirect(route('authors.index'));
    }
}

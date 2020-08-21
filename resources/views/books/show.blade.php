@extends('layouts.app')
@section('title')
Show Books 
@endsection

@section('content')

<h1>Show book</h1>
<h3>{{$book->name}}</h3>
<img src='{{asset("uploads/$book->img")}}' width="100" height="100"></br>
<small> by:<a href="{{ route('authors.show',$book->author->id)}}">{{$book->author->name}}</a></small>
<p>{{$book->desc}}</p>
<small>Price : ${{$book->price}}</small>

</br>
</br>
<a href="{{ route('books.index')}}">Back</a>

@endsection
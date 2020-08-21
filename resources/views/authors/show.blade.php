@extends('layouts.app')
@section('title')
Show Authors 
@endsection

@section('content')

<h1>Show author {{$author->id}}</h1>
<h3>{{$author->name}}</h3>
<p>{{$author->bio}}</p>

@foreach($author->books as $book)
<a href="{{route('books.show',$book->id)}}">
    <p>{{$book->name}}</p>
</a>
@endforeach
<a href="{{ route('authors.index')}}">Back</a>

@endsection
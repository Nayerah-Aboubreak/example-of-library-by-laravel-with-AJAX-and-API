@extends('layouts.app')
@section('title')
All Books
@endsection




@section('content')

<div class="d-flex justify-content-between align-items-start">
  <h1>All books</h1>
  @auth
  <a href="{{ route('books.create') }}" class="btn btn-primary">Add new</a>
  @endauth

</div>


@foreach($books as $book)
<hr>

@if($book->img !== null)
<img src='{{asset("uploads/$book->img")}}' width="100" height="100">
@endif
<div class="d-flex justify-content-between align-items-start">
  <div>
    <a href="{{ route('books.show', $book->id) }}">
      <h2>{{ $book->name }}</h2>
    </a>

    <p> by:
      <a href="{{ route('authors.show',$book->author->id)}}">
        {{$book->author->name}}
      </a>
    </p>

    <p>{{ $book->desc }}</p>
    <p>${{ $book->price }}</p>
  </div>
  <div class="d-flex justify-content-end">
    @auth
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-info mx-2">Edit</a>
    <a href="{{ route('books.delete', $book->id) }}" class="btn btn-danger mx-2">Delete</a>
    @endauth
  </div>
</div>

@endforeach

{!! $books->render() !!}

@endsection
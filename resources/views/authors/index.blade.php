@extends('layouts.app')
@section('title')
All Authors
@endsection




@section('content')

<div class="d-flex justify-content-between align-items-start">
  <h1>All authors</h1>
  @auth
  <a href="{{ route('authors.create') }}" class="btn btn-primary">Add new</a>
  @endauth

</div>


@foreach($authors as $author)
<hr>

@if($author->img !== null)
<img src='{{asset("uploads/$author->img")}}' width="100" height="100">
@endif
<div class="d-flex justify-content-between align-items-start">
  <div>
    <a href="{{ route('authors.show', $author->id) }}">
      <h2>{{ $author->name }}</h2>
    </a>
    <p>{{ $author->bio }}</p>
  </div>


  <div class="d-flex justify-content-end">
    @auth
    <a href="{{ route('authors.edit',  $author->id) }}" class="btn btn-info mx-2">Edit</a>
    <a href="{{ route('authors.delete', $author->id) }}" class="btn btn-danger mx-2">Delete</a>
    @endauth
  </div>
</div>

@endforeach

{!! $authors->render() !!}

@endsection
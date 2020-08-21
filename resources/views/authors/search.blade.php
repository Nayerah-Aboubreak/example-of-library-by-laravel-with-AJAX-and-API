@extends('layouts.app')
@section('title')
Search Authors
@endsection

@section('content')


<h1>Search Authors</h1>

@foreach($authors as $author)
<h3>{{$author->name}}</h3>
<p>{{$author->bio}}</p>
@endforeach

@endsection
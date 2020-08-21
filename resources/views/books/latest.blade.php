@extends('layouts.app')
@section('title')
Latest Authors
@endsection

@section('content')

<h1>Latest Authors</h1>

@foreach($authors as $author)
<h3>{{$author->name}}</h3>
<p>{{$author->bio}}</p>
@endforeach


@endsection
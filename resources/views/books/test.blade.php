@extends('layouts.app')
@section('title')
Test Authors
@endsection

@section('content')

<h1>Test Authors</h1>

{{--
@foreach($authors as $author)
<h3>{{$author->name}}</h3>
<p>{{$author->bio}}</p>
@endforeach

--}}

<h3>{{$author->name}}</h3>
<p>{{$author->bio}}</p>

@endsection
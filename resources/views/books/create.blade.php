@extends('layouts.app')
@section('title')
Create Books
@endsection



@section('content')

@include('inc.errors')

<form method="POST" action="{{ route('books.store')}}" enctype="multipart/form-data">
    @csrf
    
  <div class="form-group">
    <input type="text" class="form-control" name="name" placeholder="name">
  </div>
  
  <div class="form-group">
    <textarea class="form-control" name="desc" rows="3" placeholder="description"></textarea>
  </div>

  <div class="form-group">
    <input type="number" class="form-control" name="price" placeholder="price">
  </div>

  <select class="form-control mb-4" name="author_id">
    @foreach($authors as $author)
    <option value="{{$author->id}}">{{$author->name}}</option>
    @endforeach

  </select>

  <div class="form-group">
    <input type="file" class="form-control-file" name="img">
  </div>


  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
@if($errors->any())

<div class="alert alert-danger">
  @foreach ($errors->all() as $e)
    <p>{{ $e }}</p>
  @endforeach
</div>

@endif
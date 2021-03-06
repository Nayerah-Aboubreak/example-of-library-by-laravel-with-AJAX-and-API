<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    @yield('styles')
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Library</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
          </li>
        @endguest
 
        @auth
          <li class="nav-item">
            <a class="nav-link disabled" href="#">
              {{ Auth::user()->role }} : {{ Auth::user()->username }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
          </li>
        @endauth
      </ul>
    </div>
  </nav>


<div class="container my-5">
    @yield('content')
</div>


<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
@yield('scripts')
</body>
</html>
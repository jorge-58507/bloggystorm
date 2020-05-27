<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Bloggy Storm' }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('attached/css/app.css') }}" rel="stylesheet">
    {{-- JQUERY AND POPPER --}}
    <script src="{{ asset('attached/js/jquery3-5-1.js') }} " type="text/javascript"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="{{ asset('attached/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('attached/bootstrap/js/bootstrap.min.js') }} " type="text/javascript"></script>
    
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> --}}
    {{-- FAVICON --}}
    <link rel="shortcut icon" href="attached/img/favicon_2.ico" type="image/x-icon">
    <link rel="icon" href="attached/img/favicon_2.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css"/>
    <script src="https://kit.fontawesome.com/72f3daada8.js" crossorigin="anonymous"></script>
 
  </head>
  <body>
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
        <div class="container-fluid">
          <div class="col-sm-12 flex-center d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- NAV BAR FOR MOBILE -->
            <div class="d-block d-md-none text-center">
              <ul class="navbar-nav mr-auto">
                @guest
                  <li class="nav-item"><a class="btn btn-link" href="{{ route('login') }}">Login</a></li>                
                  @if (Route::has('register'))
                    <li class="nav-item"><a class="btn btn-link" href="{{ route('register') }}">Register</a></li>                
                  @endif
                @else
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </div>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#" onclick="cls_post.get_api()">{{ __('Get API') }}</a>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">{{ 'Init' }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/home') }}">{{ 'My Office' }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#modal_post">{{ 'Post List' }}</a>
                  </li>
                  <li>
                    <a class="nav-link" id="add_post_menu" href="#" onclick="cls_post.create();"><i class="fa fa-plus-square"></i> Create New Post</a>
                  </li>
                @endguest                
              </ul>
            </div>
            <!-- NAV BAR FOR PC -->
            @if (Route::has('login'))
              <div class="top-left links d-none d-md-block">
                <ul class="navbar-nav mr-auto">
                @guest
                  <div class="dropdown">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                    <div class="dropdown-menu w_400" aria-labelledby="dropdownMenuLink">
                      <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                          <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                          <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                          <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                              <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                              </label>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row mb-0">
                          <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                              {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                              <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                              </a>
                            @endif
                          </div>
                        </div>
                      </form>
                    </div>
                    @if (Route::has('register'))
                      <a class="btn btn-light" href="{{ route('register') }}">Register</a>
                    @endif
                  </div>
                @else
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                      @if ( auth()->user()->checkRole('admin'))
                        <a class="dropdown-item" href="#" onclick="cls_post.get_api()">{{ __('Get API') }}</a>
                      @endif
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">{{ 'Init' }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/home') }}">{{ 'My Office' }}</a>
                  </li>

                @endguest
                </ul>
              </div>
            @endif
            <!-- Right Side Of Navbar -->
          </div>
          <div class="ml-auto d-none d-md-block">
            <a class="navbar-brand" href="{{ url('/') }}">
              {{ 'Bloggy Storm' }}
            </a>
          </div>
        </div>
      </nav>
      {{-- TOAST --}}
      {{-- <div id="toast_container" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center">
  <!-- Position it -->
      </div> --}}
      
          <div id="toast_container">
      </div>

      {{-- TOAST --}}
      {{-- <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div class="toast" style="position: absolute; top: 0; right: 0;">
          <div class="toast-header">
            <img src="..." class="rounded mr-2" alt="...">
            <strong class="mr-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            Hello, world! This is a toast message.
          </div>
        </div>
      </div> --}}
      <main>
          @yield('content')
      </main>
    </div>
    @yield('javascript')
  </body>
</html>

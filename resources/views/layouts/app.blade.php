<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Loja de eletrônicos') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cores.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tamanhos.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body class="body">
    <div id="app" class="container-fluid">
        <header>
            <nav class="navbar navbar-expand-md navbar-light shadow-sm bg-blue row">
                <div>
                    <a class="navbar-brand text-white" href="{{ url('/') }}">
                        {{ config('app.name', 'Loja de Eletrônicos') }}
                    </a>
                    @if(Auth::check())
                        @if (Auth::user()->roles()->adminRole()->exists())
                            <a class="navbar-brand text-white" href="{{route('index-adm')}}">Home ADM</a>
                        @endif
                    @endif
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar - DO LADO DO NOME DA LOJA -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto ">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('my-profile', Auth::user())}}">Meu perfil</a>
                                    <a class="dropdown-item" href="{{route('my-purchases')}}">Minhas compras</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <li class="nav-item dropdown icon-size-p">
                                <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                                    <i class="bi bi-bell-fill" id="notification-bell"></i>
                                    <span class="badge badge-danger navbar-badge" id="notification-count">0</span>
                                </a>
                            </li>
                            <div class="dropdown-menu dropdown-menu-right" id="notification-list">
                                 <span class="dropdown-item">Sem notificações</span>
                            </div>

                            <li class="icon-size-p">
                                <a href="{{route('cart_list')}}" name="cart">
                                    <i class="bi bi-cart-fill"></i>
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>

            <div class="row bg-color-light">
                @include('layouts.menu.nav-submenu')
            </div>
        </header>

        <main class="h-auto pb-5">
            <div class="row">
                @if (session('message') || $errors->any())
                    <div id="message" class="col">

                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @yield('content')
        </main>

        <footer class="text-footer fixed-bottom">
            <p>&copy Copyright 2025 - Loja de Eletrônicos</p>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- PUSHER --}}
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const message = document.getElementById('message');
            if (message) {
                setTimeout(function () {
                    message.style.display = 'none';
                }, 8000);
            }
        });
    </script>
    @php
        $user = auth()->user();
    @endphp
    @auth
        @if($user->isAdmin())
            <script>
                const userId = {{ $user->id }};
                Pusher.logToConsole = true;
                var pusher = new Pusher('758b69f324903be2d901', {
                    cluster: 'sa1',
                // forceTLS: true,
                    authEndpoint: '/broadcasting/auth',
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }
                });

                var channel = pusher.subscribe('admins');
                channel.bind('new_order', function(data) {
                    console.log(data);
                    let notifCount = parseInt(document.getElementById('notification-count').innerText) || 0;
                    notifCount++;
                    document.getElementById('notification-count').innerText = notifCount;
                    let drop = document.getElementById('notification-list');
                    let newItem = document.createElement('li');
                    newItem.innerText = data.message;
                    drop.prepend(newItem);
                    alert(JSON.stringify(data));
                });
            </script>
        @endif
    @endauth

</body>
</html>

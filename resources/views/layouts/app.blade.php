<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Loja de eletrônicos') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cores.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tamanhos.css') }}" rel="stylesheet">
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
                                @if (Auth::user()->isBuyer())
                                    @include('layouts.menu.menu-buyer')
                                @endif
                                @if (Auth::user()->isAdmin())
                                    @include('layouts.menu.menu-admin')
                                @endif
                            </li>
                        {{-- BARRA DE LISTA DE DESEJOS --}}
                            <li class="icon-size-p">
                                <a href="{{route('my-wish')}}" name="wish" class="text-danger">
                                    <i class="bi bi-heart-fill"></i>
                                    {{-- <i class="bi bi-heart-fill"></i> --}}
                                </a>
                            </li>
                        {{-- BARRA PARA NOTIFICAÇÕES --}}
                            <li class="nav-item dropdown icon-size-p">
                                <a class="nav-item" data-toggle="dropdown" href="#" role="button">
                                    <i class="bi bi-bell-fill" id="notification-bell"></i>
                                    <span class="badge badge-danger navbar-badge" id="notification-count">0</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="notification-list">
                                    <ul>
                                        <li class="dropdown-item" id="no-notify">Sem notificações</li>
                                    </ul>
                                </div>
                            </li>
                        {{-- CARRINHO --}}
                            <li class="icon-size-p">
                                <a href="{{route('cart_list')}}" name="cart">
                                    <i class="bi bi-cart-fill"></i>
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
            @if (Auth::check())
                @if (Auth::user()->isAdmin())
                    <div class="row bg-color-light">
                        @include('layouts.menu.submenu-admin')
                    </div>
                @else
                    <div class="row bg-color-light">
                        @include('layouts.menu.submenu-buyer')
                    </div>
                @endif
            @endif
        </header>

        <main class="h-auto pb-5">
            {{-- ALERTAS DE ERROS OU MENSAGENS DE SUCESSO --}}
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
            {{-- CONTEÚDO PRINCIPAL --}}
            @yield('content')
        </main>

        <footer class="text-footer fixed-bottom">
            <p>&copy Copyright 2025 - Loja de Eletrônicos</p>
        </footer>
    </div>


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
    @if (Auth::check())
        @if (Auth::user()->isAdmin())
            @include('layouts.script.admin-notif')
        @endif
    @endif

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')

</body>
</html>

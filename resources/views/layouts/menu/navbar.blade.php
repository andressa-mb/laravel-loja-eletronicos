<nav class="navbar navbar-expand-md navbar-light shadow-sm bg-blue row">
    <div>
        <a class="navbar-brand text-white" href="{{ url('/') }}">
            {{ config('app.name', 'Loja de Eletrônicos') }}
        </a>
        @if(Auth::check())
            @if (Auth::user()->roles()->adminRole()->exists())
                <a class="navbar-brand text-white" href="{{route('index-adm')}}">{{ __('messages.home') }}</a>
            @endif
        @endif
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar - DO LADO DO NOME DA LOJA -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown icon-size-p">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-globe"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="country_list">
                    <a class="dropdown-item" href="{{route('language', ['lang' => 'pt-BR'])}}">Português BR</a>
                    <a class="dropdown-item" href="{{route('language', ['lang' => 'en'])}}">Inglês</a>
                    <a class="dropdown-item" href="{{route('language', ['lang' => 'es'])}}">Espanhol</a>
                </div>
            </li>
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">{{ __('auth.cadastro') }}</a>
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
                            <li class="dropdown-item" id="no-notify">{{ __('messages.sem_notificacoes') }}</li>
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

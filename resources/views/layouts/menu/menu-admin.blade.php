<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{route('my-profile', Auth::user())}}">{{ __('messages.perfil') }}</a>
    <a class="dropdown-item" href="{{route('users-list')}}">{{ __('messages.usuarios_sistema') }}</a>
    <a class="dropdown-item" href="{{route('my-purchases')}}">{{ __('messages.compras') }}</a>
    <a class="dropdown-item" href="{{route('orders')}}">{{ __('messages.pedidos') }}</a>

    <a class="dropdown-item" href="{{ route('logout') }}"
    onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

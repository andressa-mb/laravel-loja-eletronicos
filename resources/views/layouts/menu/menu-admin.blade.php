<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{route('my-profile', Auth::user())}}">Meu perfil</a>
    <a class="dropdown-item" href="">Usuários do Sistema</a>
    <a class="dropdown-item" href="{{route('my-purchases')}}">Minhas compras</a>
    <a class="dropdown-item" href="{{route('orders')}}">Lista de pedidos</a>

    <a class="dropdown-item" href="{{ route('logout') }}"
    onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
    {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

<ul class="nav justify-content-center col-12">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-categories-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ __('messages.categorias') }}</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('products-associates')}}">{{ __('messages.listar') }}</a>
            <a class="dropdown-item" href="{{route('category-create')}}">{{ __('messages.cadastrar') }}</a>
            <a class="dropdown-item" href="{{route('category-show')}}">{{ __('messages.editar') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('category-show')}}">{{ __('messages.excluir') }}</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-categories-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ __('messages.produtos') }}</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('product-show')}}">{{ __('messages.listar') }}</a>
            <a class="dropdown-item" href="{{route('product-create')}}">{{ __('messages.cadastrar') }}</a>
            <a class="dropdown-item" href="{{route('product-show')}}">{{ __('messages.editar') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('product-show')}}">{{ __('messages.excluir') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('discount-show')}}">Descontos</a>
        </div>
    </li>
    {{-- MENUS EM ANDAMENTO - VERIFICAR SE SERÁ ISSO MESMO --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-categories-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ __('messages.relatorios') }}</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">{{ __('messages.vendas') }}</a>
            <a class="dropdown-item" href="#">{{ __('messages.financeiro') }}</a>
            <a class="dropdown-item" href="#">{{ __('messages.estoque') }}</a>
            <a class="dropdown-item" href="#">{{ __('messages.clientes') }}</a>
        </div>
    </li>
</ul>

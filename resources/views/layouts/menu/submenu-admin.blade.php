<ul class="nav justify-content-center col-12">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-categories-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Categorias</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('products-associates')}}">Listar</a>
            <a class="dropdown-item" href="{{route('category-create')}}">Cadastrar</a>
            <a class="dropdown-item" href="{{route('category-show')}}">Editar</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('category-show')}}">Excluir</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-categories-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Produtos</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('product-show')}}">Listar</a>
            <a class="dropdown-item" href="{{route('product-create')}}">Cadastrar</a>
            <a class="dropdown-item" href="{{route('product-show')}}">Editar</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('product-show')}}">Excluir</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('discount-show')}}">Descontos</a>
        </div>
    </li>
    {{-- MENUS EM ANDAMENTO - VERIFICAR SE SERÁ ISSO MESMO --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-categories-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Relatórios</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Vendas</a>
            <a class="dropdown-item" href="#">Financeiro</a>
            <a class="dropdown-item" href="#">Estoque</a>
            <a class="dropdown-item" href="#">Clientes</a>
        </div>
    </li>
</ul>

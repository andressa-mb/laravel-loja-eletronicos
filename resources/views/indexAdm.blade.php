@extends('layouts.app')
@section('content')


<div role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
            <button class="btn btn-sm btn-outline-secondary">Share</button>
            <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
            </button>
        </div>
    </div>



<div id="myPlot" style="width:100%;max-width:700px"></div>




    <h2>Section title</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>Header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1,001</td>
                    <td>Lorem</td>
                    <td>ipsum</td>
                    <td>dolor</td>
                    <td>sit</td>
                </tr>
                <tr>
                    <td>1,002</td>
                    <td>amet</td>
                    <td>consectetur</td>
                    <td>adipiscing</td>
                    <td>elit</td>
                </tr>
                <tr>
                    <td>1,003</td>
                    <td>Integer</td>
                    <td>nec</td>
                    <td>odio</td>
                    <td>Praesent</td>
                </tr>
                <tr>
                    <td>1,003</td>
                    <td>libero</td>
                    <td>Sed</td>
                    <td>cursus</td>
                    <td>ante</td>
                </tr>
                <tr>
                    <td>1,004</td>
                    <td>dapibus</td>
                    <td>diam</td>
                    <td>Sed</td>
                    <td>nisi</td>
                </tr>
                <tr>
                    <td>1,005</td>
                    <td>Nulla</td>
                    <td>quis</td>
                    <td>sem</td>
                    <td>at</td>
                </tr>
                <tr>
                    <td>1,006</td>
                    <td>nibh</td>
                    <td>elementum</td>
                    <td>imperdiet</td>
                    <td>Duis</td>
                </tr>
                <tr>
                    <td>1,007</td>
                    <td>sagittis</td>
                    <td>ipsum</td>
                    <td>Praesent</td>
                    <td>mauris</td>
                </tr>
                <tr>
                    <td>1,008</td>
                    <td>Fusce</td>
                    <td>nec</td>
                    <td>tellus</td>
                    <td>sed</td>
                </tr>
                <tr>
                    <td>1,009</td>
                    <td>augue</td>
                    <td>semper</td>
                    <td>porta</td>
                    <td>Mauris</td>
                </tr>
                <tr>
                    <td>1,010</td>
                    <td>massa</td>
                    <td>Vestibulum</td>
                    <td>lacinia</td>
                    <td>arcu</td>
                </tr>
                <tr>
                    <td>1,011</td>
                    <td>eget</td>
                    <td>nulla</td>
                    <td>Class</td>
                    <td>aptent</td>
                </tr>
                <tr>
                    <td>1,012</td>
                    <td>taciti</td>
                    <td>sociosqu</td>
                    <td>ad</td>
                    <td>litora</td>
                </tr>
                <tr>
                    <td>1,013</td>
                    <td>torquent</td>
                    <td>per</td>
                    <td>conubia</td>
                    <td>nostra</td>
                </tr>
                <tr>
                    <td>1,014</td>
                    <td>per</td>
                    <td>inceptos</td>
                    <td>himenaeos</td>
                    <td>Curabitur</td>
                </tr>
                <tr>
                    <td>1,015</td>
                    <td>sodales</td>
                    <td>ligula</td>
                    <td>in</td>
                    <td>libero</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


{{--     <div class="">
        <div class="m-4">
            <div id="menu-adicionar">
                <div class="d-flex align-items-center justify-content-around mt-5">
                    <h3>Cadastrar novo produto</h3>
                    <a href="{{route('product-create')}}">ADD</a>
                </div>
                <div class="d-flex align-items-center justify-content-around mt-5">
                    <h3>Cadastrar nova categoria</h3>
                    <a href="{{route('category-create')}}">ADD</a>
                </div>
            </div>

            <div id="menu-erros-sucessos" class="d-flex align-items-center justify-content-around mt-5">
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

            <div id="menu-listas" class="d-flex flex-column-2 justify-content-around mt-5">
                <div id="categories" class="">
                    <h3>Lista de categorias</h3>
                    @foreach (\App\Models\Category::get() as $category)
                        <ul class="list-group">
                            <li class="d-flex justify-content-around list-group-item">{{$category->name}}
                                <a href="{{route('products-associates', $category)}}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{route('category-edit', $category->id)}}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{route('category-delete', $category->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endforeach
                </div>
                <div id="products" class="">
                    <h3>Lista de produtos</h3>
                    @foreach (\App\Models\Product::get() as $product)
                        <ul class="list-group">
                            <li class="d-flex justify-content-around list-group-item">
                                {{$product->name}} -
                                @if($product->discount)
                                    <p style="color:red;">COM DESCONTO- </p>
                                @endif
                                R$ {{$product->total}}
                                <a href="{{route('view-product', $product->slug)}}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{route('product-edit', $product->slug)}}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{route('product-delete', $product->slug)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endforeach
                    <a href="{{route('index-buyer')}}" class="mt-4 btn btn-success">Lista de produtos</a>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- pelo w3 teste --}}
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    const xArray = ["Italy", "France", "Spain", "USA", "Argentina"];
    const yArray = [55, 49, 44, 24, 15];

    const layout = {title:"World Wide Wine Production"};

    const data = [{labels:xArray, values:yArray, type:"pie"}];

    Plotly.newPlot("myPlot", data, layout);
</script>

@endsection

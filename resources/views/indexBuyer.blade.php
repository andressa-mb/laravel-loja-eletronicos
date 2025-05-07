@extends('layouts.app')
@section('content')
    <form action="{{route('index-buyer')}}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Buscar produtos..." aria-label="Buscar produtos..." aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button type="submit" class="btn p-0">
                    <span class="input-group-text" id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </span>
                </button>
            </div>
        </div>
    </form>

    <form action="{{route("index-buyer")}}" method="GET" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-end">
            <label for="sort" class="mr-2">Ordenar por:</label>
            <select class="w-25 custom-select custom-select-sm" id="sort" name="sort" onchange="this.form.submit()" required>
                <option value="popular">Popular</option>
                <option value="lowest_price">Menor preço</option>
                <option value="highest_price">Maior preço</option>
                <option value="recent">Mais recente</option>
            </select>
        </div>
    </form>

    <div class="mt-4 row d-flex">
        <div class="col-md-3 vh-100">
            <nav id="navbar-example3" class="navbar navbar-light bg-light">
                <a class="navbar-brand" href="#">Categorias</a>
                <nav class="nav nav-pills flex-column">
                    @foreach (App\Models\Category::get() as $category)
                        <a class="nav-link" href="#{{$category->id}}">{{$category->name}}</a>
                        <nav class="nav nav-pills flex-column">
                        @foreach ($category->products as $product)
                            <a class="nav-link ml-3 my-1" href="#{{$category->id}}">{{$product->name}}</a>
                        @endforeach
                        </nav>
                    @endforeach
                </nav>
                <a href="{{route('products-associates', $category)}}" class="btn btn-info">Lista de categorias</a>
            </nav>
        </div>

        <div class="col-md-9 d-flex flex-wrap">
            @foreach ($products as $product)
                @foreach ($product->categories as $category)
                    <div class="col-md-6">
                        <div class="card p-4" style="width: 18rem; margin: 20px auto;">
                            <div data-spy="scroll" data-target="#navbar-example3" data-offset="0">
                                <img src="{{asset("storage/{$product->image}")}}" id="{{$category->pivot->category_id}}" class="card-img-top" alt="...">
                                <h4 class="card-title">{{$product->name}}</h4>
                                <p class="card-text">{{Str::limit($product->description, 60)}}</p>
                                @if (Str::length($product->description) >= 60)
                                    <p class="text-right font-italic"><a href="{{route('view-product', $product)}}">Continuar lendo...</a></p>
                                @endif
                                <p class="card-text">Quantidade: {{$product->quantity}}</p>
                                <p class="card-text">R$ {{number_format($product->total, 2, ",", ".")}}</p>
                                <a href="{{route('view-product', $product)}}"><i class="bi bi-eye-fill">Ver produto</i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

@endsection

@extends('layouts.app')
@section('content')
    <div class="mt-4 row">
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

        <div class="col-md-9">
            @foreach ($products as $product)
                @foreach ($product->categories as $category)
                    <div class="card p-4" style="width: 18rem; margin: 20px auto;">
                        <div data-spy="scroll" data-target="#navbar-example3" data-offset="0">
                            <img src="{{asset("storage/{$product->image}")}}" id="{{$category->pivot->category_id}}" class="card-img-top" alt="...">
                            <h4 class="card-title">{{$product->name}}</h4>
                            <p class="card-text">{{$product->description}}</p>
                            <p class="card-text">Quantidade: {{$product->quantity}}</p>
                            <p class="card-text">R$ {{$product->total}}</p>
                            <a href="{{route('view-product', $product)}}"><i class="bi bi-eye-fill">  Ver produto</i></a>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection

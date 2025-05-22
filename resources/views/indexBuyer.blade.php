@extends('layouts.app')
@section('content')

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

{{-- CARROSSEL --}}
    <div id="myCarousel" class="carousel slide row" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner text-center">
            <div class="carousel-item active bg-info">
                <img class="first-slide" src="{{asset("storage/product_images/example1.jpg")}}" width="500px" height="500px" alt="First slide">
                <div class="container">
                    <div class="carousel-caption text-left text-danger">
                        <h1>PROMOÇÃO</h1>
                        <p>Verifique os produtos em promoção!</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Em Promoção</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item bg-info">
                <img class="second-slide" src="{{asset("storage/product_images/3/computador.jpg")}}" width="500px" height="500px" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption text-center text-warning bg-light">
                        <h1>Os queridinhos</h1>
                        <p>Produtos mais pedidos.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Mais pedidos</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item bg-info">
            <img class="third-slide" src="{{asset("storage/product_images/4/memoria-ram-1.jpg")}}" width="500px" height="500px" alt="Third slide">
            <div class="container">
                <div class="carousel-caption text-right text-warning">
                <h1>Queima de estoque</h1>
                <p>Estão perto de acabar, corre para garantir o seu!</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Queima de estoque</a></p>
                </div>
            </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

{{-- BUSCA DE PRODUTOS --}}
    <form action="{{route('index-buyer')}}" method="GET">
        <div class="input-group mb-3 mt-5">
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

{{-- ORDENAR PRODUTOS --}}
    <form  action="{{route("index-buyer")}}" method="GET" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-end row">
            <label for="sort" class="mr-2">Ordenar por:</label>
            <select class="w-25 custom-select custom-select-sm" id="sort" name="sort" onchange="this.form.submit()" required>
                <option value="" selected></option>
                <option value="popular">Popular</option>
                <option value="lowest_price">Menor preço</option>
                <option value="highest_price">Maior preço</option>
                <option value="recent">Mais recente</option>
            </select>
        </div>
    </form>

{{-- LISTA DE PRODUTOS --}}
    {{$products->links()}}
    <div class="d-flex flex-wrap justify-content-center align-items-start row">
        @foreach ($products as $product)
            <div class="m-2">
                <div class="card p-4" style="width: 18rem; margin: 20px auto;">
                    <div data-spy="scroll" data-target="#navbar-example3" data-offset="0">
                        <img src="{{asset("storage/{$product->image}")}}" id="{{$product->id}}" class="card-img-top" alt="Imagem: {{$product->name}}">
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
    </div>
    {{$products->links()}}

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const message = document.getElementById('message');
            if (message) {
                setTimeout(function () {
                    message.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection

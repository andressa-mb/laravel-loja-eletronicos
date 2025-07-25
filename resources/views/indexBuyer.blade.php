@extends('layouts.app')
@section('content')
    <div class="row">
        {{-- CARROSSEL --}}
        <div id="myCarousel" class="carousel slide col-12" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner text-center">
                <div class="carousel-item active bg-info">
                    <img class="first-slide" src="{{$latest_discount->image ? asset("storage/$latest_discount->image") : asset("storage/default_images/mais_pedidos.png")}}" width="500px" height="500px" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption text-left text-danger">
                            <div class="texto-badge">
                                <h1>PROMOÇÃO</h1>
                                <p>Verifique os produtos em promoção!</p>
                            </div>
                            <p><a class="btn btn-lg btn-success" href="{{route('discount-products')}}" role="button">Em Promoção</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-info">
                    <img class="second-slide" src="{{$popular_product->image ? asset("storage/$popular_product->image") : asset("storage/default_images/mais_pedidos.png")}}" width="500px" height="500px" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption text-danger text-left">
                            <h1 class="texto-badge">Os queridinhos</h1>
                            <p><a class="btn btn-lg btn-success" href="{{route('popular-products')}}" role="button">Mais pedidos</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-info">
                <img class="third-slide" src="{{$liquidation_product->image ? asset("storage/$liquidation_product->image") : asset("storage/default_images/mais_pedidos.png")}}" width="500px" height="500px" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption text-danger text-left">
                        <div class="texto-badge">
                            <h1>Queima de estoque</h1>
                            <p>Estão perto de acabar, corre para garantir o seu!</p>
                        </div>
                        <p><a class="btn btn-lg btn-success" href="{{route("liquidation-products")}}" role="button">Queima de estoque</a></p>
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
        <form action="{{route('index-buyer')}}" method="GET" class="col-12">
            <div class="input-group my-5">
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
        <form action="{{route("index-buyer")}}" method="GET" enctype="multipart/form-data" class="col-12">
            @csrf
            <div class="d-flex justify-content-end">
                <label for="sort" class="mr-2">Ordenar por:</label>
                <select class="w-25 custom-select custom-select-sm" id="sort" name="sort" onchange="this.form.submit()" required>
                    <option value="" selected></option>
                    <option value="popular">{{__('messages.popular')}}</option>
                    <option value="lowest_price">{{__('messages.menor_preco')}}</option>
                    <option value="highest_price">{{__('messages.maior_preco')}}</option>
                    <option value="recent">{{__('messages.mais_recente')}}</option>
                </select>
            </div>
        </form>

        {{-- LISTA DE PRODUTOS --}}
        <div class="d-flex flex-wrap justify-content-center align-items-start form-h-size">
            <div class="col-12">
                {{$products->links()}}
            </div>
            @foreach ($products as $product)
                <div class="col">
                    <div class="card p-4" style="width: 18rem; margin: 20px auto;">
                        <div data-spy="scroll" data-target="#navbar-example3" data-offset="0">
                            <img src="{{asset("storage/{$product->image}")}}" id="{{$product->id}}" class="card-img-top" alt="Imagem: {{$product->name}}">
                            <h4 class="card-title">{{$product->name}}</h4>
                            <p class="card-text">{{Str::limit($product->description, 60)}}</p>
                            @if (Str::length($product->description) >= 60)
                                <p class="text-right font-italic"><a href="{{route('view-product', $product)}}">{{__('messages.continuar_lendo')}}</a></p>
                            @endif
                            <p class="card-text">{{__('messages.quantidade')}}: {{$product->quantity}}</p>
                            @if($product->hasDiscount && $product->isDiscountActive())
                                <p class="card-text text-success font-weight-bolder">
                                    {{__('messages.off')}} {{$product->discount_data->type}} {{$product->discount_data->discount_value}}
                                </p>
                                <p class="card-text text-decoration-line-through">
                                    <del>R$ {{number_format($product->price, 2, ",", ".")}}</del>
                                    <i class="bi bi-arrow-right font-weight-bolder"></i>
                                    <span class="text-success font-weight-bolder">R$ {{number_format($product->total_with_discount, 2, ",", ".")}}</span>
                                </p>
                            @else
                                <p class="card-text">
                                    R$ {{number_format($product->price, 2, ",", ".")}}
                                </p>
                            @endif
                            <a href="{{route('view-product', $product)}}">
                                <i class="bi bi-eye-fill">
                                    {{__('messages.ver_produto')}}
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12 h-25">
                {{$products->links()}}
            </div>
        </div>
    </div>
@endsection

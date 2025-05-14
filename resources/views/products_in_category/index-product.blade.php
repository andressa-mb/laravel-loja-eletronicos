@extends('layouts.app')
@section('content')
    <div class="text-right mt-5">
        <a href="{{route('index-buyer')}}" class="btn btn-info rounded">Voltar</a>
    </div>

    <div id="detalhes-produto" class="row justify-content-center mt-5">
        <div id="foto" class="col-md-12 text-center">
            <img src="{{asset("storage/{$product->image}")}}" width="510px" height="510px" alt="{{$product->name}}">
        </div>
        <form class="col" action="{{route('selling-product-info-client', $product)}}" id="info">
            <div class="col-md-12 card-header rounded-pill mt-3 mb-3 text-white bg-info text-center">
                <h3>{{$product->name}}</h3>
            </div>
            <div class="card col-md-12">
                <div class="card-body">
                    <p class="card-title mr-3"><strong>Descrição:</strong></p>
                    <p class="card-text">{{$product->description}}</p>
                </div>
            </div>
            @if ($product->quantity > 0)
                <div class="card col-md-12">
                    <div class="card-body">
                        <p class="card-title"><strong>Quantidade:</strong></p>
                        <input type="number" id="quantity" class="card-text text-center" min=1 max="{{$product->quantity}}" value=1 data-toggle="tooltip" data-placement="top" title="{{"Quantidade máxima: ". $product->quantity}}">
                    </div>
                </div>
            @else
                <div class="card col-md-12">
                    <div class="card-body">
                    <p class="card-title"><strong>Quantidade:</strong></p>
                    <input type="text" id="quantity" class="card-text font-weight-bold text-danger" value="ESGOTADO" disabled>
                    </div>
                </div>
            @endif
            @foreach ($product->categories as $category)
                @php
                    $category = App\Models\Category::find($category->pivot->category_id);
                @endphp
                <div class="card col-md-12">
                    <div class="card-body">
                    <p class="card-title"><strong>Categoria:</strong></p>
                    <p class="card-text">{{$category->name}}</p>
                    </div>
                </div>
            @endforeach
            <div class="card col-md-12">
                <div class="card-body">
                <p class="card-title"><strong>Valor do produto:</strong></p>
                <p class="card-text">R$ {{number_format($product->price, 2, ",", ".")}}</p>
                </div>
            </div>
            @if ($product->discount != 0)
                <div class="card col-md-12">
                    <div class="card-body">
                    <p class="card-title"><strong>Desconto:</strong></p>
                    <p class="card-text">R$ {{number_format($product->discount, 2, ",", ".")}}</p>
                    </div>
                </div>
            @endif
            <div class="card col-md-12">
                <div class="card-body">
                <p class="card-title"><strong>Total:</strong></p>
                <p class="card-text">R$ {{number_format($product->total, 2, ",", ".")}}</p>
                </div>
            </div>

            @if (Auth::user())
                @if ($product->quantity <= 0)
                    <button type="submit" class="btn btn-success mt-3" disabled data-toggle="tooltip" data-placement="top" title="Produto indisponível">Comprar</button>
                @else
                    <button type="submit" class="btn btn-success mt-3">Comprar</button>
                @endif
            @else
                <p class="mt-3"><strong class="text-danger">Você deve estar logado para realizar a compra!</strong></p>
            @endif
        </form>
    </div>

    <div class="text-right">
        <a href="{{route('index-buyer')}}" class="mt-5 mb-5 btn btn-info rounded">Voltar</a>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="mt-5">
        <h3 class="text-center mb-3">Produto: {{$product->name}}</h3>
        <div id="detalhes-produto" class="d-flex align-items-center justify-content-around">
            <div id="foto" class="">
                <img src="{{asset("storage/{$product->image}")}}" width="510px" height="510px" alt="{{$product->name}}">
            </div>
            <form action="{{route('selling-product-info-client', $product)}}" id="info">
                <h3>{{$product->name}}</h3>
                <p><strong>Descrição: </strong>{{$product->description}}</p>
                <p><strong>Quantidade: </strong>{{$product->quantity}}</p>
                @foreach ($product->categories as $category)
                @php
                    $category = App\Models\Category::find($category->pivot->category_id);
                @endphp
                    <p><strong>Categoria: </strong>{{$category->name}}</p>
                @endforeach
                <p class=""><strong>Valor do produto: </strong>R$ {{$product->price}}</p>
                @if ($product->discount != 0)
                    <p class=""><strong>Desconto: </strong>R$ {{$product->discount}}</p>
                @endif
                <p><strong>Valor total: </strong>R$ {{$product->total}}</p>
                @if (Auth::user())
                    <button type="submit" class="btn btn-success">Comprar</button>
                @else
                    <p><strong class="text-danger">Você deve estar logado para realizar a compra!</strong></p>
                @endif
            </form>

        </div>

        <div class="m-auto">
            <a href="{{route('index-buyer')}}" class="mt-5 btn btn-info rounded">Voltar</a>
        </div>
    </div>
@endsection

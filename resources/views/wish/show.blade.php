@extends('layouts.app')
@section('content')
@if($wishList->isEmpty())
    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">A lista de desejos está vazia.</h1>
    </div>
@else
<div class="row">
    <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Lista de pedidos registrados</h1>
</div>
{{ $wishList->links() }}
    @foreach ($wishList as $wish)
        <div class="row">
            <div class="card col-sm-2 m-4" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">{{$wish->products->name}}</h5>
                    <br>
                    @if ($wish->products->discount != 0)
                        <p class="card-text">Preço: R$ {{number_format($wish->products->price, 2, ",", ".")}}</p>
                        <p class="card-text">Desconto: R$ {{number_format($wish->products->discount, 2, ",", ".")}}</p>
                    @endif
                    <p class="card-text">Total: R$ {{number_format($wish->products->total, 2, ",", ".")}}</p>
                    <hr>
                    <a href="{{route('view-product', $wish->products->slug)}}" class="btn btn-primary float-right">Comprar</a>
                </div>
            </div>
        </div>
    @endforeach
{{ $wishList->links() }}
@endif
@endsection

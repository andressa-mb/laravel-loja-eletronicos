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
        <div class="row">
            <div class="d-flex flex-wrap justify-content-center align-items-start form-h-size">
                <div class="col-12">
                    {{ $wishList->links() }}
                </div>
                @foreach ($wishList as $wish)
                <div class="col m-2">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$wish->products->name}}</h5>
                            <br>
                            @if ($wish->products->hasDiscount && $wish->products->isDiscountActive())
                                <p class="card-text">
                                    <del>Preço: R$ {{number_format($wish->products->price, 2, ",", ".")}}</del>
                                </p>
                                <p class="card-text">Desconto: {{$wish->products->discount_data->type}} {{$wish->products->discount_data->discount_value}}</p>
                                <p class="card-text">Total: R$ {{number_format($wish->products->total_with_discount, 2, ",", ".")}}
                            @else
                                <p class="card-text">Total: R$ {{number_format($wish->products->total, 2, ",", ".")}}</p>
                            @endif
                            <hr>
                            <a href="{{route('view-product', $wish->products->slug)}}" class="btn btn-primary float-right">Comprar</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-12 h-25">
                    {{ $wishList->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection

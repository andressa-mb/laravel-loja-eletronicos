@extends('layouts.app')
@section('content')
    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Produtos em Liquidação</h1>

        <div class="col-12 d-flex flex-wrap justify-content-center align-items-start form-h-size">
            <div class="col-12 d-flex justify-content-center">
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h4 class="card-title text-center">Saindo muito:</h4>
                        <h5 class="card-title text-center">{{$liquidation->name}}</h5>
                        <br>
                        @if ($liquidation->hasDiscount && $liquidation->isDiscountActive())
                            <p class="card-text">
                                <del>{{__('messages.preco')}}: R$ {{number_format($liquidation->price, 2, ",", ".")}}</del>
                            </p>
                            <p class="card-text">{{__('messages.desconto')}}: {{$liquidation->discount_data->type}} {{$liquidation->discount_data->discount_value}}</p>
                            <p class="card-text">{{__('messages.total')}}: R$ {{number_format($liquidation->total_with_discount, 2, ",", ".")}}
                        @else
                            <p class="card-text">{{__('messages.total')}}: R$ {{number_format($liquidation->total, 2, ",", ".")}}</p>
                        @endif
                        <hr>
                        <a href="{{route('view-product', $liquidation->slug)}}" class="btn btn-primary float-right">{{__('messages.comprar')}}</a>
                    </div>
                </div>
            </div>
            @php
                $prodsLiquidation = App\Models\Product::lessQuantities()->paginate(6);
            @endphp

            <div class="col-12 mt-2 float-right">
                {{ $prodsLiquidation->links() }}
            </div>
            @foreach ($prodsLiquidation as $product)
                <div class="col d-flex justify-content-center">
                    <div class="card m-2" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$product->name}}</h5>
                            <br>
                            @if ($product->hasDiscount && $product->isDiscountActive())
                                <p class="card-text">
                                    <del>{{__('messages.preco')}}: R$ {{number_format($product->price, 2, ",", ".")}}</del>
                                </p>
                                <p class="card-text">{{__('messages.desconto')}}: {{$product->discount_data->type}} {{$product->discount_data->discount_value}}</p>
                                <p class="card-text">{{__('messages.total')}}: R$ {{number_format($product->total_with_discount, 2, ",", ".")}}
                            @else
                                <p class="card-text">{{__('messages.total')}}: R$ {{number_format($product->total, 2, ",", ".")}}</p>
                            @endif
                            <hr>
                            <a href="{{route('view-product', $product->slug)}}" class="btn btn-primary float-right">{{__('messages.comprar')}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12 h-25 mt-2 float-right">
                {{ $prodsLiquidation->links() }}
            </div>
        </div>
    </div>
@endsection

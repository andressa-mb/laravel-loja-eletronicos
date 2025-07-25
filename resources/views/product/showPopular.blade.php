@extends('layouts.app')
@section('content')
    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Produtos em Promoção</h1>

        <div class="col-12 d-flex flex-wrap justify-content-center align-items-start form-h-size">
            <div class="col-12 d-flex justify-content-center">
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h4 class="card-title text-center">Acabando:</h4>
                        <h5 class="card-title text-center">{{$popular->name}}</h5>
                        <br>
                        @if ($popular->hasDiscount && $popular->isDiscountActive())
                            <p class="card-text">
                                <del>{{__('messages.preco')}}: R$ {{number_format($popular->price, 2, ",", ".")}}</del>
                            </p>
                            <p class="card-text text-danger">{{__('messages.desconto')}}: {{$popular->discount_data->type}} {{$popular->discount_data->discount_value}}</p>
                            <p class="card-text">{{__('messages.total')}}: R$ {{number_format($popular->total_with_discount, 2, ",", ".")}}
                        @else
                            <p class="card-text">{{__('messages.total')}}: R$ {{number_format($popular->total, 2, ",", ".")}}</p>
                        @endif
                        <hr>
                        <a href="{{route('view-product', $popular->slug)}}" class="btn btn-primary float-right">{{__('messages.comprar')}}</a>
                    </div>
                </div>
            </div>
            @php
                $products = App\Models\Product::popularProducts()->paginate(6);
            @endphp

            <div class="col-12 mt-2 float-right">
                {{ $products->links() }}
            </div>
            @foreach ($products as $product)
                <div class="col d-flex justify-content-center">
                    <div class="card m-2" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$product->name}}</h5>
                            <br>
                            @if ($product->hasDiscount && $product->isDiscountActive())
                                <p class="card-text">
                                    <del>{{__('messages.preco')}}: R$ {{number_format($product->price, 2, ",", ".")}}</del>
                                </p>
                                <p class="card-text text-danger">{{__('messages.desconto')}}: {{$product->discount_data->type}} {{$product->discount_data->discount_value}}</p>
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

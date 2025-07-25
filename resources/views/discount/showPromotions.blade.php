@extends('layouts.app')
@section('content')
    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Produtos em Promoção</h1>

        <div class="col-12 d-flex flex-wrap justify-content-center align-items-start form-h-size">
            <div class="col-12 d-flex justify-content-center">
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h4 class="card-title text-center">Novo desconto no:</h4>
                        <h5 class="card-title text-center">{{$latest_discount->name}}</h5>
                        <br>
                        @if ($latest_discount->hasDiscount && $latest_discount->isDiscountActive())
                            <p class="card-text">
                                <del>{{__('messages.preco')}}: R$ {{number_format($latest_discount->price, 2, ",", ".")}}</del>
                            </p>
                            <p class="card-text">{{__('messages.desconto')}}: {{$latest_discount->discount_data->type}} {{$latest_discount->discount_data->discount_value}}</p>
                            <p class="card-text">{{__('messages.total')}}: R$ {{number_format($latest_discount->total_with_discount, 2, ",", ".")}}
                        @else
                            <p class="card-text">{{__('messages.total')}}: R$ {{number_format($latest_discount->total, 2, ",", ".")}}</p>
                        @endif
                        <hr>
                        <a href="{{route('view-product', $latest_discount->slug)}}" class="btn btn-primary float-right">{{__('messages.comprar')}}</a>
                    </div>
                </div>
            </div>
            @php
                $products = App\Models\Product::promotionProducts()->paginate(6);
            @endphp

            <div class="col-12 mt-2 float-right">
                {{ $products->links() }}
            </div>
            @foreach ($products as $productWDiscount)
                <div class="col d-flex justify-content-center">
                    <div class="card m-2" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{$productWDiscount->name}}</h5>
                            <br>
                            @if ($productWDiscount->hasDiscount && $productWDiscount->isDiscountActive())
                                <p class="card-text">
                                    <del>{{__('messages.preco')}}: R$ {{number_format($productWDiscount->price, 2, ",", ".")}}</del>
                                </p>
                                <p class="card-text">{{__('messages.desconto')}}: {{$productWDiscount->discount_data->type}} {{$productWDiscount->discount_data->discount_value}}</p>
                                <p class="card-text">{{__('messages.total')}}: R$ {{number_format($productWDiscount->total_with_discount, 2, ",", ".")}}
                            @else
                                <p class="card-text text-danger">
                                    {{__('messages.desconto_vencido')}}
                                </p>
                                <p class="card-text">{{__('messages.total')}}: R$ {{number_format($productWDiscount->total, 2, ",", ".")}}</p>
                            @endif
                            <hr>
                            <a href="{{route('view-product', $productWDiscount->slug)}}" class="btn btn-primary float-right">{{__('messages.comprar')}}</a>
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

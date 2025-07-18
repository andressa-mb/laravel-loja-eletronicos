@extends('layouts.app')
@section('content')
    @if($orders->isEmpty())
        <div class="row">
            <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Você ainda não possui pedidos.</h1>
        </div>
    @else
        <div class="row">
            <h1 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.meus_pedidos')}}</h1>
            <div class="d-flex flex-wrap justify-content-center align-items-start form-h-size">
                <div class="col-12">
                    {{ $orders->links() }}
                </div>
                @foreach ($orders as $order)
                    <div class="col">
                        <div class="card m-2" style="width: 36rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{__('messages.nome')}}: {{$order->user->name}}</h5>
                                <p class="card-text">{{__('messages.destinatario')}}: {{$order->userData->fullname}}</p>
                                <p class="card-text">{{__('messages.status_pedido')}}: {{$order->status}}</p>
                                <p class="card-text">{{__('messages.data_pedido')}}: {{$order->created_at->format('d/m/Y')}}</p>
                                <hr>
                                @foreach ($order->orderItems as $item)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-row">
                                            <img src="{{asset("storage/{$item->product->image}")}}" width="100px" height="100px" class="card-img-top" alt="IMAGEM DO PRODUTO">
                                        </div>
                                        <div class="flex-column ml-3">
                                            <p class="card-text">{{__('messages.produto')}}: {{$item->product->name}}</p>
                                            <p class="card-text">{{__('messages.quantidade')}}: {{$item->order_quantity}}</p>
                                            <p class="card-text">{{__('messages.total')}}: {{number_format($item->order_total, 2, ",", ".")}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                <div class="float-right">
                                    <a href="#" class="btn btn-danger">{{__('messages.cancelar_pedido')}}</a>
                                    <a href="#" class="btn btn-primary">{{__('messages.rastrear_pedido')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 h-25">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection

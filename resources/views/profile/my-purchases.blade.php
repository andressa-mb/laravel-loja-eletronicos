@extends('layouts.app')
@section('content')
    @if($orders->isEmpty())
        <div class="row">
            <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Você ainda não possui pedidos.</h1>
        </div>
    @else
        <div class="row">
            <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Meus pedidos</h1>
        </div>
        @foreach ($orders as $order)
            <div class="row">
                <div class="card col m-4" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Nome: {{$order->user->name}}</h5>
                        <p class="card-text">Destinatário: {{$order->userData->fullname}}</p>
                        <p class="card-text">Status do pedido: {{$order->status}}</p>
                        <p class="card-text">Data do pedido: {{$order->created_at->format('d/m/Y')}}</p>
                        <hr>
                        @foreach ($order->orderItems as $item)
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-row">
                                    <img src="{{asset("storage/{$item->product->image}")}}" width="100px" height="100px" class="card-img-top" alt="IMAGEM DO PRODUTO">
                                </div>
                                <div class="flex-column ml-3">
                                    <p class="card-text">Produto: {{$item->product->name}}</p>
                                    <p class="card-text">Quantidade: {{$item->order_quantity}}</p>
                                    <p class="card-text">Total: {{number_format($item->order_total, 2, ",", ".")}}</p>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        <div class="float-right">
                            <a href="#" class="btn btn-danger">Cancelar Pedido</a>
                            <a href="#" class="btn btn-primary">Rastrear Pedido</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection

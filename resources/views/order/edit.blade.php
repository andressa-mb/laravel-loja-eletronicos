@extends('layouts.app')
@section('content')
    <div class="row">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">
            {{__('messages.editar_pedido')}}
        </h3>

        <form class="col-6" action="{{route('order-update', $order)}}" method="POST">
            @method("PUT")
            @csrf
            <div class="form-group">
                <label for="nomeCliente">{{__('messages.nome')}} do usuário</label>
                <input type="text" class="form-control" id="nomeCliente" value="{{$order->user->name}}" readonly>
            </div>
            <div class="form-group">
                <label for="destinatario">{{__('messages.destinatario')}}</label>
                <input type="text" class="form-control" id="destinatario" value="{{$order->userData->fullname}}" readonly>
            </div>
            <div class="form-group">
                <label for="statusPedido">{{__('messages.status_pedido')}}</label>
                <select class="form-control" id="statusPedido" name="statusPedido">
                    <option value="{{$order->status}}" selected>{{$order->status}}</option>
                    <option value="Confirmado">Confirmado</option>
                    <option value="Cancelado">Cancelado</option>
                    <option value="Pendente">Pendente</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Editar</button>
        </form>

        <div class="col-6 m-auto">
            <div class="card">
                <div class="card-body">
                    @foreach ($order->orderItems as $item)
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-row">
                            <img src="{{asset("storage/{$item->product->image}")}}" width="100px" height="100px" class="card-img-top" alt="IMAGEM DO PRODUTO">
                        </div>
                        <div class="flex-column ml-3">
                            <p class="card-text">
                                {{__('messages.produto')}}: {{$item->product->name}}
                            </p>
                            <p class="card-text">
                                {{__('messages.quantidade')}}: {{$item->order_quantity}}
                            </p>
                            <p class="card-text">
                                {{__('messages.total')}}: {{$item->order_total}}
                            </p>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    @if(!$order->exists())
        <div class="row">
            <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Esse pedido não existe.</h1>
        </div>
    @else
        <div class="row">
            <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.status_pedido')}}</h3>

            <div class="w-50 m-auto border border-success rounded-pill p-5">
                <div class="col-12">
                    <h4>Pedido #{{$order->id}}: {{$order->status}} em {{$order->updated_at->format('d/m/Y')}}</h4>
                </div>

                <div class="col">
                    <h4>Status do rastreio:</h4>
                    @if ($track->shipping_status == 'processando')
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                            </div>
                        </div>
                        <p>{{$track->obs}}</p>
                    @elseif ($track->shipping_status == 'enviado')
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                            </div>
                        </div>
                    @elseif ($track->shipping_status == 'em trânsito')
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                        </div>
                    @elseif ($track->shipping_status == 'saiu para entrega')
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                        </div>
                    @elseif ($track->shipping_status == 'retornado' || $track->shipping_status == 'nova tentativa de entrega')
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                        </div>
                    @elseif ($track->shipping_status == 'entregue')
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                        </div>
                    @else
                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <span class="text-capitalize px-2" style="font-size: 18px;">{{$track->shipping_status}}</span>
                        </div>

                    @endif
                    <h4 class="mt-4">Previsão de entrega:</h4><span>{{$track->estimated_delivery->format('d/m/Y')}}</span>
                </div>
            </div>


        </div>
    @endif
@endsection

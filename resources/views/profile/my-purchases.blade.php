@extends('layouts.app')
@section('content')
    @if($orders->isEmpty())
        <div class="row">
            <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Você ainda não possui pedidos.</h3>
        </div>
    @else
        <div class="row">
            <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.meus_pedidos')}}</h3>
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
                                            <p class="card-text">{{__('messages.produto')}}: {{$item->product->name}} / ID: {{$item->product->id}}</p>
                                            <p class="card-text">{{__('messages.quantidade')}}: {{$item->order_quantity}}</p>
                                            <p class="card-text">{{__('messages.total')}}: {{number_format($item->order_total, 2, ",", ".")}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                <div class="float-right">
                                    @foreach ($order->orderItems as $o)
                                        @if ($o->created_at->diffInDays(now()) > 7)
                                            <span class="d-inline-block" data-trigger="hover" data-placement="top" data-toggle="popover" data-content="Período de cancelamento vencido.">
                                                <button disabled class="btn btn-danger">{{__('messages.cancelar_pedido')}}</button>
                                            </span>
                                        @else
                                            <button class="btn btn-danger"
                                                data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-id="{{$order->id}}"
                                                data-name="{{$o->product->name}}"
                                                data-route="{{route('cancel-order', $order)}}"
                                                >{{__('messages.cancelar_pedido')}}
                                            </button>
                                        @endif
                                        @if ($order->status == "Pendente")
                                            <span class="d-inline-block" data-trigger="hover" data-placement="top" data-toggle="popover" data-content="Aguardando pagamento">
                                                <button class="btn btn-primary" style="pointer-events: none;" type="button" disabled>{{__('messages.rastrear_pedido')}}</button>
                                            </span>
                                        @elseif($order->status == "Cancelado")
                                            <span class="d-inline-block" data-trigger="hover" data-placement="top" data-toggle="popover" data-content="Pedido cancelado">
                                                <button class="btn btn-primary" style="pointer-events: none;" type="button" disabled>{{__('messages.rastrear_pedido')}}</button>
                                            </span>
                                        @else
                                            <a href="{{route('track-order', $order)}}" class="btn btn-primary">{{__('messages.rastrear_pedido')}}</a>
                                        @endif
                                    @endforeach
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

    {{-- MODAL DE EXCLUSÃO DE PRODUTO --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myDeleteLabel">{{__('messages.confirmar_exclusao_pedido')}}:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>{{__('messages.confirmar_exclusao_pedido')}}: <strong id="orderProdName"></strong></p>
                        <p class="text-danger">{{__('messages.msg_acao_desfeita')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('messages.btn_confirmar')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.btn_cancelar')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                $('[data-toggle="popover"]').popover({
                    trigger: 'hover'
                })

                $('#deleteModal').on('show.bs.modal' ,function(event){
                    var btn = $(event.relatedTarget);
                    var orderProdName = btn.data('name');
                    var deleteRoute = btn.data('route');
                    $('#orderProdName').text(orderProdName);
                    $('#deleteForm').attr('action', deleteRoute);
                })
            })
        </script>
    @endsection

@endsection

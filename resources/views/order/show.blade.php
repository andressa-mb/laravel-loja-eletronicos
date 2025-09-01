@extends('layouts.app')
@section('content')
    @if($orderList->isEmpty())
        <div class="row">
            <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Não há pedidos no site.</h3>
        </div>
    @else
        <div class="row">
            <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.lista_pedidos')}}</h3>
            <div class="d-flex flex-wrap justify-content-center align-items-start form-h-size">
                <div class="col-12">
                    {{ $orderList->links() }}
                </div>
                @foreach ($orderList as $order)
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
                                        <p class="card-text">{{__('messages.total')}}: {{$item->order_total}}</p>
                                    </div>
                                </div>
                                <hr>

                                <div class="float-right">
                                    <button class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-id="{{$order->id}}"
                                        data-name="{{$item->product->name}}"
                                        data-route="{{route('cancel-order', $order)}}"
                                        >{{__('messages.cancelar_pedido')}}
                                    </button>
                                    <a href="{{route('edit-order', $order->id)}}" class="btn btn-primary">{{__('messages.editar_pedido')}}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 h-25">
                    {{ $orderList->links() }}
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
@endsection

@push('scripts')
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
@endpush

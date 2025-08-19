@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 my-2">
            <a href="{{route('product-create')}}" class="btn btn-success rounded">
                {{__('messages.novo_produto')}}
            </a>
        </div>
        <div class="col-12 form-h-size">
            <div class="float-right">
                {{ $products->links() }}
            </div>
            <table class="w-100 table border border-black">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.imagem')}}</th>
                        <th scope="col">{{__('messages.nome')}}</th>
                        <th scope="col">{{__('messages.descricao')}}</th>
                        <th scope="col">{{__('messages.quantidade')}}</th>
                        <th scope="col">{{__('messages.categoria')}}</th>
                        <th scope="col">{{__('messages.preco')}}</th>
                        <th scope="col">{{__('messages.desconto')}}</th>
                        <th scope="col">{{__('messages.valido_ate')}}</th>
                        <th scope="col">{{__('messages.total')}}</th>
                        <th scope="col">{{__('messages.editar')}}</th>
                        <th scope="col" style="white-space: nowrap;">{{__('messages.excluir')}}</th>
                    </tr>
                </thead>
                <tbody class="table table-striped">
                    @foreach ($products as $product)
                        @php
                            $categoryAssociate = $product->categories()->get();
                        @endphp
                        <tr class="text-center">
                            <th scope="row">{{$product->id}}</th>
                            <td>
                                <img src="{{asset("storage/{$product->image}")}}" id="{{$product->id}}" class="card-img-top rounded" alt="{{$product->image}}" height="70px" width="25px">
                            </td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td class="text-center" style="white-space: nowrap;">{{$product->quantity}}</td>
                            <td>
                                @if($categoryAssociate->isEmpty())
                                    {{__('messages.sem_categoria')}}
                                @else
                                    {{$categoryAssociate->pluck('name')->join(', ')}}
                                @endif
                            </td>
                            <td class="text-center" style="white-space: nowrap;">R$ {{number_format($product->price, 2, ",", ".")}}</td>
                            @if($product->hasDiscount)
                                @foreach ($product->discounts as $discount)
                                    <td class="text-center" style="white-space: nowrap; color: red;">{{$discount->type}} {{$discount->discount_value}}</td>
                                    @if($discount->end_date_input < now())
                                        <td class="text-center" style="white-space: nowrap; color: red;">Vencido: {{$discount->end_date}}</td>
                                    @else
                                        <td class="text-center" style="white-space: nowrap; color: green; font-weight: bold;">
                                            <p>{{__('messages.inicia_em')}}: {{$discount->start_date}}</p>
                                            <p>{{__('messages.valido_ate')}}: {{$discount->end_date}}</p>
                                        </td>
                                    @endif
                                @endforeach
                            @else
                                <td class="text-center" style="white-space: nowrap; font-weight: bold;">{{__('messages.sem_desconto')}} {{$product->hasDiscount}}</td>
                                <td class="text-center">{{__('messages.nao_aplica')}}</td>
                            @endif
                            @if ($product->hasDiscount && $product->isDiscountActive())
                                <td class="text-center" style="white-space: nowrap;">
                                    <p class="text-decoration-line-through">
                                        <del>R$ {{ number_format($product->original_total, 2, ",", ".") }}</del>
                                    </p>
                                    <p> R$ {{number_format($product->total_with_discount, 2, ",", ".")}}</p>
                                </td>
                            @else
                                <td class="text-center" style="white-space: nowrap;">
                                    <p>R$ {{number_format($product->original_total, 2, ",", ".")}}</p>
                                </td>
                            @endif

                            <td class="text-center">
                                <a href="{{route('product-edit', $product)}}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm"
                                  data-toggle="modal"
                                  data-target="#deleteModal"
                                  data-id="{{$product->id}}"
                                  data-name="{{$product->name}}"
                                  data-route="{{route('product-delete', $product)}}"
                                >
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
            <div class="float-right h-25">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL DE EXCLUSÃO DE PRODUTO --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myDeleteLabel">{{__('messages.confirmar_exclusao_prod')}}:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>{{__('messages.confirmar_exclusao_prod')}}: <strong id="productName"></strong></p>
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
            $('#deleteModal').on('show.bs.modal' ,function(event){
                var btn = $(event.relatedTarget);
                var productName = btn.data('name');
                var deleteRoute = btn.data('route');
                $('#productName').text(productName);
                $('#deleteForm').attr('action', deleteRoute);
            })
        })
    </script>
@endpush

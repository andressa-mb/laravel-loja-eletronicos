@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 my-2">
            <a href="{{route('product-create')}}" class="btn btn-success rounded">
                Novo Produto
            </a>
        </div>
        <div class="col-12 form-h-size">
            <div class="float-right">
                {{ $products->links() }}
            </div>
            <table class="w-100 table border border-black">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Imagem</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Válido até</th>
                        <th scope="col">Total</th>
                        <th scope="col">Editar</th>
                        <th scope="col" style="white-space: nowrap;">Excluir</th>
                    </tr>
                </thead>
                <tbody class="table table-striped">
                    @foreach ($products as $product)
                        @php
                            $categoryAssociate = $product->categories()->get();
                        @endphp
                        <tr>
                            <th scope="row">{{$product->id}}</th>
                            <td>
                                <img src="{{asset("storage/{$product->image}")}}" id="{{$product->id}}" class="card-img-top rounded" alt="{{$product->image}}" height="70px" width="25px">
                            </td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td class="text-center" style="white-space: nowrap;">{{$product->quantity}}</td>
                            <td>
                                @if($categoryAssociate->isEmpty())
                                    Sem categoria
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
                                            <p>Inicia em: {{$discount->start_date}}</p>
                                            <p>Válido até: {{$discount->end_date}}</p>
                                        </td>
                                    @endif
                                @endforeach
                            @else
                                <td class="text-center" style="white-space: nowrap; font-weight: bold;">SEM DESCONTO {{$product->hasDiscount}}</td>
                                <td class="text-center">Não se aplica</td>
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
                    <h5 class="modal-title" id="myDeleteLabel">Confirmar exclusão de produto:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Confirmar exclusão de produto: <strong id="productName"></strong></p>
                        <p class="text-danger">Esta ação não pode ser desfeita!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
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
    @endsection
@endsection

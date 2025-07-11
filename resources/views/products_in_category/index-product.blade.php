@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 my-5 text-right">
            <a href="{{route('index-buyer')}}" class="btn btn-info">Voltar</a>
        </div>
        <div id="detalhes-produto" class="col-12 row d-flex justify-content-center align-items-center">
            {{-- IMAGEM DO PRODUTO --}}
            <div id="foto" class="col-6 d-flex justify-content-center align-items-center flex-column">
                <img src="{{asset("storage/{$product->image}")}}" width="510px" height="510px" alt="{{$product->name}}">
                @if (Auth::check())
                    <div class="mt-3">
                        @php
                            $user = App\User::find(Auth::user()->id);
                            $hasWish = $user->wishes->where('product_id', $product->id)->first();
                        @endphp
                        @if ($hasWish)
                            <a href="{{route('remove-wish', $hasWish->id)}}" class="d-flex text-decoration-none text-danger font-weight-bold">
                                <h1>
                                    <i class="bi bi-heart-fill"></i>
                                </h1>
                                <span class="ml-3">Remover da lista de desejo</span>
                            </a>
                        @else
                            <a href="{{route('add-wish', $product)}}" class="d-flex text-decoration-none text-danger font-weight-bold">
                                <h1>
                                    <i class="bi bi-heart"></i>
                                </h1>
                                <span class="ml-3">Adicionar a lista de desejo</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- DADOS DO PRODUTO --}}
            <form class="col-6" action="{{route('selling-product-info-client', $product)}}" id="info">
                <div class="form-group row">
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input name="name" class="col-12 rounded-pill mt-3 mb-3 text-white bg-info text-center w-border position-static" id="withoutLabel" value="{{$product->name}}" aria-label="name">
                </div>
                <div class="form-group col-12">
                    <label for="description" class="font-form"><strong>Descrição:</strong></label>
                    <textarea name="description" id="description" cols="12" rows="4" readonly class="form-control-plaintext">{{$product->description}}</textarea>
                </div>
                {{-- QUANTIDADE --}}
                @if ($product->quantity > 0)
                    <div class="form-group col-12">
                        <label for="quantity" class="font-form"><strong>Quantidade:</strong></label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min=1 max="{{$product->quantity}}" data-toggle="tooltip" data-placement="top" title="{{"Quantidade máxima: ". $product->quantity}}" value= 1>
                    </div>
                @else
                    <div class="form-group col-12">
                        <label for="quantity" class="font-form"><strong>Quantidade:</strong></label>
                        <input type="text" name="quantity" class="font-weight-bold text-danger" id="quantity" name="quantity" value="ESGOTADO" disabled>
                    </div>
                @endif
                {{-- CATEGORIAS --}}
                <div class="form-group col-12">
                    <label for="category" class="font-form"><strong>Categoria:</strong></label>
                    @if ($product->categories->isEmpty())
                        <input type="text" name="category" class="form-control-plaintext" id="category" value="Sem categoria atribuída." readonly>
                    @else
                        @foreach ($product->categories as $category)
                            <input type="text" name="category" class="form-control-plaintext" id="category" value="{{$category->name}}" readonly>
                        @endforeach
                    @endif
                </div>
                {{-- PREÇO --}}
                <div class="form-group col-12">
                    <label for="price" class="font-form"><strong>Valor do produto:</strong></label>
                    <input type="text" class="form-control-plaintext" name="price" id="price" value="R$ {{number_format($product->price, 2, ",", ".")}}" readonly>
                    <input type="hidden" name="price" id="price" value="{{$product->price}}">

                </div>
                {{-- DESCONTO --}}
                @if ($product->hasDiscount && $product->isDiscountActive())
                    <div class="form-group col-12">
                        <label for="discount_type" class="font-form"><strong>Desconto:</strong></label>
                        <div class="d-flex justify-content-start">
                            <input type="text" class="form-control-plaintext w-25" id="discount_type" name="discount_type" value="{{$product->discount_data->type}}" readonly>
                            <input type="text" class="form-control-plaintext w-25" id="discount_value" name="discount_value" value="{{$product->discount_data->discount_value}}" readonly>
                            <input type="text" name="hasDiscount" value="{{$product->hasDiscount}}" hidden>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="total" class="font-form"><strong>Total:</strong></label>
                        <input type="text" class="form-control-plaintext" id="total" name="total" value="R$ {{number_format($product->total_with_discount, 2, ",", ".")}}" readonly>
                    </div>
                @else
                    <div class="form-group col-12">
                        <input type="text" name="hasDiscount" value="0" hidden>
                        <label for="total" class="font-form"><strong>Total:</strong></label>
                        <input type="text" class="form-control-plaintext" id="total" name="total" value="R$ {{number_format($product->total, 2, ",", ".")}}" readonly>
                    </div>

                @endif
                {{-- BOTÕES DE COMPRA --}}
                @if (Auth::user())
                    @if ($product->quantity <= 0)
                        <button type="submit" class="btn btn-success mt-3" disabled data-toggle="tooltip" data-placement="top" title="Produto indisponível">Comprar</button>
                    @else
                        <button type="submit" class="btn btn-success mt-3" name="action" value="comprar">Comprar</button>
                        <button type="submit" class="btn btn-primary mt-3" name="action" value="carrinho">Carrinho</button>
                    @endif
                @else
                    <p class="mt-3"><strong class="text-danger">Você deve estar logado para realizar a compra!</strong></p>
                @endif
            </form>
        </div>
        <div class="col-12 my-5 text-right">
            <a href="{{route('index-buyer')}}" class="btn btn-info">Voltar</a>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let qtdElement = document.getElementById('quantity');
                let priceElement = document.querySelector('input[type="hidden"][name="price"]');
                let totalElement = document.getElementById('total');
                let discountValueElement = document.getElementById('discount_value');
                let discountTypeElement = document.getElementById('discount_type');

                function calculateTotal(){
                    let quantity = parseInt(qtdElement.value) || 1;
                    let price = parseFloat(priceElement.value);
                    let total = price;

                    if (discountTypeElement && discountValueElement) {
                        const discountType = discountTypeElement.value;
                        const discountValue = parseFloat(discountValueElement.value);

                        if (discountType == '%') {
                            total = price - (price * (discountValue / 100));
                        } else if (discountType == 'R$') {
                            total = price - discountValue;
                        }
                    }

                    total = total * quantity;

                    totalElement.value = total.toLocaleString("pt-BR", {
                        style: "currency",
                        currency: "BRL"
                    });
                }

                calculateTotal();

                qtdElement.addEventListener('input', calculateTotal);
            })
        </script>
    @endsection
@endsection

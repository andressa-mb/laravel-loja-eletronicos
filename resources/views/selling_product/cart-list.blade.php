@extends('layouts.app')
@section('content')
    @php
        $productsCarts = [];
    @endphp
    <div class="row">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Carrinho de Compras</h3>
    </div>
    <div class="row">
        <form action="{{route('selling-itens-cart-list')}}" class="col">
            <table class="table table-hover table-secondary table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.nome')}}</th>
                        <th scope="col" class="text-center">{{__('messages.quantidade')}}</th>
                        <th scope="col" class="text-center">{{__('messages.preco')}}</th>
                        <th scope="col" class="text-center">{{__('messages.desconto')}}</th>
                        <th scope="col" class="text-center">{{__('messages.total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!is_null($cart_list))
                        @foreach ($cart_list as $cart)
                            <tr>
                                <th scope="row" class="form-check ml-4 text-center">
                                    <input class="form-check-input" type="checkbox" value="{{$cart['product_id']}}" name="productsCarts[]" id="cart--{{$cart['product_id']}}"
                                    @if(in_array($cart['product_id'], $productsCarts))
                                        checked
                                    @endif
                                    >
                                </th>
                                <td class="text-center">{{$cart['product_id']}}</td>
                                <td>{{$cart['name']}}</td>
                                <td class="text-center">
                                    <a onclick="decreaseQtd({{$cart['product_id']}})" style="cursor: pointer;">
                                        <i class="bi bi-arrow-left-square left"></i>
                                    </a>

                                    <span id="qtd-{{$cart['product_id']}}">{{$cart['quantity']}}</span>
                                    <input type="hidden" name="quantities[{{$cart['product_id']}}]" id="qtdInp-{{$cart['product_id']}}" value="{{$cart['quantity']}}">

                                    <a onclick="increaseQtd({{$cart['product_id']}}, {{$cart['stock']}})" style="cursor: pointer;">
                                        <i class="bi bi-arrow-right-square right"></i>
                                    </a>
                                </td>
                                <td id="price-{{$cart['product_id']}}" class="text-center">R$ {{number_format((double)$cart['price'], 2, ",", ".")}}</td>

                                @php
                                    $product = App\Models\Product::find($cart['product_id']);
                                @endphp
                                @if ($product->hasDiscount && $product->isDiscountActive())
                                    <td id="discount-{{$cart['product_id']}}" class="text-center">
                                        <span id="discount_type">{{$product->discount_data->type}} </span>
                                        <span id="discount_value">{{$product->discount_data->discount_value}}</span>
                                    </td>
                                    <td id="total-{{$cart['product_id']}}" class="text-center">R$ {{number_format((double)$cart['total'], 2, ",", ".")}}</td>
                                @else
                                    <td id="discount-{{$cart['product_id']}}" class="text-center">
                                        {{$product->hasDiscount ? 'Desconto' : 'Sem desconto'}}
                                    </td>
                                    <td id="total-{{$cart['product_id']}}" class="text-center">R$ {{number_format((double)$cart['total'], 2, ",", ".")}}</td>

                                @endif

                            </tr>
                        @endforeach
                    @else
                        <p><strong>{{__('messages.carrinho_vazio')}}</strong></p>
                    @endif
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">{{__('messages.finalizar_compra')}}</button>
        </form>
    </div>
    <div class="row ml-1 my-2">
        @if (is_null($cart_list))
            <a href="{{route('index-buyer')}}" class="btn btn-primary">{{__('messages.voltar')}}</a>
        @else
            <a href="{{route('index-buyer')}}" class="btn btn-primary">{{__('messages.continuar_comprando')}}</a>
        @endif
    </div>

    @section('scripts')
        <script>
            function increaseQtd(productId, stockMax){
                let qtdSpan = document.getElementById('qtd-' + productId);
                let priceElement = document.getElementById('price-' + productId);
                let discountTypeElement = document.querySelector(`#discount-${productId} #discount_type`);
                let discountValueElement = document.querySelector(`#discount-${productId} #discount_value`);
                let totalElement = document.getElementById('total-' + productId);

                let hasDiscount = discountTypeElement && discountValueElement;
                let priceValue = parseFloat(priceElement.innerText.replace("R$ ", "").replace(/\./g, "").replace(",", "."));
                let convertQtd = parseInt(qtdSpan.innerText);

                if(convertQtd < stockMax){
                    let newQtd = convertQtd+1;
                    let qtdInp = document.getElementById('qtdInp-' + productId);
                    qtdInp.value = newQtd;
                    qtdSpan.innerText = newQtd;

                    if(convertQtd !== newQtd){
                        let newTotal = priceValue;
                        if(hasDiscount){
                            let discountType = discountTypeElement.innerText.trim();
                            let discountValue = parseFloat(discountValueElement.innerText);
                            let totalWithDiscount = 0;

                            if(discountType === '%'){
                                let discount = discountValue/100;
                                totalWithDiscount = newTotal - (newTotal * discount);
                                newTotal = totalWithDiscount;
                            } else if(discountType === 'R$'){
                                totalWithDiscount = newTotal - discountValue;
                                newTotal = totalWithDiscount;
                            }
                        }

                        newTotal = newTotal * newQtd;
                        totalElement.innerText = newTotal.toLocaleString("pt-BR", {style:"currency", currency:"BRL"});
                    }
                }
            }

            function decreaseQtd(productId){
                let qtdSpan = document.getElementById('qtd-' + productId);
                let priceElement = document.getElementById('price-' + productId);
                let discountTypeElement = document.querySelector(`#discount-${productId} #discount_type`);
                let discountValueElement = document.querySelector(`#discount-${productId} #discount_value`);
                let totalElement = document.getElementById('total-' + productId);

                let hasDiscount = discountTypeElement && discountValueElement;
                let priceValue = parseFloat(priceElement.innerText.replace("R$ ", "").replace(/\./g, "").replace(",", "."));
                let convertQtd = parseInt(qtdSpan.innerText);

                if(convertQtd > 1){
                    let newQtd = convertQtd-1;
                    let qtdInp = document.getElementById('qtdInp-' + productId);
                    qtdInp.value = newQtd;
                    qtdSpan.innerText = newQtd;

                    if(convertQtd != newQtd){
                        let newTotal = priceValue;
                        if(hasDiscount){
                            let discountType = discountTypeElement.innerText.trim();
                            let discountValue = parseFloat(discountValueElement.innerText);
                            let totalWithDiscount = 0;

                            if(discountType === '%'){
                                let discount = discountValue/100;
                                totalWithDiscount = newTotal - (newTotal * discount);
                                newTotal = totalWithDiscount;
                            } else if(discountType === 'R$'){
                                totalWithDiscount = newTotal - discountValue;
                                newTotal = totalWithDiscount;
                            }
                        }

                        newTotal = newQtd * newTotal;
                        totalElement.innerText = newTotal.toLocaleString("pt-BR", {style:"currency", currency:"BRL"});
                    }
                }
            }
        </script>
    @endsection
@endsection

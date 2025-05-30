@extends('layouts.app')
@section('content')
    @php
        $productsCarts = [];
    @endphp

    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Carrinho de Compras</h1>
        <form action="{{route('selling-itens-cart-list')}}" method="POST" class="col">
            @csrf
            <table class="table table-hover table-secondary table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col" class="text-center">Quantidade</th>
                        <th scope="col" class="text-center">Preço</th>
                        <th scope="col" class="text-center">Desconto</th>
                        <th scope="col" class="text-center">Total</th>
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
                                    <a onclick="decreaseQtd({{$cart['product_id']}})" style="cursor: pointer;"><i class="bi bi-arrow-left-square left"></i></a>
                                        <span id="qtd-{{$cart['product_id']}}">{{$cart['quantity']}}</span>


                                        <input type="hidden" name="quantities[{{$cart['product_id']}}]" id="qtdInp-{{$cart['product_id']}}" value="{{$cart['quantity']}}">


                                    <a onclick="increaseQtd({{$cart['product_id']}}, {{$cart['stock']}})" style="cursor: pointer;"><i class="bi bi-arrow-right-square right"></i></a>
                                </td>
                                <td id="price-{{$cart['product_id']}}" class="text-center">R$ {{number_format((double)$cart['price'], 2, ",", ".")}}</td>
                                <td id="discount-{{$cart['product_id']}}" class="text-center">R$ {{number_format((double)$cart['discount'], 2, ",", ".")}}</td>
                                <td id="total-{{$cart['product_id']}}" class="text-center">R$ {{number_format((double)$cart['total'], 2, ",", ".")}}</td>
                            </tr>
                        @endforeach
                    @else
                        <p><strong>Não há produtos no carrinho.</strong></p>
                    @endif
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Finalizar compra</button>
        </form>
    </div>

    <div class="row ml-1">
        @if (is_null($cart_list))
            <a href="{{route('index-buyer')}}" class="btn btn-primary">Voltar</a>
        @else
            <a href="{{route('index-buyer')}}" class="btn btn-primary">Continuar comprando</a>
        @endif
    </div>
@endsection

<script>
    function increaseQtd(productId, stockMax){
        let qtdSpan = document.getElementById('qtd-' + productId);
        let priceElement = document.getElementById('price-' + productId);
        let discountElement = document.getElementById('discount-' + productId);
        let totalElement = document.getElementById('total-' + productId);

        priceValue = parseInt(priceElement.innerText.replace("R$ ", ""));
        discountValue = parseInt(discountElement.innerText.replace("R$ ", ""));
        totalValue = parseInt(totalElement.innerText.replace("R$ ", ""));
        let convertQtd = parseInt(qtdSpan.innerText);

        if(convertQtd < stockMax){
            let newQtd = qtdSpan.innerText = convertQtd+1;
            let qtdInp = document.getElementById('qtdInp-' + productId);
            qtdInp.value = newQtd;

            if(convertQtd !== newQtd){
                let newPrice = newQtd * priceValue;
                let newDiscount = newQtd * discountValue;
                let newTotal = newPrice - newDiscount;
                totalElement.innerText = newTotal.toLocaleString("pt-BR", {style:"currency", currency:"BRL"});
            }
        }
    }

    function decreaseQtd(productId){
        let qtdSpan = document.getElementById('qtd-' + productId);
        let priceElement = document.getElementById('price-' + productId);
        let discountElement = document.getElementById('discount-' + productId);
        let totalElement = document.getElementById('total-' + productId);

        priceValue = parseFloat(priceElement.innerText.replace("R$ ", ""));
        discountValue = parseFloat(discountElement.innerText.replace("R$ ", ""));
        totalValue = parseFloat(totalElement.innerText.replace("R$ ", ""));
        let convertQtd = parseInt(qtdSpan.innerText);

        if(convertQtd > 1){
            newQtd = qtdSpan.innerText = convertQtd-1;
            let qtdInp = document.getElementById('qtdInp-' + productId);
            qtdInp.value = newQtd;

            if(convertQtd != newQtd){
                let newPrice = newQtd * priceValue;
                let newDiscount = newQtd * discountValue;
                let newTotal = newPrice - newDiscount;
                totalElement.innerText = newTotal.toLocaleString("pt-BR", {style:"currency", currency:"BRL"});
            }
        }
    }
</script>

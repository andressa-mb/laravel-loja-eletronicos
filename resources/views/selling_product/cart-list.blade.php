@extends('layouts.app')
@section('content')

    <div class="row">
        @if (session('message') || $errors->any())
            <div id="message" class="col">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </div>

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
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Desconto</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!is_null($cart_list))
                        @foreach ($cart_list as $cart)
                            <tr>
                                <th scope="row" class="form-check ml-4">
                                    <input class="form-check-input" type="checkbox" value="{{$cart['product_id']}}" name="productsCarts[]" id="cart--{{$cart['product_id']}}"
                                    @if(in_array($cart['product_id'], $productsCarts))
                                        checked
                                    @endif
                                    >
                                </th>
                                <td>{{$cart['product_id']}}</td>
                                <td>{{$cart['name']}}</td>
                                <td>
                                    <a id="qtdLeft"><i class="bi bi-arrow-left-square left"></i></a>
                                        <span id="cart--{{$cart['product_id']}}" class="cartQtd">{{$cart['quantity']}}</span>
                                    <a id="qtdRight"><i class="bi bi-arrow-right-square right"></i></a>
                                </td>
                                <td>R$ {{number_format((double)$cart['price'], 2, ",", ".")}}</td>
                                <td>R$ {{number_format((double)$cart['discount'], 2, ",", ".")}}</td>
                                <td>R$ {{number_format((double)$cart['total'], 2, ",", ".")}}</td>
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
//    var leftButton = document.getElementById('qtdLeft');
//    var rightButton = document.getElementById('qtdRight');

/*     qtdChange.addEventListener('click', action);

    function action(){
        console.log('entrou');
        if(document.querySelectorAll('.left')){
            qtdValue = quantity++;
        }
        if(document.querySelectorAll('.right')){
            quantity--;
        }
    } */

    function left(){
         var qtd = document.querySelector('.cartQtd');
         qtd = qtd.nodeValue --;
    }

    function right(){
         var qtd = document.querySelector('.cartQtd');
         qtd = qtd.nodeValue ++;
    }

    window.addEventListener('DOMContentLoaded', function () {
        const message = document.getElementById('message');
        if (message) {
            setTimeout(function () {
                message.style.display = 'none';
            }, 3000);
        }
    });
</script>

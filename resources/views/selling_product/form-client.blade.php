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

    <form action="{{route('user-data-to-send-product')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="fullname">Nome Completo:</label>
            <input type="text" class="form-control" id="fullname" placeholder="Maria da Silva Lima" name="fullname">
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" placeholder="maria_lima@email.com" name="email" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="zipcode">Cep:</label>
                <input type="text" class="form-control" id="zipcode" placeholder="xxxxx-xxx" name="zipcode">
            </div>
            <div class="form-group col-md-8">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control" id="city" placeholder="Ex: Rio de Janeiro" name="city">
            </div>
            <div class="form-group col-md-2">
                <label for="state">Estado:</label>
                <input type="text" class="form-control" id="state" placeholder="RJ" name="state">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="street">Rua:</label>
                <input type="text" class="form-control" id="street" placeholder="Rua XYZ" name="street">
            </div>
            <div class="form-group col-md-1">
                <label for="number">Número:</label>
                <input type="number" class="form-control" id="number" placeholder="67" name="number">
            </div>
            <div class="form-group col-md-2">
                <label for="additional">Complemento:</label>
                <input type="text" class="form-control" id="additional" placeholder="Apt 200 - Bloco 2" name="additional">
            </div>
            <div class="form-group col-md-3">
                <label for="district">Bairro:</label>
                <input type="text" class="form-control" id="district" placeholder="Cidade Nova" name="district">
            </div>

        </div>
        <h4>Forma de pagamento:</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payment1" value="pix" checked>
            <label class="form-check-label" for="payment1">
              PIX
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payment2" value="cartao_de_credito">
            <label class="form-check-label" for="payment2">
              Cartão de crédito
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payment3" value="boleto">
            <label class="form-check-label" for="payment3">
              Boleto
            </label>
        </div>

        <div class="row">
            <h3 class="text-center col mt-3">Produtos selecionados:</h3>
        </div>
        <div class="row">
            @foreach ($product as $index => $prod)
                <div class="card m-4 col" style="width: 18rem;">
                    <div class="card-header">
                        <input type="hidden" name="products[{{$index}}][product_id]" value="{{$prod['product_id']}}">
                        <input type="text" class="form-control-plaintext text-center font-weight-bold" name="products[{{$index}}][name]" readonly value="Nome: {{$prod['name']}}">
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" name="products[{{$index}}][quantity]" readonly value="Quantidade: {{$prod['quantity']}}">
                        </li>
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" name="products[{{$index}}][price]" readonly value="Preço: {{number_format($prod['price'], 2, ',', '.')}}">
                        </li>
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" name="products[{{$index}}][discount]" readonly value="Desconto: {{number_format((double)$prod['discount'], 2, ',', '.')}}">
                        </li>
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" name="products[{{$index}}][total]" readonly value="Total: {{number_format($prod['total'], 2, ',', '.')}}">
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
        <button type="submit" class="mt-4 btn btn-success">Enviar</button>
    </form>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const message = document.getElementById('message');
            if (message) {
                setTimeout(function () {
                    message.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection

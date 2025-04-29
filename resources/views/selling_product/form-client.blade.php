@extends('layouts.app')
@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nome Completo:</label>
            <input type="text" class="form-control" id="name" placeholder="Maria da Silva Lima">
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" placeholder="maria_lima@email.com" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="zipcode">Cep:</label>
                <input type="text" class="form-control" id="zipcode" placeholder="xxxxx-xxx">
            </div>
            <div class="form-group col-md-8">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control" id="city" placeholder="Ex: Rio de Janeiro">
            </div>
            <div class="form-group col-md-2">
                <label for="state">Estado:</label>
                <input type="text" class="form-control" id="state" placeholder="RJ">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="address">Rua:</label>
                <input type="text" class="form-control" id="address" placeholder="Rua XYZ">
            </div>
            <div class="form-group col-md-1">
                <label for="number">Número:</label>
                <input type="number" class="form-control" id="number" placeholder="67">
            </div>
            <div class="form-group col-md-2">
                <label for="comp">Complemento:</label>
                <input type="text" class="form-control" id="comp" placeholder="Apt 200 - Bloco 2">
            </div>
            <div class="form-group col-md-3">
                <label for="neighborhood">Bairro:</label>
                <input type="text" class="form-control" id="neighborhood" placeholder="Cidade Nova">
            </div>

        </div>
        <h4>Forma de pagamento:</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payment1" value="option1" checked>
            <label class="form-check-label" for="payment1">
              PIX
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payment2" value="option1">
            <label class="form-check-label" for="payment2">
              Cartão de crédito
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="payment3" value="option1">
            <label class="form-check-label" for="payment3">
              Boleto
            </label>
        </div>

        <button type="submit" class="mt-4 btn btn-success">Enviar</button>
    </form>
@endsection

@extends('layouts.app')
@section('content')

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
            @if(is_array($product))
                @foreach ($product as $index => $prod)
                    @include('selling_product.page', ['product' => $prod, 'index' => $index])
                @endforeach
            @else
                @php
                    $productObj = App\Models\Product::where('slug', $product)->first();
                @endphp
                    @include('selling_product.page', ['product' => $productObj, 'index' => 0])
                {{-- <div class="card m-4 col" style="width: 18rem;">
                    <div class="card-header">
                        <input type="hidden" name="products" id="{{$productObj->id}}" value="{{$productObj->id}}">
                        <input type="text" class="form-control-plaintext text-center font-weight-bold" name="name-{{$productObj->name}}" readonly value="Nome: {{$productObj->name}}">
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" readonly value="Quantidade: {{$productObj->quantity}}">
                            <input type="hidden" name="qtd-{{$productObj->id}}" value="{{$productObj->quantity}}">
                        </li>
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" readonly value="Preço: {{number_format($productObj->price, 2, ',', '.')}}">
                            <input type="hidden" name="price-{{$productObj->id}}" value="{{$productObj->price}}">
                        </li>
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" name="discount-{{$productObj->id}}" readonly value="Desconto: {{number_format((double)$productObj->discount, 2, ',', '.')}}">
                            <input type="hidden" name="discount-{{$productObj->id}}" value="{{$productObj->discount}}">
                        </li>
                        <li class="list-group-item">
                            <input type="text" class="form-control-plaintext" readonly value="Total: {{number_format($productObj->total, 2, ',', '.')}}">
                            <input type="hidden" name="total-{{$productObj->id}}" value="{{$productObj->total}}">
                        </li>
                    </ul>
                </div> --}}
            @endif
        </div>
        <button type="submit" class="mt-4 btn btn-success">Enviar</button>
    </form>
@endsection

@extends('layouts.app')
@section('content')

    <form action="{{route('user-data-to-send-product')}}" method="POST" enctype="multipart/form-data" class="form-h-size">
        @csrf
        <div class="form-group">
            <label for="fullname">* {{__('messages.nome_completo')}}:</label>
            <input type="text" class="form-control send_data" id="fullname" placeholder="Maria da Silva Lima" name="fullname" required>
        </div>
        <div class="form-group">
            <label for="email">* {{__('messages.email')}}:</label>
            <input type="email" class="form-control send_data" id="email" placeholder="maria_lima@email.com" name="email" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="zipcode">* {{__('messages.cep')}}:</label>
                <input type="text" class="form-control send_data" id="zipcode" placeholder="xxxxxxxx" name="zipcode" required>
                <p class="text-danger" id="erro_cep">CEP ou tamanho inválido. Máximo 8 caracteres, apenas números.</p>
            </div>
            <div class="form-group col-md-8">
                <label for="city">* {{__('messages.cidade')}}:</label>
                <input type="text" class="form-control send_data" id="city" placeholder="Ex: Rio de Janeiro" name="city" required>
            </div>
            <div class="form-group col-md-2">
                <label for="state">* {{__('messages.estado')}}:</label>
                <input type="text" class="form-control send_data" id="state" placeholder="RJ" name="state" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="street">* {{__('messages.rua')}}:</label>
                <input type="text" class="form-control send_data" id="street" placeholder="Rua XYZ" name="street" required>
            </div>
            <div class="form-group col-md-1">
                <label for="number">* {{__('messages.numero')}}:</label>
                <input type="number" class="form-control send_data" id="number" placeholder="67" name="number" required>
            </div>
            <div class="form-group col-md-2">
                <label for="additional">{{__('messages.complemento')}}:</label>
                <input type="text" class="form-control send_data" id="additional" placeholder="Apt 200 - Bloco 2" name="additional">
            </div>
            <div class="form-group col-md-3">
                <label for="district">* {{__('messages.bairro')}}:</label>
                <input type="text" class="form-control send_data" id="district" placeholder="Cidade Nova" name="district" required>
            </div>

        </div>
        <h4 class="radio_validate">* {{__('messages.forma_pagamento')}}:</h4>
        <div id="itens_radio">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" id="payment1" value="pix" required>
                <label class="form-check-label" for="payment1">
                  {{__('messages.pix')}}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" id="payment2" value="cartao_de_credito" required>
                <label class="form-check-label" for="payment2">
                  {{__('messages.cartao_credito')}}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment" id="payment3" value="boleto" required>
                <label class="form-check-label" for="payment3">
                  {{__('messages.boleto')}}
                </label>
            </div>
        </div>

        <div class="row">
            <h3 class="text-center col mt-3">{{__('messages.produtos_selecionados')}}:</h3>
        </div>

        <div class="row">
            @if(is_array($product))
                @foreach ($product as $index => $prod)
                    @include('selling_product.page', ['product' => $prod, 'index' => $index])
                @endforeach
             @else
                @include('selling_product.page', ['product' => $product, 'index' => 0])
            @endif
        </div>
        <div class="h-25">
            <button type="submit" class="mt-4 btn btn-success">{{__('messages.enviar')}}</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#zipcode').on('change', function() {
                let cep = $('#zipcode').val();
                $('#city').val("");
                $('#state').val("");
                $('#street').val("");
                $('#district').val("");
                $('#erro_cep').hide();

                if (cep.length !== 8) {
                    $('#erro_cep').show();
                    return;
                } else {
                    $('#erro_cep').hide();
                }

                $.get('https://brasilapi.com.br/api/cep/v1/' + cep, function(data){
                    $('#city').val(data.city);
                    $('#state').val(data.state);
                    $('#street').val(data.street);
                    $('#district').val(data.neighborhood);
                });
            });

        });
    </script>
@endpush

@extends('layouts.app')
@section('content')
    <div class="row justify-content-center form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Cadastro de produtos</h3>
        <form action="{{route('product-store')}}" method="POST" enctype="multipart/form-data" class="mb-5 w-50 form-create">
            @csrf
            <div class="form-group">
                <label for="name" class="font-form">Nome:</label>
                <input type="text" id="name" name="name" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="description" class="font-form">Descrição:</label>
                <input type="text" id="description" name="description" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="price" class="font-form">Preço:</label>
                <input type="number" step=".01" id="price" name="price" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="quantity" class="font-form">Quantidade:</label>
                <input type="number" id="quantity" name="quantity" class="form-control"/>
            </div>
            <div class="form-check d-flex align-items-center">
                <input type="hidden" name="hasDiscount" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="hasDiscount" id="hasDiscount">
                <label class="form-check-label font-form" for="hasDiscount">
                    Inserir desconto
                </label>
            </div>

            {{-- SE HOUVER DESCONTO INFORMAR OS DADOS ABAIXO --}}
            <div id="discountFields" style="display: none;">
                <div class="form-group">
                    <label for="typeDiscount" class="font-form">Tipo:</label>
                    <select class="form-control w-25" id="typeDiscount">
                        <option value="" selected></option>
                        <option value="percent">%</option>
                        <option value="money">R$</option>
                    </select>
                </div>

                {{-- se for o tipo porcentagem mostrar as opções abaixo --}}
                <div id="percentType" style="display: none;">
                    <div class="form-group">
                        <label for="valueDiscount" class="font-form">Desconto:</label>
                        <select class="form-control w-25" id="valueDiscount">
                            <option>5%</option>
                            <option>10%</option>
                            <option>15%</option>
                            <option>20%</option>
                            <option>25%</option>
                            <option>30%</option>
                        </select>
                    </div>
                </div>

                {{-- se for o tipo REAL, inserir o valor --}}
                <div id="moneyType" style="display: none;">
                    <div class="form-group">
                        <label for="valueDiscount" class="font-form">Valor do desconto:</label>
                        <input type="number" step=".01" id="valueDiscount" name="valueDiscount" class="form-control"/>
                    </div>
                </div>

                {{-- DATA DE INICIO E FIM DA PROMOÇÃO --}}
                <div class="form-group">
                    <label for="startDate" class="font-form">Data de início:</label>
                    <input type="date" id="startDate" name="startDate" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="endDate" class="font-form">Data final:</label>
                    <input type="date" id="endDate" name="endDate" class="form-control"/>
                </div>
            </div>

            <div class="form-group">
                <label for="image" class="font-form">Imagem:</label>
                <input type="file" id="image" name="image" class="form-control-file"/>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success mr-3">Cadastrar</button>
                <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">Voltar</a>
            </div>
        </form>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#hasDiscount').change(function() {
                    if($(this).is(':checked')){
                        $('#discountFields').show();
                        $('input[name=hasDiscount][type=hidden]').val('1')
                    }else {
                        $('#discountFields').hide();
                        $('input[name=hasDiscount][type=hidden]').val('0')
                    }
                })

                $('#typeDiscount').change(function(){
                    if($(this).val() == 'percent'){
                        $('#percentType').show();
                        $('#moneyType').hide();
                    }else {
                        $('#moneyType').show();
                        $('#percentType').hide();
                    }
                })
            })

        </script>
    @endsection

@endsection

@extends('layouts.app')
@section('content')
    <div class="row justify-content-center form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Cadastro de desconto</h3>
        <form action="{{route('discount-store')}}" method="POST" enctype="multipart/form-data" class="mb-5 w-50 form-create">
            @csrf
            <div id="discountFields">
                <div class="form-group">
                    <label for="messageDiscount" class="font-form">Texto referente ao desconto:</label>
                    <input type="text" id="messageDiscount" name="messageDiscount" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="typeDiscount" class="font-form">Tipo:</label>
                    <select class="form-control w-25" id="typeDiscount" name="typeDiscount">
                        <option value="" selected></option>
                        <option value="%">%</option>
                        <option value="R$">R$</option>
                    </select>
                </div>

                {{-- se for o tipo porcentagem mostrar as opções abaixo --}}
                <div id="percentType" style="display: none;">
                    <div class="form-group">
                        <label for="percentDiscount" class="font-form">Desconto:</label>
                        <select class="form-control w-25" id="percentDiscount" name="percentDiscount">
                            <option value="5">5%</option>
                            <option value="10">10%</option>
                            <option value="15">15%</option>
                            <option value="20">20%</option>
                            <option value="25">25%</option>
                            <option value="30">30%</option>
                        </select>
                    </div>
                </div>

                {{-- se for o tipo DINHEIRO, inserir o valor --}}
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
            <div class="text-center">
                <button type="submit" class="btn btn-success mr-3">Cadastrar</button>
                <a type="button" class="btn btn-primary" href="{{route('discount-show')}}">Voltar</a>
            </div>
        </form>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                function checkType() {
                    const type = $('#typeDiscount').val();
                    if(type == "%"){
                        $("#percentType").show();
                        $("#moneyType").hide();
                        $("#moneyType").val('');
                    } else if (type === "R$") {
                        $("#percentType").hide();
                        $("#moneyType").show();
                        $("#percentType").val('');
                    }
                }

                checkType();

                $('#typeDiscount').change(function(){
                    checkType();
                })

                $('form').submit(function() {
                    const type = $('#typeDiscount').val();
                    if(type == "%") {
                        $("#valueDiscount").val('');
                        $("#percentDiscount").prop('disabled', false);
                        $("#valueDiscount").prop('disabled', true);
                    } else {
                        $("#percentDiscount").val('');
                        $("#percentDiscount").prop('disabled', true);
                        $("#valueDiscount").prop('disabled', false);
                    }
                    return true;
                });
            })
        </script>
    @endsection
@endsection

@extends('layouts.app')
@section('content')
    <div class="row form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.alteracao_dados')}}:</h3>
        <form action="{{route('discount-update', $discount)}}" method="POST" enctype="multipart/form-data" class="m-auto w-50 form-h-size">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="typeDiscount" class="font-form">{{__('messages.tipo')}}:</label>
                    <select class="form-control w-25" id="typeDiscount" name="typeDiscount">
                        <option value="%" {{ $discount->type == '%' ? 'selected' : '' }}>%</option>
                        <option value="R$" {{ $discount->type == 'R$' ? 'selected' : '' }}>R$</option>
                    </select>
                </div>
                {{-- se for o tipo porcentagem mostrar as opções abaixo --}}
                <div id="percentType" style="{{ $discount->type == '%' ? 'display: block;' : 'display: none;' }}">
                    <div class="form-group">
                        <label for="percentDiscount" class="font-form">{{__('messages.desconto')}}:</label>
                        <select class="form-control w-25" id="percentDiscount" name="percentDiscount">
                            <option value="5" {{ $discount->discount_value == 5 ? 'selected' : '' }}>5%</option>
                            <option value="10" {{ $discount->discount_value == 10 ? 'selected' : '' }}>10%</option>
                            <option value="15" {{ $discount->discount_value == 15 ? 'selected' : '' }}>15%</option>
                            <option value="20" {{ $discount->discount_value == 20 ? 'selected' : '' }}>20%</option>
                            <option value="25" {{ $discount->discount_value == 25 ? 'selected' : '' }}>25%</option>
                            <option value="30" {{ $discount->discount_value == 30 ? 'selected' : '' }}>30%</option>
                        </select>
                    </div>
                </div>

                {{-- se for o tipo DINHEIRO, inserir o valor --}}
                <div id="moneyType" style="display: none;">
                    <div class="form-group">
                        <label for="valueDiscount" class="font-form">{{__('messages.valor_desconto')}}:</label>
                        <input type="number" step=".01" class="form-control" id="valueDiscount" name="valueDiscount" value="{{$discount->discount_value}}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="messageDiscount" class="font-form">{{__('messages.texto_desconto')}}:</label>
                    <input type="text" id="messageDiscount" name="messageDiscount" value="{{$discount->message}}" class="form-control"/>
                </div>

                {{-- DATA DE INICIO E FIM DA PROMOÇÃO --}}
                <div class="form-group">
                    <label for="startDate" class="font-form">{{__('messages.data_inicio')}}:</label>
                    <input type="date" id="startDate" name="startDate" value="{{$discount->start_date_input}}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="endDate" class="font-form">{{__('messages.data_final')}}:</label>
                    <input type="date" id="endDate" name="endDate" value="{{$discount->end_date_input}}" class="form-control"/>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">{{__('messages.atualizar')}}</button>
                <a type="button" class="btn btn-primary" href="{{route('discount-show')}}">{{__('messages.voltar')}}</a>
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

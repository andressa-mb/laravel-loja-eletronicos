@extends('layouts.app')
@section('content')
    <div class="row">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Cadastro de produtos</h3>
        <form action="{{route('product-store')}}" method="POST" enctype="multipart/form-data" class="m-auto w-50 form-h-size">
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
                @php
                    $discounts = App\Models\Discount::all();
                @endphp
                <div class="form-group">
                    <label for="typeDiscount" class="font-form">Tipo:</label>
                    <select class="form-control w-25" id="typeDiscount" name="typeDiscount">
                        <option value="" selected></option>
                        <option value="%">%</option>
                        <option value="R$">R$</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="discount_values" class="font-form">Valores:</label>
                    <select class="form-control w-25" id="discount_values" name="discount_values">

                    </select>
                </div>
                <div class="form-group" id="datesDiscounts" name="datesDiscounts"></div>
            </div>

            <div class="form-group">
                <label for="image" class="font-form">Imagem:</label>
                <input type="file" id="image" name="image" class="form-control-file"/>
            </div>
            <div class="text-center pb-5">
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

                const discounts = @json($discounts);

                function showDiscountDates(discountId){
                    const selectedDiscount = discounts.find(d => d.id == discountId);
                    if(selectedDiscount){
                        $("#datesDiscounts").html(`
                            <p>Início do desconto: ${selectedDiscount.start_date}</p>
                            <p>Fim do desconto: ${selectedDiscount.end_date}</p>
                        `)
                    }
                }

                $("#typeDiscount").change(function(){
                    const type = $(this).val();
                    let value = "";
                    let filterType = discounts.filter(d => d.type == type);

                    if(filterType.length > 0){
                        value += filterType.map(discount => `
                                <option value="${discount.id}">
                                    ${discount.type} ${discount.discount_value}
                                </option>
                            `)
                        showDiscountDates(filterType[0].id);
                    }else {
                        value = `<option value="0">0</option>`
                    }
                    $("#discount_values").empty().append(value);
                })

                $("#discount_values").change(function() {
                    let selectedId = $(this).val();
                    showDiscountDates(selectedId);
                })
            })
        </script>
    @endsection
@endsection

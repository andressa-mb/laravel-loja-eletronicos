@extends('layouts.app')
@section('content')
    <div class="row">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.alteracao_dados')}}:</h3>
        <form action="{{route('product-update', $product)}}" method="POST" enctype="multipart/form-data" class="m-auto w-50 form-h-size">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <label for="name" class="font-form">{{__('messages.nome')}}:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}">
                <label for="description" class="font-form">{{__('messages.descricao')}}:</label>
                <textarea name="description" id="description" cols="18" rows="5" class="form-control">{{$product->description}}</textarea>
                <label for="price" class="font-form">{{__('messages.valor_produto')}}:</label>
                <input type="number" id="price" name="price" step=".01" class="form-control" value="{{$product->price}}">
                <label for="quantity" class="font-form">{{__('messages.quantidade')}}:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{$product->quantity}}">

                <div class="form-check d-flex align-items-center">
                    <input type="hidden" name="hasDiscount" value="0">
                    <input class="form-check-input" type="checkbox" value="1" name="hasDiscount" id="hasDiscount">
                    <label class="form-check-label font-form" for="hasDiscount">
                        {{__('messages.inserir_desconto')}}
                    </label>
                </div>

                {{-- SE HOUVER DESCONTO INFORMAR OS DADOS ABAIXO --}}
                <div id="discountFields" style="display: none;">
                    @php
                        $discounts = App\Models\Discount::all();
                    @endphp
                    <div class="form-group">
                        <label for="typeDiscount" class="font-form">{{__('messages.tipo')}}:</label>
                        <select class="form-control w-25" id="typeDiscount" name="typeDiscount">
                            <option value="" selected></option>
                            <option value="%">%</option>
                            <option value="R$">R$</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount_values" class="font-form">{{__('messages.valores')}}:</label>
                        <select class="form-control w-25" id="discount_values" name="discount_values">

                        </select>
                    </div>
                    <div class="form-group" id="datesDiscounts"></div>
                </div>

                <label for="image" class="font-form">{{__('messages.imagem')}}:</label>
                <input type="file" id="image" name="image" class="form-control-file" value="{{$product->image}}">
            </div>
            <div class="text-center pb-5">
                <button type="submit" class="btn btn-success">{{__('messages.salvar')}}</button>
                <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">{{__('messages.voltar')}}</a>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
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
                console.log('find dates: ', selectedDiscount);
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
                    console.log('filtro: ', filterType[0].id);
                    showDiscountDates(filterType[0].id);
                }else {
                    value = `<option value="0">0</option>`
                }

                $("#discount_values").empty().append(value);
            })

            $("#discount_values").change(function() {
                let selectedId = $(this).val();
                console.log('change: ', selectedId);
                showDiscountDates(selectedId);
            })
        })
    </script>
@endpush

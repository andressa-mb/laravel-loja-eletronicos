@extends('layouts.app')
@section('content')
    <div class="row text-right mt-5 ml-5">
        <a href="{{route('index-buyer')}}" class="btn btn-info">Voltar</a>
    </div>
    <div id="detalhes-produto" class="row justify-content-center mt-5">
        <div id="foto" class="col d-flex justify-content-center align-items-center flex-column">
            <img src="{{asset("storage/{$product->image}")}}" width="510px" height="510px" alt="{{$product->name}}">
            <div class="mt-3">
                @if (Auth::user()->id)
                    @php
                        $user = App\User::find(Auth::user()->id);
                        $hasWish = $user->wishes->where('product_id', $product->id)->first();
                    @endphp
                    @if ($hasWish)
                        <a href="{{route('remove-wish', $hasWish->id)}}" class="d-flex text-decoration-none text-danger font-weight-bold">
                            <h1>
                                <i class="bi bi-heart-fill"></i>
                            </h1>
                            <span class="ml-3">Remover da lista de desejo</span>
                        </a>
                    @else
                        <a href="{{route('add-wish', $product)}}" class="d-flex text-decoration-none text-danger font-weight-bold">
                            <h1>
                                <i class="bi bi-heart"></i>
                            </h1>
                            <span class="ml-3">Adicionar a lista de desejo</span>
                        </a>
                    @endif
                @endif
            </div>
        </div>
        <form class="col" action="{{route('selling-product-info-client', $product)}}" id="info">
            <div class="form-group row">
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input name="name" class="col-md-12 rounded-pill mt-3 mb-3 text-white bg-info text-center w-border position-static" id="withoutLabel" value="{{$product->name}}" aria-label="name">
            </div>
            <div class="form-group col-md-12">
                <label for="description" class="font-form"><strong>Descrição:</strong></label>
                <textarea name="description" id="description" cols="12" rows="4" readonly class="form-control-plaintext">{{$product->description}}</textarea>
            </div>
            @if ($product->quantity > 0)
                <div class="form-group col-md-12">
                    <label for="quantity" class="font-form"><strong>Quantidade:</strong></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min=1 max="{{$product->quantity}}" value=1 data-toggle="tooltip" data-placement="top" title="{{"Quantidade máxima: ". $product->quantity}}">
                </div>
            @else
                <div class="form-group col-md-12">
                    <label for="quantity" class="font-form"><strong>Quantidade:</strong></label>
                    <input type="text" name="quantity" disabled class="font-weight-bold text-danger" id="quantity" name="quantity" value="ESGOTADO">
                </div>
            @endif
                <div class="form-group col-md-12">
                    <label for="category" class="font-form"><strong>Categoria:</strong></label>
                    @if ($product->categories->isEmpty())
                        <input type="text" name="category" readonly class="form-control-plaintext" id="category" value="Sem categoria atribuída.">
                    @else
                        @foreach ($product->categories as $category)
                            <input type="text" name="category" readonly class="form-control-plaintext" id="category" value="{{$category->name}}">
                        @endforeach
                    @endif
                </div>
                <div class="form-group col-md-12">
                    <label for="price" class="font-form"><strong>Valor do produto:</strong></label>
                    <input type="text" readonly class="form-control-plaintext" value="R$ {{number_format($product->price, 2, ",", ".")}}">
                    <input type="hidden" name="price" id="price" value="{{$product->price}}">
                </div>
            @if ($product->discount != 0)
                <div class="form-group col-md-12">
                    <label for="discount" class="font-form"><strong>Desconto:</strong></label>
                    <input type="text" readonly class="form-control-plaintext" value="R$ {{number_format($product->discount, 2, ",", ".")}}">
                    <input type="hidden" name="discount" id="discount" value="{{$product->discount}}">
                </div>
            @endif
            <div class="form-group col-md-12">
                <label for="total" class="font-form"><strong>Total:</strong></label>
                <input type="text" name="total" readonly class="form-control-plaintext" id="total" value="R$ {{number_format($product->total, 2, ",", ".")}}">
            </div>
            @if (Auth::user())
                @if ($product->quantity <= 0)
                    <button type="submit" class="btn btn-success mt-3" disabled data-toggle="tooltip" data-placement="top" title="Produto indisponível">Comprar</button>
                @else
                    <button type="submit" class="btn btn-success mt-3" name="action" value="comprar">Comprar</button>
                    <button type="submit" class="btn btn-primary mt-3" name="action" value="carrinho">Carrinho</button>
                @endif
            @else
                <p class="mt-3"><strong class="text-danger">Você deve estar logado para realizar a compra!</strong></p>
            @endif
        </form>
    </div>
    <div class="text-right">
        <a href="{{route('index-buyer')}}" class="mt-5 mb-5 btn btn-info">Voltar</a>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let qtdElement = document.getElementById('quantity');
        let priceElement = document.getElementById('price');
        let discountElement = document.getElementById('discount');
        let totalElement = document.getElementById('total');

        function updateTotal(){
            let qtd = parseInt(qtdElement.value);
            let price = parseFloat(priceElement.value.replace("R$ ", ""));
            let discount = discountElement ? parseFloat(discountElement.value.replace("R$ ", "")) : 0;
            let total = parseFloat(totalElement.value.replace("R$ ", ""));
            let newValue = (price - discount) * qtd;
            totalElement.value = newValue.toLocaleString("pt-BR", {style:"currency", currency:"BRL"});
        }

        qtdElement.addEventListener('input', updateTotal);
    })
</script>

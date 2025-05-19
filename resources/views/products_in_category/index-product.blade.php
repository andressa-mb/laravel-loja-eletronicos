@extends('layouts.app')
@section('content')
    <div class="text-right mt-5">
        <a href="{{route('index-buyer')}}" class="btn btn-info">Voltar</a>
    </div>

    <div id="detalhes-produto" class="row justify-content-center mt-5">
        <div id="foto" class="col-md-12 text-center">
            <img src="{{asset("storage/{$product->image}")}}" width="510px" height="510px" alt="{{$product->name}}">
        </div>
        <form class="col" action="{{route('selling-product-info-client', $product)}}" id="info">

            <div class="form-group row">
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input name="name" class="col-md-12 rounded-pill mt-3 mb-3 text-white bg-info text-center w-border position-static" id="withoutLabel" value="{{$product->name}}" aria-label="name">
            </div>
            <div class="form-group col-md-12">
                <label for="description" class="font-form"><strong>Descrição:</strong></label>
                 <textarea name="description" id="description" cols="18" rows="5" readonly class="form-control-plaintext">{{$product->description}}</textarea>
            </div>
            @if ($product->quantity > 0)
                <div class="form-group col-md-12">
                    <label for="quantity" class="font-form"><strong>Quantidade:</strong></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min=1 max="{{$product->quantity}}" value=1 data-toggle="tooltip" data-placement="top" title="{{"Quantidade máxima: ". $product->quantity}}" >
                </div>
            @else
                <div class="form-group col-md-12">
                    <label for="quantity" class="font-form"><strong>Quantidade:</strong></label>
                    <input type="text" name="quantity" disabled class="font-weight-bold text-danger" id="quantity" name="quantity" value="ESGOTADO">
                </div>
            @endif
            @foreach ($product->categories as $category)
                @php
                    $category = App\Models\Category::find($category->pivot->category_id);
                @endphp
                <div class="form-group col-md-12">
                    <label for="category" class="font-form"><strong>Categoria:</strong></label>
                    <input type="text" name="category" readonly class="form-control-plaintext" id="category" value="{{$category->name}}">
                </div>
            @endforeach
                <div class="form-group col-md-12">
                    <label for="price" class="font-form"><strong>Valor do produto:</strong></label>
                    <input type="text" name="price" readonly class="form-control-plaintext" id="price" value="R$ {{number_format($product->price, 2, ",", ".")}}">
                </div>
            @if ($product->discount != 0)
                <div class="form-group col-md-12">
                    <label for="discount" class="font-form"><strong>Desconto:</strong></label>
                    <input type="text" name="discount" readonly class="form-control-plaintext" id="discount" value="R$ {{number_format($product->discount, 2, ",", ".")}}">
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

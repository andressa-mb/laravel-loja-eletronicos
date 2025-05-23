@extends('layouts.app')
@section('content')
    <div class="row form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Alteração dos dados:</h3>
        <form action="{{route('product-update', $product)}}" method="POST" enctype="multipart/form-data" class="m-auto w-50 form-create form-edit">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name" class="font-form">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}">
                <label for="description" class="font-form">Descrição:</label>
                <textarea name="description" id="description" cols="18" rows="5" class="form-control">{{$product->description}}</textarea>
                <label for="price" class="font-form">Valor do produto:</label>
                <input type="number" id="price" name="price" step=".01" class="form-control" value="{{$product->price}}">
                <label for="quantity" class="font-form">Quantidade:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{$product->quantity}}">
                <label for="discount" class="font-form">Desconto:</label>
                <input type="number" step=".01" id="discount" name="discount" class="form-control" value="{{$product->discount}}">
                <label for="image" class="font-form">Imagem:</label>
                <input type="file" id="image" name="image" class="form-control-file" value="{{$product->image}}">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">Voltar</a>

            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')
@section('content')

    <div class="mt-5">
        <h3>Alteração dos dados:</h3>
        <form action="{{route('product-update', $product)}}" method="POST" enctype="multipart/form-data" class="content m-auto w-50">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" cols="18" rows="5" class="form-control">{{$product->description}}</textarea>
                <label for="price">Valor do produto:</label>
                <input type="number" id="price" name="price" step=".01" class="form-control" value="{{$product->price}}">
                <label for="quantity">Quantidade:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{$product->quantity}}">
                <label for="discount">Desconto:</label>
                <input type="number" step=".01" id="discount" name="discount" class="form-control" value="{{$product->discount}}">
                <label for="image">Imagem:</label>
                <input type="file" id="image" name="image" class="form-control-file" value="{{$product->image}}">
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">Voltar</a>
        </form>

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        var foco = document.getElementById('name');
        foco.focus();
    </script>
@endsection

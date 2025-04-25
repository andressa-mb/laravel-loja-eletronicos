@extends('layouts.app')

<div class="mt-5">
    <h3>Cadastro de produtos</h3>
    <form action="{{route('product-store')}}" method="POST" class="content m-auto w-50">
        @csrf
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <input type="text" id="description" name="description" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="price">Preço:</label>
            <input type="number" step=".01" id="price" name="price" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="quantity">Quantidade:</label>
            <input type="number" id="quantity" name="quantity" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="discount">Desconto:</label>
            <input type="number" step=".01" id="discount" name="discount" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            <input type="file" id="image" name="image" class="form-control-file"/>
        </div>
        <button type="submit" class="btn btn-success">Cadastrar</button>
        <a type="button" class="btn btn-primary" href="{{route('welcome')}}">Voltar</a>
    </form>

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

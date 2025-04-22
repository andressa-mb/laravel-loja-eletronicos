@extends('layouts.app')

<div class="mt-5">
    <h3>Formulário de cadastro</h3>
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
            <input type="number" id="price" name="price" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="quantity">Quantidade:</label>
            <input type="number" id="quantity" name="quantity" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="discount">Desconto:</label>
            <input type="text" id="discount" name="discount" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            <input type="file" id="image" name="image" class="form-control-file"/>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

</div>

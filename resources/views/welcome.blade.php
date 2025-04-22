@extends('layouts.app')

    <div class="content">


        <div class="m-4">
            <div class="text-center">
                <h1>Loja de eletrônicos</h1>
            </div>
            <div class="d-flex align-items-center justify-content-around mt-5">
                <h3>Cadastrar novo produto</h3>
                <a href="{{route('product-create')}}">ADD</a>
            </div>
            <div>
                <p>som e vídeo</p>
                <p>computador</p>
                <p>celular</p>
                <p>drone</p>
                <p>controladores</p>
            </div>
            <div>
                <h3>Lista de produtos cadastrados</h3>
                <ul>
                    @foreach ($products as $product)
                        <li>Nome: {{$product->name}} <br>
                            Valor: {{$product->price}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@extends('layouts.app')

<div class="mt-5">
    <h3 class="text-center mb-3">Produtos da categoria: {{$category->name}}</h3>

    <table class="table m-auto w-50 border border-black">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Quantidade em estoque</th>
            <th scope="col">Valor total</th>
          </tr>
        </thead>
        <tbody class="table table-striped">
            @foreach ($category->products()->get() as $product)
              <tr>
                <th scope="row">{{$product->id}}</th>
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <td class="text-center">{{$product->quantity}}</td>
                <td>R$ {{$product->total}}</td>
              </tr>
            @endforeach
        </tbody>
    </table>

    <div class="m-auto w-50">
        <a href="{{route('welcome')}}" class="mt-5 btn btn-info rounded">Voltar</a>
    </div>

</div>


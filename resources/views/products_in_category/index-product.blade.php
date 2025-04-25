@extends('layouts.app')

<div class="mt-5">
    <h3 class="text-center mb-3">Detalhes do Produto: {{$product->name}}</h3>

    <table class="table m-auto w-60 border border-black">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Imagem</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Quantidade em estoque</th>
            <th scope="col">Categoria</th>
            <th scope="col">Preço</th>
            <th scope="col">Desconto</th>
            <th scope="col">Valor total</th>
          </tr>
        </thead>
        <tbody class="table table-striped">
              <tr>
                <th scope="row">{{$product->id}}</th>
                <td><img src="{{asset("storage/{$product->image}")}}" alt="{{$product->name}}" width="25px" height="25px"></td>
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <td class="text-center">{{$product->quantity}}</td>
                @foreach ($product->categories as $category)
                   @php
                    $category = App\Models\Category::find($category->pivot->category_id);
                   @endphp
                    <td>{{$category->name}}</td>
                @endforeach
                <td class="text-center">R$ {{$product->price}}</td>
                <td class="text-center">R$ {{$product->discount}}</td>
                <td>R$ {{$product->total}}</td>
              </tr>

        </tbody>
    </table>

    <div class="m-auto w-50">
        <a href="{{route('welcome')}}" class="mt-5 btn btn-info rounded">Voltar</a>
    </div>

</div>


@extends('layouts.app')
@section('content')
    <div class="mt-5 table-responsive-md">
        @foreach ($categories as $category)
        <h3 class="text-center mt-4">{{$category->name}}</h3>
            <table class="table border border-black">
                <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col" style="white-space: nowrap;">Quantidade em estoque</th>
                    <th scope="col" style="white-space: nowrap;">Valor total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="table table-striped">
                    @foreach ($category->products()->get() as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td class="text-center" style="white-space: nowrap;">{{$product->quantity}}</td>
                        <td style="white-space: nowrap;">R$ {{number_format($product->total, 2, ",", ".")}}</td>
                        <td><a href="{{route('view-product', $product)}}"><i class="bi bi-eye-fill"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <div class="m-auto">
            <a href="{{route('index-buyer')}}" class="mt-5 btn btn-info rounded">Voltar</a>
        </div>
    </div>
@endsection

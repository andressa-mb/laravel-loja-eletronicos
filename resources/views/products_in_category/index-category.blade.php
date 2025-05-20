@extends('layouts.app')
@section('content')

    <div class="row ml-4">
        <a href="{{route('index-buyer')}}" class="mt-5 mb-5 btn btn-info">Voltar</a>
    </div>

    <div class="table-responsive-md m-auto row">
        @foreach ($categories as $category)
            <div class="col-12">
                <h3 class="text-center mt-4" id="{{$category->id}}">{{$category->name}}</h3>
            </div>
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
    </div>

    <div class="table-responsive-md m-auto row">
        <div class="col-12">
            <h3 class="text-center mt-4">Produtos sem categoria</h3>
        </div>
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
                @foreach (App\Models\Product::get() as $product)
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
    </div>

    <div class="row ml-4">
        <a href="{{route('index-buyer')}}" class="mt-5 mb-5 btn btn-info">Voltar</a>
    </div>
@endsection

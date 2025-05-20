@extends('layouts.app')
@section('content')

    <div class="row">
        @if (session('message') || $errors->any())
            <div id="message" class="col">
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
        @endif
    </div>

    <div class="row">
        {{ $products->links() }}
        <table class="table border border-black">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Desconto</th>
                    <th scope="col">Total</th>
                    <th scope="col">Editar</th>
                    <th scope="col" style="white-space: nowrap;">Excluir</th>
                </tr>
            </thead>
            <tbody class="table table-striped">
                @foreach ($products as $product)
                    @php
                        $categoryAssociate = $product->categories()->get();
                    @endphp
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>
                            <img src="{{asset("storage/{$product->image}")}}" id="{{$product->id}}" class="card-img-top" alt="{{$product->image}}" height="70px" width="35px">
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td class="text-center" style="white-space: nowrap;">{{$product->quantity}}</td>
                        <td>
                            @if($categoryAssociate->isEmpty())
                                Sem categoria
                            @else
                                {{$categoryAssociate->pluck('name')->join(', ')}}
                            @endif
                        </td>
                        <td class="text-center" style="white-space: nowrap;">R$ {{number_format($product->price, 2, ",", ".")}}</td>
                        @if($product->discount)
                            <td class="text-center" style="white-space: nowrap;" style="color: red;">R$ {{number_format($product->discount, 2, ",", ".")}}</td>
                        @else
                            <td class="text-center" style="white-space: nowrap;">SEM DESCONTO</td>
                        @endif
                        <td class="text-center" style="white-space: nowrap;">R$ {{number_format($product->total, 2, ",", ".")}}</td>

                        <td class="text-center"><a href="{{route('product-edit', $product)}}"><i class="bi bi-eye-fill"></i></a></td>
                        <td class="text-center">
                            <form action="{{route('product-delete', $product)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const message = document.getElementById('message');
            if (message) {
                setTimeout(function () {
                    message.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection

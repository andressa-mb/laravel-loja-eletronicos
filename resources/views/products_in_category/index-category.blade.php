@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{route('index-buyer')}}" class="my-5 btn btn-info">{{__('messages.voltar')}}</a>
        </div>
        <div class="table-responsive-md m-auto col-6">
            <div>
                {{ $categories->links() }}
            </div>
            @foreach ($categories as $category)
                <div class="col-12">
                    <h3 class="text-center mt-4" id="{{$category->id}}">{{$category->name}}</h3>
                </div>
                <table class="table border border-black">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.nome')}}</th>
                        <th scope="col">{{__('messages.descricao')}}</th>
                        <th scope="col" style="white-space: nowrap;">{{__('messages.quantidade_estoque')}}</th>
                        <th scope="col" style="white-space: nowrap;">{{__('messages.valor_total')}}</th>
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

        <div class="table-responsive-md col-6">
            <div class="col-12">
                <h3 class="text-center mt-4">{{__('messages.prod_sem_cat')}}</h3>
            </div>
            <table class="table border border-black">
                <thead class="table-dark">
                <tr>
                    <th scope="col">{{__('messages.id')}}</th>
                    <th scope="col">{{__('messages.nome')}}</th>
                    <th scope="col">{{__('messages.descricao')}}</th>
                    <th scope="col" style="white-space: nowrap;">{{__('messages.quantidade_estoque')}}</th>
                    <th scope="col" style="white-space: nowrap;">{{__('messages.valor_total')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="table table-striped">
                    @foreach (App\Models\Product::withoutCategory() as $product)
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

        <div class="col-12">
            <a href="{{route('index-buyer')}}" class="my-5 btn btn-info">{{__('messages.voltar')}}</a>
        </div>

    </div>
@endsection

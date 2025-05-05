@extends('layouts.app')
@section('content')
    <div class="">
        <div class="m-4">
            <div id="menu-adicionar">
                <div class="d-flex align-items-center justify-content-around mt-5">
                    <h3>Cadastrar novo produto</h3>
                    <a href="{{route('product-create')}}">ADD</a>
                </div>
                <div class="d-flex align-items-center justify-content-around mt-5">
                    <h3>Cadastrar nova categoria</h3>
                    <a href="{{route('category-create')}}">ADD</a>
                </div>
            </div>

            <div id="menu-erros-sucessos" class="d-flex align-items-center justify-content-around mt-5">
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

            <div id="menu-listas" class="d-flex flex-column-2 justify-content-around mt-5">
                <div id="categories" class="">
                    <h3>Lista de categorias</h3>
                    @foreach (\App\Models\Category::get() as $category)
                        <ul class="list-group">
                            <li class="d-flex justify-content-around list-group-item">{{$category->name}}
                                <a href="{{route('products-associates', $category)}}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{route('category-edit', $category->id)}}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{route('category-delete', $category->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endforeach
                </div>
                <div id="products" class="">
                    <h3>Lista de produtos</h3>
                    @foreach (\App\Models\Product::get() as $product)
                        <ul class="list-group">
                            <li class="d-flex justify-content-around list-group-item">
                                {{$product->name}} -
                                @if($product->discount)
                                    <p style="color:red;">COM DESCONTO- </p>
                                @endif
                                R$ {{$product->total}}
                                <a href="{{route('view-product', $product->slug)}}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{route('product-edit', $product->slug)}}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{route('product-delete', $product->slug)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endforeach
                    <a href="{{route('index-buyer')}}" class="mt-4 btn btn-success">Lista de produtos</a>
                </div>
            </div>
        </div>
    </div>
@endsection

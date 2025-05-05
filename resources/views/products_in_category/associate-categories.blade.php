@extends('layouts.app')
@section('content')
    <div class="mt-5">
        <h3 class="mb-5">Qual categoria para o produto cadastrado?</h3>
        <form action="{{route('relation-category-post', $product)}}" method="post" class="content m-auto w-50">
            @csrf
            <div class="form-group">
                <label for="product" class="form-label">Produto:</label>
                <input class="form-control" type="text" value="{{$product->name}}" disabled>
            </div>
            <div class="form-group">
                @php
                    $categories_ids = $product->categoriesIds();
                    $categories = App\Models\Category::get();
                @endphp
                @foreach ($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$category->id}}" name="categories[]" id="category--{{$category->id}}"
                        @if(in_array($category->id, $categories_ids))
                            checked
                        @endif
                        >
                        <label class="form-check-label" for="category--{{$category->id}}">
                            {{$category->name}}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Enviar</button>
        </form>
    </div>

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
@endsection

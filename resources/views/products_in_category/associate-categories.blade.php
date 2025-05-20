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

    <div class="row justify-content-center form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Qual categoria para o produto cadastrado?</h3>
        <form action="{{route('relation-category-post', $product)}}" method="post" class="mb-5 w-50 form-create">
            @csrf
            <div class="form-group">
                <label for="product" class="font-form">Produto:</label>
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
                        <label class="form-check-label font-form" for="category--{{$category->id}}">
                            {{$category->name}}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Enviar</button>
        </form>
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

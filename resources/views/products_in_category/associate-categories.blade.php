@extends('layouts.app')

<div class="mt-5">
    <h3 class="mb-5">Qual categoria para o produto cadastrado?</h3>
    <form action="{{route('relation-category-post', $product)}}" method="post" class="content m-auto w-50">
        @csrf
        <div class="form-group">
            <label for="product" class="form-label">Produto:</label>
            <input class="form-control" type="text" value="{{$product->name}}" disabled>
        </div>
        <div class="form-group">
            <label for="categories" class="form-label">Categorias:</label>
            <select name="category_id" id="categories" class="form-select">
                @foreach (App\Models\Category::get() as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

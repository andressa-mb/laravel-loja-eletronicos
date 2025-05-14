@extends('layouts.app')
@section('content')

<div>
    <table class="table border border-black">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Categoria</th>
                <th scope="col" class="text-center">Editar</th>
                <th scope="col" class="text-center">Excluir</th>
            </tr>
        </thead>
        <tbody class="table table-striped">
            @foreach (App\Models\Category::get() as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{$category->name}}</td>
                    <td class="text-center"><a href="{{route('category-edit', $category->id)}}"><i class="bi bi-eye-fill"></i></a></td>
                    <td>
                        <form class="text-center" action="{{route('category-delete', $category->id)}}" method="POST">
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
</div>
@endsection

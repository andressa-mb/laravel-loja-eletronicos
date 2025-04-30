@extends('layouts.app')
@section('content')

    <div class="mt-5">
        <h3>Alteração dos dados:</h3>
        <form action="{{route('category-update', $category)}}" method="POST" class="content m-auto w-50">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$category->name}}">
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a type="button" class="btn btn-primary" href="{{route('welcome')}}">Voltar</a>
        </form>

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

    <script>
        var foco = document.getElementById('name');
        foco.focus();
    </script>
@endsection

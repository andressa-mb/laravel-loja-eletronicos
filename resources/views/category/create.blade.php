@extends('layouts.app')
@section('content')

    <div class="mt-5">
        <h3>Cadastro de categorias</h3>
        <form action="{{route('category-store')}}" method="POST" class="content m-auto w-50">
            @csrf
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">Voltar</a>
        </form>

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

    <script>
        var foco = document.getElementById('name');
        foco.focus();
    </script>
@endsection

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

    <div class="row form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Cadastro de categorias</h3>
        <form action="{{route('category-store')}}" method="POST" class="m-auto w-50 form-create">
            @csrf
            <div class="form-group">
                <label for="name" class="font-form">Nome:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success mr-3">Cadastrar</button>
                <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">Voltar</a>
            </div>
        </form>
    </div>

    <script>
        var foco = document.getElementById('name');
        foco.focus();

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

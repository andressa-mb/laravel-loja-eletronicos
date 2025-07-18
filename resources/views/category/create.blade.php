@extends('layouts.app')
@section('content')
    <div class="row">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.cadastro_categorias')}}</h3>
        <form action="{{route('category-store')}}" method="POST" class="m-auto w-50 form-create">
            @csrf
            <div class="form-group">
                <label for="name" class="font-form">{{__('messages.nome')}}:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success mr-3">{{__('messages.cadastrar')}}</button>
                <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">{{__('messages.voltar')}}</a>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="row form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.alteracao_dados')}}:</h3>
        <form action="{{route('category-update', $category)}}" method="POST" class="m-auto w-50 form-create">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name" class="font-form">{{__('messages.nome')}}:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$category->name}}">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">{{__('messages.salvar')}}</button>
                <a type="button" class="btn btn-primary" href="{{route('index-adm')}}">{{__('messages.voltar')}}</a>
            </div>
        </form>
    </div>
@endsection

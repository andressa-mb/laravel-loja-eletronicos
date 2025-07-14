@extends('layouts.app')
@section('content')
    <div class="row form-create-bg">
        <h3 class="col-12 p-2 text-center bg-dark text-white rounded">Alteração dos dados:</h3>
        <form action="{{route('update-user', $user)}}" method="POST" class="m-auto w-50 form-create">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" id="id" name="id" class="form-control" value="{{$user->id}}" hidden>
                <label for="name" class="font-form">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label for="email" class="font-form">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{$user->email}}">
            </div>
            <div class="form-group">
                <label class="font-form">Alterar permissões:</label>
                <div class="d-flex flex-column">
                    @foreach (App\Models\Role::get() as $role)
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="role" value="{{$role->id}}" id="role-{{$role->id}}"
                            {{$user->roles->contains($role->id) ? 'checked': ''}}
                            >
                            <label class="form-check-label" for="role-{{$role->id}}">
                                {{$role->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-success">Salvar</button>
                <a type="button" class="btn btn-primary" href="{{route('users-list')}}">Voltar</a>
            </div>
        </form>
    </div>
@endsection

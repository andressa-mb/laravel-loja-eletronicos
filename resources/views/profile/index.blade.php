@extends('layouts.app')
@section('content')
{{-- A PENSAR O QUE FAZER E COMO FAZER
POR ENQUANTO É UM FORM PARA ATUALIZAÇÃO DOS DADOS DO USUÁRIO E
SENDO ADM PODE TER UM BOTÃO PARA MOSTRAR OS USUÁRIOS E TROCAR SUAS ROLES
 --}}
    @php
        $admin = $user->roles()->adminRole()->first();
        $buyer = $user->roles()->buyer()->first();
    @endphp

    <form>
        <div class="form-group">
          <label for="name">{{__('messages.nome')}}:</label>
          <input type="text" class="form-control" id="name" value="{{$user->name}}">
        </div>
        <div class="form-group">
          <label for="email">{{__('messages.email')}}:</label>
          <input type="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{$user->email}}">
          <small id="emailHelp" class="form-text text-muted">{{__('messages.msg_nao_compartilhe_email')}}</small>
        </div>
        <div class="form-group">
            <label for="role">{{__('messages.tipo_usuario')}}:</label>
            @if($admin)
                <input type="text" class="form-control" id="role" value="{{$admin->title}}" disabled>
            @elseif ($buyer)
                <input type="text" class="form-control" id="role" value="{{$buyer->title}}" disabled>
            @endif
          </div>
        <button type="submit" class="btn btn-primary">{{__('messages.atualizar')}}</button>
    </form>

@endsection

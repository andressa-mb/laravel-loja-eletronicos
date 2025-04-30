@extends('layouts.app')
@section('content')

    <form>
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" class="form-control" id="name" value="{{$user->name}}">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{$user->email}}">
          <small id="emailHelp" class="form-text text-muted">Nunca compartilhe seu e-mail.</small>
        </div>

@php
  $admin = $user->roles()->adminRole()->first();
  $buyer = $user->roles()->buyer()->first();
@endphp

        <div class="form-group">
            <label for="role">Tipo de usuário:</label>
            @if($admin)
                <input type="text" class="form-control" id="role" value="{{$admin->title}}" disabled>
            @elseif ($buyer)
                <input type="text" class="form-control" id="role" value="{{$buyer->title}}" disabled>
            @endif
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection

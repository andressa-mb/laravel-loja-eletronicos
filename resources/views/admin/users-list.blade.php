@extends('layouts.app')
@section('content')
    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">{{__('messages.lista_usuarios_sistema')}}</h1>
    </div>
    <div class="row">
        <table class="table table-hover col-12">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">{{__('messages.nome')}}</th>
                    <th scope="col">{{__('messages.email')}}</th>
                    <th scope="col">{{__('messages.tipo_usuario')}}</th>
                    <th scope="col">{{__('messages.inscrito_desde')}}</th>
                    <th>{{__('messages.acoes')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="text-center">
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @if ($user->isAdmin())
                        <td>{{__('messages.administrador')}}</td>
                    @else
                        <td>{{__('messages.comprador')}}</td>
                    @endif
                    <td>{{$user->created_at->format('d/m/y')}}</td>
                    <td class="row">
                        <a href="{{route('edit-user', $user)}}" class="m-1 btn btn-outline-primary btn-sm col-5">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <button class="m-1 btn btn-outline-primary btn-sm col-5"
                          data-toggle="modal"
                          data-target="#deleteModal"
                          data-id="{{$user->id}}"
                          data-name="{{$user->name}}"
                          data-route="{{route('delete-user', $user->id)}}"
                        >
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MODAL DE EXCLUSÃO DE USUÁRIO --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myDeleteLabel">{{__('messages.confirmar_exclusao')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>{{__('messages.confirmar_exclusao')}}: <strong id="userName"></strong></p>
                        <p class="text-danger">{{__('messages.msg_acao_desfeita')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('messages.btn_confirmar')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.btn_cancelar')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#deleteModal').on('show.bs.modal' ,function(event){
            var btn = $(event.relatedTarget);
            var userName = btn.data('name');
            var deleteRoute = btn.data('route');
            $('#userName').text(userName);
            $('#deleteForm').attr('action', deleteRoute);
        })
    })
</script>
@endsection

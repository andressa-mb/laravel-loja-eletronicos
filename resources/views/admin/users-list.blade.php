@extends('layouts.app')
@section('content')
    <div class="row">
        <h1 class="col-12 p-2 text-center bg-dark text-white rounded">Lista de usuários cadastrados no sistema</h1>
    </div>
    <div class="row">
        <table class="table table-hover col-12">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Tipo de usuário</th>
                    <th scope="col">Inscrito desde</th>
                    <th>Ações</th>
                    <th>Teste</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="text-center">
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @if ($user->isAdmin())
                        <td>Administrador</td>
                    @else
                        <td>Comprador</td>
                    @endif
                    <td>{{$user->created_at->format('d/m/y')}}</td>
                    <td class="row">
                        <a href="{{route('edit-user', $user)}}" class="col-6">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <form class="text-center col-6" action="" >
                            @csrf
                            <button type="submit" id="btn-trash">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <button id="btn-teste" data-target="#myModal" data-toggle="modal">
                            Teste
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>




    {{-- MODAL --}}
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    TESTE DE MODAL
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>


@endsection
    <script>
        $('#btn-teste').click(function() {

            $('#myModal').modal('show');

        })
    </script>

@extends('layouts.app')
@section('content')
    <div class="row">
        <a href="{{route('discount-create')}}" class="btn btn-success rounded m-4">Novo Desconto</a>
        {{ $discounts->links() }}
        <table class="table border border-black">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data de início</th>
                    <th scope="col">Data final</th>
                    <th scope="col">Mensagem</th>
                    <th scope="col">Data de criação</th>
                    <th scope="col">Editar</th>
                    <th scope="col" style="white-space: nowrap;">Excluir</th>
                </tr>
            </thead>
            <tbody class="table table-striped text-center">
                @foreach ($discounts as $discount)
                    <tr>
                        <th scope="row">{{$discount->id}}</th>
                        <td>{{$discount->type}}</td>
                        <td>{{$discount->discount_value}}</td>
                        <td class="text-center" style="white-space: nowrap;">{{$discount->start_date}}</td>
                        <td class="text-center" style="white-space: nowrap;">{{$discount->end_date}}</td>
                        <td class="text-center" style="white-space: nowrap;">{{$discount->message}}</td>
                        <td class="text-center" style="white-space: nowrap;">{{$discount->created_at->format('d/m/Y')}}</td>
                        <td class="text-center"><a href="{{route('discount-edit', $discount)}}"><i class="bi bi-eye-fill"></i></a></td>
                        <td>
                            <button class="m-1 btn btn-outline-primary btn-sm col-5"
                              data-toggle="modal"
                              data-target="#deleteModal"
                              data-id="{{$discount->id}}"
                              data-name="{{$discount->message}}"
                              data-route="{{route('discount-delete', $discount->id)}}"
                            >
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $discounts->links() }}
    </div>

    {{-- MODAL DE EXCLUSÃO DE DESCONTO --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myDeleteLabel">Confirmar exclusão de desconto:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Confirmar exclusão de desconto: <strong id="messageDisc"></strong></p>
                        <p class="text-danger">Esta ação não pode ser desfeita!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                $('#deleteModal').on('show.bs.modal' ,function(event){
                    var btn = $(event.relatedTarget);
                    var messageDisc = btn.data('name');
                    var deleteRoute = btn.data('route');
                    $('#messageDisc').text(messageDisc);
                    $('#deleteForm').attr('action', deleteRoute);
                })
            })
        </script>
    @endsection
@endsection

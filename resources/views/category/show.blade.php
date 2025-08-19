@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 my-2">
            <a href="{{route('category-create')}}" class="btn btn-success rounded">
                {{__('messages.nova_categoria')}}
            </a>
        </div>
        <div class="col-12 form-h-size">
            <div class="float-right">
                {{ $categories->links() }}
            </div>
            <table class="table border border-black">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.categoria')}}</th>
                        <th scope="col" class="text-center">{{__('messages.editar')}}</th>
                        <th scope="col" class="text-center">{{__('messages.excluir')}}</th>
                    </tr>
                </thead>
                <tbody class="table table-striped">
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{$category->id}}</th>
                            <td>{{$category->name}}</td>
                            <td class="text-center"><a href="{{route('category-edit', $category->id)}}"><i class="bi bi-eye-fill"></i></a></td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-id="{{$category->id}}"
                                data-name="{{$category->name}}"
                                data-route="{{route('category-delete', $category->id)}}"
                                >
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL DE EXCLUSÃO DE CATEGORIA --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="myDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myDeleteLabel">{{__('messages.confirmar_exclusao_cat')}}:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>{{__('messages.confirmar_exclusao_cat')}}: <strong id="categoryName"></strong></p>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            $('#deleteModal').on('show.bs.modal' ,function(event){
                var btn = $(event.relatedTarget);
                var categoryName = btn.data('name');
                var deleteRoute = btn.data('route');
                $('#categoryName').text(categoryName);
                $('#deleteForm').attr('action', deleteRoute);
            })
        })
    </script>
@endpush

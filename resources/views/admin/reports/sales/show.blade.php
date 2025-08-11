@extends('layouts.app')
@section('content')
    {{-- @include('admin.reports.grafics', ['clients' => $clients]) --}}
    <div class="row">
        <div class="col-12 form-h-size">
            {{-- ORDENAR PRODUTOS --}}
            <form class="float-left my-2">
                <div class="d-flex">
                    <label for="sort" class="w-100 mr-2 text-center">Ordenar por:</label>
                    <select class="custom-select custom-select-sm" id="sort" name="sort" onchange="this.form.submit()" required>
                        <option value="" selected></option>
                        <option value="aToZ">{{__('messages.ordem_alfabetica')}}</option>
                        <option value="zToA">{{__('messages.ordem_alfabetica_reversa')}}</option>
                        <option value="smallest_id">{{__('messages.menor_id')}}</option>
                        <option value="largest_id">{{__('messages.maior_id')}}</option>
                        <option value="most_sell">{{__('messages.mais_vendido')}}</option>
                        <option value="less_sell">{{__('messages.menos_vendido')}}</option>
                    </select>
                </div>
            </form>

            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.produto')}}</th>
                        <th scope="col">{{__('messages.quantidade')}}</th>
                        <th scope="col">{{__('messages.total')}}</th>
                        <th scope="col">{{__('messages.data_pedido')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $sell)
                    <tr class="text-center">
                        <th scope="row">{{$sell->id}}</th>
                        <td>{{$sell->product->name}}</td>
                        <td>{{$sell->order_quantity}}</td>
                        <td>{{number_format($sell->order_total, 2, ",", ".")}}</td>
                        <td>{{$sell->order_date->format('d-m-Y')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @section('scripts')
        <script src="https://cdn.plot.ly/plotly-2.14.0.min.js"></script>
        <script>
            let salesData = @json($orderItems);

            //Plotly.newPlot("myPlot", data, layout); */
        </script>
    @endsection
@endsection

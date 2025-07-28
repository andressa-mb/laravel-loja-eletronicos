@extends('layouts.app')
@section('content')
<div class="row">
    <div role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button class="btn btn-sm btn-outline-secondary">Compartilhar</button>
                    <button class="btn btn-sm btn-outline-secondary">Exportar</button>
                </div>
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div id="myPlot" style="width:100%;max-width:700px"></div>
        </div>

        @php
            $orders = App\Models\OrderProductItem::get();
        @endphp
        <h2 class="my-2">Últimos pedidos</h2>
        <div class="table-responsive form-h-size">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Desconto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->product->name}}</td>
                            <td>{{$order->order_quantity}}</td>
                            <td>R$ {{$order->order_price}}</td>
                            <td>{{$order->order_discount_type}} {{$order->order_discount_value}}</td>
                            <td>R$ {{$order->order_total}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- pelo w3 teste --}}
    @section('scripts')
        <script src="https://cdn.plot.ly/plotly-2.14.0.min.js"></script>
        <script>
            let orderData = @json($orders);
            let xOrder = [];
            let yOrder = [];
            let productData = [];
            for (let element of orderData) {
                if(productData.length == 0){
                    productData.push({
                        'product_id': element.product_id,
                        'name': element.product.name,
                        'quantity': element.order_quantity,
                        'count': 1
                    })
                } else{
                    let findProdData = productData.find(item => {
                        return item.product_id == element.product_id;
                    })

                    if(findProdData){
                        findProdData.quantity += element.order_quantity,
                        findProdData.count += 1
                    } else {
                         productData.push({
                            'product_id': element.product_id,
                            'name': element.product.name,
                            'quantity': element.order_quantity,
                            'count': 1
                        })
                    }
                }
            }

            for(let item of productData){
                xOrder.push(item.name);
                yOrder.push(item.quantity);
            }

            const layout = {title:"Itens mais vendidos"};
            const data = [{labels:xOrder, values:yOrder, type:"pie"}];
            Plotly.newPlot("myPlot", data, layout);
        </script>
    @endsection

@endsection

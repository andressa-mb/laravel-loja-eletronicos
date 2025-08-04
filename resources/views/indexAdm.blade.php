@extends('layouts.app')
@section('content')
@include('admin.reports.grafics', ['orders' => App\Models\OrderProductItem::get()])
    <div class="row">
        <div class="col-12 form-h-size">
            @php
                $orders = App\Models\OrderProductItem::get();
            @endphp
            <div class="table-responsive">
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

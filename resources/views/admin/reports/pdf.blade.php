<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Últimos Pedidos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            margin: 50px 10px;
            font-family: 'Lucida Sans', sans-serif;
            font-size: 14px;
        }
        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 5px;
        }
        h3 {
            text-align: center;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #4d4b5f;
            color: white;
            font-weight: bold;
        }
        .table-striped tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        img {
            width: 5rem;
            border-radius: 4px;
        }
        .text-red {
            color: red;
        }
        .text-green {
            color: green;
        }
        .font-bold {
            font-weight: bold;
        }
        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <h1>Últimos pedidos</h1>
    <h3>Data do relatório: {{now()->format('d/m/Y')}}</h3>

    <table class="table-striped">
        <thead>
            <tr>
                <th scope="col">{{__('messages.id')}}</th>
                <th scope="col">{{__('messages.produto')}}</th>
                <th scope="col">{{__('messages.quantidade')}}</th>
                <th scope="col">{{__('messages.preco')}}</th>
                <th scope="col">{{__('messages.desconto')}}</th>
                <th scope="col">{{__('messages.total')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th scope="row">{{$order->id}}</th>
                    <td>
                        {{$order->product->name}}
                    </td>
                    <td>{{$order->order_quantity}}</td>
                    <td>
                        R$ {{number_format($order->order_price, 2, ",", ".")}}
                    </td>
                    <td>
                        @if($order->order_discount_type == null)
                            <p class="text-red">Sem desconto</p>
                        @else
                            <p class="text-green">{{$order->order_discount_type}} {{$order->order_discount_value}}</p>
                        @endif
                    </td>

                    <td>R$ {{number_format($order->order_total, 2, ",", ".")}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

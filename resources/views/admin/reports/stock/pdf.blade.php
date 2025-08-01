<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Produtos em estoque</title>
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
            background-color: #333;
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
    <h1>Produtos em estoque</h1>
    <h3>Data do relatório: {{now()->format('d/m/Y')}}</h3>

    <table class="table-striped">
        <thead>
            <tr>
                <th scope="col">{{__('messages.id')}}</th>
                <th scope="col">{{__('messages.imagem')}}</th>
                <th scope="col">{{__('messages.nome')}}</th>
                <th scope="col">{{__('messages.categoria')}}</th>
                <th scope="col">{{__('messages.quantidade')}}</th>
                <th scope="col">{{__('messages.preco')}}</th>
                <th colspan="2" scope="col">{{__('messages.desconto')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                @php
                    $categoryAssociate = $product->categories()->get();
                @endphp
                <tr>
                    <th scope="row">{{$product->id}}</th>
                    <td>
                        <img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path("storage/{$product->image}"))) }}" id="{{$product->id}}" alt="{{$product->image}}">
                    </td>
                    <td>{{$product->name}}</td>
                    <td>
                        @if($categoryAssociate->isEmpty())
                            {{__('messages.sem_categoria')}}
                        @else
                            {{$categoryAssociate->pluck('name')->join(', ')}}
                        @endif
                    </td>
                    <td class="nowrap">{{$product->quantity}}</td>
                    <td class="nowrap">R$ {{number_format($product->price, 2, ",", ".")}}</td>

                    @if($product->hasDiscount)
                        @foreach ($product->discounts as $discount)
                            <td class="nowrap text-red">{{$discount->type}} {{$discount->discount_value}}</td>
                            @if($discount->end_date_input < now())
                                <td class="nowrap text-red font-bold">Vencido: {{$discount->end_date}}</td>
                            @else
                                <td class="nowrap text-green font-bold">
                                    <p>{{__('messages.inicia_em')}}: {{$discount->start_date}}</p>
                                    <p>{{__('messages.valido_ate')}}: {{$discount->end_date}}</p>
                                </td>
                            @endif
                        @endforeach
                    @else
                        <td class="nowrap font-bold">{{__('messages.sem_desconto')}} {{$product->hasDiscount}}</td>
                        <td class="nowrap">{{__('messages.nao_aplica')}}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

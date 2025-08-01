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
    <h1>Lista de Clientes</h1>
    <h3>Data do relatório: {{now()->format('d/m/Y')}}</h3>

    <table class="table-striped">
        <thead>
            <tr>
                <th scope="col">{{__('messages.id')}}</th>
                <th scope="col">{{__('messages.nome')}}</th>
                <th scope="col">{{__('messages.email')}}</th>
                <th scope="col">{{__('messages.tipo_usuario')}}</th>
                <th scope="col">{{__('messages.inscrito_desde')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <th scope="row">{{$client->id}}</th>
                    <td>{{$client->name}}</td>
                    <td>{{$client->email}}</td>
                    <td>
                        @if($client->isAdmin())
                            {{__('messages.admnistrador')}}
                        @else
                            {{__('messages.comprador')}}
                        @endif
                    </td>
                    <td>{{$client->created_at->format('d/m/Y')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

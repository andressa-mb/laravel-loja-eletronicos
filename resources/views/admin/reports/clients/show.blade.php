@extends('layouts.app')
@section('content')
    @include('admin.reports.grafics', ['clients' => $clients])
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
                        <option value="newest">{{__('messages.mais_novo_usuario')}}</option>
                        <option value="oldest">{{__('messages.mais_antigo_usuario')}}</option>
                    </select>
                </div>
            </form>

            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.nome')}}</th>
                        <th scope="col">{{__('messages.email')}}</th>
                        <th scope="col">{{__('messages.tipo_usuario')}}</th>
                        <th scope="col">{{__('messages.inscrito_desde')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $user)
                    <tr class="text-center">
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        @if ($user->isAdmin())
                            <td>{{__('messages.admnistrador')}}</td>
                        @else
                            <td>{{__('messages.comprador')}}</td>
                        @endif
                        <td>{{$user->created_at->format('d/m/y')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.plot.ly/plotly-2.14.0.min.js"></script>
    <script>
        let clients = @json($clients);
        let months = [
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
        ]

        //Iniciando o objeto
        let monthData = months.map(month => {
            return {
                month: month,
                count: 0,
                clientNames: []
            };
        });


        clients.forEach(client => {
            //id do mês
            const monthIndex = new Date(client.created_at).getMonth();

            monthData[monthIndex].count++;
            monthData[monthIndex].clientNames.push(client.name);
        })

        console.log('meses ', months);
        console.log('obj criado ', monthData);

        //Dados do gráfico
        let xValues = monthData.map(data => data.month);
        let yValues = monthData.map(data => data.count);
        let hoverText = monthData.map(data =>
            data.count > 0
                ? `<b>${data.count} cliente(s)</b><br>${data.clientNames.join('<br>')}`
                : 'Nenhum cliente'
        );

        const data = [{
            x: xValues,
            y: yValues,
            type: 'bar',
            text: yValues.map(count => count > 0 ? count : ''),
            textposition: 'auto',
            hoverinfo: 'text',
            hovertext: hoverText,
            marker: {
                color: yValues.map(count =>
                    count > 0 ? 'rgba(55, 128, 191, 0.7)' : 'rgba(200, 200, 200, 0.2)'
                ),
                line: {
                    color: 'rgba(55, 128, 191, 1.0)',
                    width: 1
                }
            }
        }];

        const layout = {
            title: 'Clientes Cadastrados em 2025',
            xaxis: {
                title: 'Mês',
                tickangle: -45
            },
            yaxis: {
                title: 'Quantidade de Clientes'
            },
            bargap: 0.1,
            hovermode: 'closest'
        };

        Plotly.newPlot("myPlot", data, layout);
    </script>
@endpush

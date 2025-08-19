@extends('layouts.app')
@section('content')
    @include('admin.reports.grafics', ['products' => $products])
    <div class="row">
        <div class="col-12 my-2">
            <a href="{{route('product-create')}}" class="btn btn-success rounded">
                {{__('messages.novo_produto')}}
            </a>
        </div>
        <div class="col-12 form-h-size">
            {{-- ORDENAR PRODUTOS --}}
            <form class="float-left my-2">
                <div class="d-flex">
                    <label for="sort" class="w-100 mr-2 text-center">Ordenar por:</label>
                    <select class="custom-select custom-select-sm" id="sort" name="sort" onchange="this.form.submit()" required>
                        <option value="" selected></option>
                        <option value="smallest_qty">{{__('messages.menor_qtd')}}</option>
                        <option value="largest_qty">{{__('messages.maior_qtd')}}</option>
                        <option value="aToZ">{{__('messages.ordem_alfabetica')}}</option>
                        <option value="zToA">{{__('messages.ordem_alfabetica_reversa')}}</option>
                        <option value="smallest_id">{{__('messages.menor_id')}}</option>
                        <option value="largest_id">{{__('messages.maior_id')}}</option>
                    </select>
                </div>
            </form>

            <div class="float-right">
                {{ $products->links() }}
            </div>

            <table class="w-100 table border border-black">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th scope="col">{{__('messages.id')}}</th>
                        <th scope="col">{{__('messages.imagem')}}</th>
                        <th scope="col">{{__('messages.nome')}}</th>
                        <th scope="col">{{__('messages.categoria')}}</th>
                        <th scope="col">{{__('messages.quantidade')}}</th>
                        <th scope="col">{{__('messages.preco')}}</th>
                        <th colspan="2" scope="col">{{__('messages.desconto')}}</th>
                    </tr>
                </thead>
                <tbody class="table table-striped">
                    @foreach ($products as $product)
                        @php
                            $categoryAssociate = $product->categories()->get();
                        @endphp
                        <tr class="text-center">
                            <th scope="row">{{$product->id}}</th>
                            <td>
                                <img src="{{asset("storage/{$product->image}")}}" id="{{$product->id}}" class="card-img-top rounded" alt="{{$product->image}}" style="width: 5rem;">
                            </td>
                            <td>{{$product->name}}</td>
                            <td>
                                @if($categoryAssociate->isEmpty())
                                    {{__('messages.sem_categoria')}}
                                @else
                                    {{$categoryAssociate->pluck('name')->join(', ')}}
                                @endif
                            </td>
                            <td class="text-center" style="white-space: nowrap;">{{$product->quantity}}</td>
                            <td class="text-center" style="white-space: nowrap;">R$ {{number_format($product->price, 2, ",", ".")}}</td>


                            @if($product->hasDiscount)
                                @foreach ($product->discounts as $discount)
                                    <td class="text-center" style="white-space: nowrap; color: red;">{{$discount->type}} {{$discount->discount_value}}</td>
                                    @if($discount->end_date_input < now())
                                        <td class="text-center" style="white-space: nowrap; color: red;">Vencido: {{$discount->end_date}}</td>
                                    @else
                                        <td class="text-center" style="white-space: nowrap; color: green; font-weight: bold;">
                                            <p>{{__('messages.inicia_em')}}: {{$discount->start_date}}</p>
                                            <p>{{__('messages.valido_ate')}}: {{$discount->end_date}}</p>
                                        </td>
                                    @endif
                                @endforeach
                            @else
                                <td class="text-center" style="white-space: nowrap; font-weight: bold;">{{__('messages.sem_desconto')}} {{$product->hasDiscount}}</td>
                                <td class="text-center">{{__('messages.nao_aplica')}}</td>
                            @endif

                        </tr>

                    @endforeach
                </tbody>
            </table>

            <div class="float-right h-25">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.plot.ly/plotly-2.14.0.min.js"></script>
    <script>
        let prods = @json($allProducts);
        console.log(prods);
        let xProdNames = [];
        let yProdQts = [];
        for(let prod of prods){
            xProdNames.push(prod.name);
            yProdQts.push(prod.quantity);
        }

        const layout = {title:"Itens em estoque"};
        const data = [{labels:xProdNames, values:yProdQts, type:"pie"}];
        Plotly.newPlot("myPlot", data, layout);
    </script>
@endpush

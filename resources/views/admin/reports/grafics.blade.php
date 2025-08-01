<div class="row">
    <div role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            @isset($clients)
                <h1 class="h2">Clientes</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="{{route('pdf-list', 'pdf_client')}}" class="btn btn-sm btn-outline-secondary">Exportar PDF</a>
                    </div>
                </div>
            @endisset

            @isset($products)
                <h1 class="h2">Estoque</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="{{route('pdf-list', 'pdf_stock')}}" class="btn btn-sm btn-outline-secondary">Exportar PDF</a>
                    </div>
                </div>
            @endisset
        </div>

        <div class="d-flex justify-content-center">
            <div id="myPlot" style="width:100%;max-width:700px"></div>
        </div>
    </div>
</div>

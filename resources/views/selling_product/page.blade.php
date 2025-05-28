<div class="card m-4 col" style="width: 18rem;">
    <div class="card-header">
        <input type="hidden" name="products[{{$index}}][product_id]" value="{{$product['product_id']}}">
        <input type="text" class="form-control-plaintext text-center font-weight-bold" name="products[{{$index}}][name]" readonly value="Nome: {{$product['name']}}">
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="products[{{$index}}][quantity]" readonly value="Quantidade: {{$product['quantity']}}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="products[{{$index}}][price]" readonly value="Preço: {{number_format($product['price'], 2, ',', '.')}}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="products[{{$index}}][discount]" readonly value="Desconto: {{number_format((double)$product['discount'], 2, ',', '.')}}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="products[{{$index}}][total]" readonly value="Total: {{number_format($product['total'], 2, ',', '.')}}">
        </li>
    </ul>
</div>

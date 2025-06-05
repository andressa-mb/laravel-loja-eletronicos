<div class="card m-4 col" style="width: 18rem;">
    <div class="card-header">
        <input type="hidden" name="product[{{$index}}][id]" value="{{$product['product_id'] ?? $product['id']}}">
        <input type="text" class="form-control-plaintext text-center font-weight-bold" name="product[{{$index}}][name]" readonly value="Nome: {{$product['name']}}">
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="product[{{$index}}][quantity]" readonly value="Quantidade: {{$product['quantity']}}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="product[{{$index}}][price]" readonly value="Preço: {{number_format($product['price'], 2, ',', '.')}}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="product[{{$index}}][discount]" readonly value="Desconto: {{number_format((double)$product['discount'], 2, ',', '.')}}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="product[{{$index}}][total]" readonly value="Total: {{number_format($product['total'], 2, ',', '.')}}">
        </li>
    </ul>
</div>

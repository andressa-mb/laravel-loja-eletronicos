<div class="card m-4 col product-container" style="width: 18rem;" data-index ="{{$index}}">
    <div class="card-header">
        <input type="hidden" name="product[{{$index}}][id]" value="{{$product['product_id'] ?? $product['id']}}">
        <input type="text" class="form-control-plaintext text-center font-weight-bold" name="product[{{$index}}][name]" readonly value="Nome: {{$product['name']}}">
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="product[{{$index}}][quantity]" readonly value="Quantidade: {{$product['quantity']}}" id="quantity_{{ $index }}">
        </li>
        <li class="list-group-item">
            <input type="text" class="form-control-plaintext" name="product[{{$index}}][price]" readonly value="Preço: {{number_format($product['price'], 2, ',', '.')}}" id="price_{{ $index }}">
        </li>
        @php
            $productModel = App\Models\Product::find($product['product_id'] ?? $product['id']);
        @endphp
        @if ($productModel->hasDiscount && $productModel->isDiscountActive())
            <li class="list-group-item">
                <p class="text-danger">
                    <span>Desconto:</span>
                    <span id="discount_type_{{ $index }}">{{$productModel->discount_data->type}}</span>
                    <span id="discount_value_{{ $index }}">{{$productModel->discount_data->discount_value}}</span>
                </p>
                <input type="hidden" name="product[{{$index}}][hasDiscount]" value="{{$product['hasDiscount']}}">
            </li>
            <li class="list-group-item">
                <input type="text" class="form-control-plaintext" name="product[{{$index}}][total]" readonly value="" id="total_{{ $index }}">
            </li>
        @else
            <li class="list-group-item">
                <p class="text-danger">{{__('messages.sem_desconto')}}</p>
                <input type="hidden" name="product[{{$index}}][hasDiscount]" value="{{$product['hasDiscount']}}">
            </li>
            <li class="list-group-item">
                <input type="text" class="form-control-plaintext" name="product[{{$index}}][total]" readonly value="" id="total_{{ $index }}">
            </li>
        @endif
    </ul>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.product-container').forEach(container => {
                const index = container.getAttribute('data-index');
                let qtdElement = document.getElementById(`quantity_${index}`);
                let priceElement = document.getElementById(`price_${index}`);
                let totalElement = document.getElementById(`total_${index}`);
                let discountValueElement = document.getElementById(`discount_value_${index}`);
                let discountTypeElement = document.getElementById(`discount_type_${index}`);

                function calculateTotal(){
                    let quantity = parseInt(qtdElement.value.replace("Quantidade: ", "")) || 1;
                    let price = parseFloat(priceElement.value.replace("Preço: ", "").replace('.', '').replace(',', '.').trim());
                    let total = price;

                    if (discountTypeElement && discountValueElement) {
                        const discountType = discountTypeElement.textContent.trim();
                        const discountValue = parseFloat(discountValueElement.textContent.trim());

                        if (discountType == '%') {
                            total = price - (price * (discountValue / 100));
                        } else if (discountType == 'R$') {
                            total = price - discountValue;
                        }
                    }

                    total = total * quantity;

                    totalElement.value = "Total: " + total.toLocaleString("pt-BR", {
                        style: "currency",
                        currency: "BRL"
                    });
                }

                calculateTotal();

                qtdElement.addEventListener('input', calculateTotal);
            })
        })
    </script>
@endpush

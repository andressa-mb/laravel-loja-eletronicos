<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use App\Services\Product\ProductService;
use Throwable;

class ProductController extends Controller
{
    public function create(){
        $this->authorize('create', Product::class);
        return view('product.create');
    }

    public function store(ProductStoreRequest $request, ProductService $service){
        try{
            //validates, redirecionamentos e chamadas de model
            $validation = $request->validated(); //array com os dados do form
            $discountId = $request->hasDiscount ? $request->discount_values : null;
            $newProduct = $service->storeProduct($validation, $discountId);

            return redirect()->route('category-associate-to-product', ['product' => $newProduct]);
        }catch(Throwable $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Product $product){
        $this->authorize('update', $product);
        return view('product.edit', ['product' => $product]);
    }

    public function update(ProductUpdateRequest $request, Product $product, ProductService $service){
        try{
            $validation = $request->validated();
            $discountId = $request->hasDiscount ? $request->discount_values : null;
            $updatedProduct = $service->updateProduct($product, $validation, $discountId);

            return redirect()->route('category-associate-to-product', ['product' => $updatedProduct->slug])->with('message', 'Produto atualizado com sucesso.');
        }catch(Throwable $e){
            return back()->withErrors('Erro ao atualizar o produto. ' . $e->getMessage());
        }
    }

    public function show(){
        $this->authorize('view', Product::class);
        $products = Product::paginate(6);
        return view('product.show', ['products' => $products]);
    }

    public function destroy(Product $product){
        $this->authorize('delete', $product);
        $product->findOrFail($product->id)->delete();
        return redirect()->route('product-show')->with('message', 'Produto excluído com sucesso.');
    }
}

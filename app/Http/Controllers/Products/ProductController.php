<?php

namespace App\Http\Controllers\Products;

use App\Events\ProductsUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Discount;
use App\Services\Product\ProductService;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function create(){
        $this->authorize('create', Product::class);
        return view('product.create');
    }

    public function store(ProductStoreRequest $reqStore, ProductService $service){
        try{
            //validates, redirecionamentos e chamadas de model
            $validation = $reqStore->validated(); //array com os dados do form
            $discountId = $reqStore->hasDiscount ? $reqStore->discount_values : null;
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

    public function update(ProductUpdateRequest $request, Product $product){
        try{
            $validation = $request->validated();
            $formProduct = [
                'name' => $validation['name'],
                'slug' => Str::slug($validation['name']),
                'description' => $validation['description'],
                'price' => $validation['price'],
                'quantity' => $validation['quantity'],
                'hasDiscount' => $validation['hasDiscount'],
                'total' => 0,
            ];

            if($request->hasFile('image')){
                $formProduct['image'] = $product->configImage($product, "product_images", $validation['image']);
            }

            /* ASSOCIAR AO DESCONTO */
            if($request->hasDiscount == 1 && $request->filled('discount_values')){
                $valueDiscount = Discount::find($request->discount_values);
                if($valueDiscount){
                    $product->discounts()->sync([$valueDiscount->id]);
                }
                //evento aqui pois algum produto foi atualizado com desconto
                event(new ProductsUpdated($product, false));
            }else {
                $product->discounts()->detach();
            }

            $product->update($formProduct);

            return redirect()->route('category-associate-to-product', ['product' => $product->slug])->with('message', 'Produto atualizado com sucesso.');
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

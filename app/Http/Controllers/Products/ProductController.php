<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function create(){
        $this->authorize('create', Product::class);
        return view('product.create');
    }

    public function store(ProductStoreRequest $reqStore, Product $product){
        try{
            $validation = $reqStore->validated();
            $createProduct = [
                'name' => $validation['name'],
                'slug' => Str::slug($validation['name']),
                'description' => $validation['description'],
                'price' => $validation['price'],
                'quantity' => $validation['quantity'],
                'hasDiscount' => $validation['hasDiscount'],
                'total' => 0
            ];
            //TIREI O ID DO CAMINHO POIS AINDA NÃO EXISTIA, PENSAR EM QUAL CAMINHO POSSO DEIXAR DEPOIS DISSO
            if($reqStore->hasFile('image')){
                $createProduct['image'] = $product->configImage($product, "product_images", $validation['image']);
            }
            $createdProduct = $product->create($createProduct);
            /* ASSOCIAR AO DESCONTO */
            if($reqStore->hasDiscount == 1){
                $discount = Discount::find($reqStore->discount_values);
                $createdProduct->discounts()->attach($discount->id);
            }

            return redirect()->route('category-associate-to-product', ['product' => $createdProduct]);
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

            $product->update($formProduct);

            /* ASSOCIAR AO DESCONTO */
            if($request->hasDiscount == 1 && $request->filled('discount_values')){
                $discount = Discount::find($request->discount_values);
                var_dump($discount);
                if($discount){
                    $product->discounts()->sync([$discount->id]);
                }
            }else {
                $product->discounts()->detach();
            }

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

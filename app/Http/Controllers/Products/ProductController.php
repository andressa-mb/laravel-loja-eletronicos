<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Jobs\Product\NewProductAlert;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'discount' => $validation['discount'],
                'total' => $validation['price'] - $validation['discount']
            ];
            //TIREI O ID DO CAMINHO POIS AINDA NÃO EXISTIA, PENSAR EM QUAL CAMINHO POSSO DEIXAR DEPOIS DISSO
            if($reqStore->hasFile('image')){
                $createProduct['image'] = $product->configImage($product, "product_images", $validation['image']);
            }

            $createdProduct = $product->create($createProduct);
           // NewProductAlert::dispatch($createdProduct, Auth::user());
            return redirect()->route('category-associate-to-product', ['product' => $createdProduct]);
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Product $product){
        $this->authorize('update', $product);
        return view('product.edit', ['product' => $product]);
    }

    public function update(ProductUpdateRequest $request, Product $product){
        $validation = $request->validated();
        $formProduct = [
            'name' => $validation['name'],
            'slug' => Str::slug($validation['name']),
            'description' => $validation['description'],
            'price' => $validation['price'],
            'quantity' => $validation['quantity'],
            'discount' => $validation['discount'],
            'total' => $validation['price'] - $validation['discount'],
        ];

        if($request->hasFile('image')){
            $formProduct['image'] = $product->configImage($product, "product_images", $validation['image']);
        }

        $product->update($formProduct);
        return redirect()->route('category-associate-to-product', ['product' => $product->slug])->with('message', 'Produto atualizado com sucesso.');
    }

    public function show(){
        $products = Product::paginate(6);
        return view('product.show', ['products' => $products]);
    }

    public function destroy(Product $product){
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('index-adm')->with('message', 'Produto excluído com sucesso.');
    }
}

<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function index(){
        $products = Product::get();
        return view('welcome', ['products' => $products]);
    }

    public function create(){
        return view('product.create');
    }

    public function store(ProductStoreRequest $reqStore, Product $product){
        try{
            $validation = $reqStore->validated();
            $created = $product->create([
                'name' => $validation['name'],
                'slug' => Str::slug($validation['name']),
                'description' => $validation['description'],
                'price' => $validation['price'],
                'quantity' => $validation['quantity'],
                'discount' => $validation['discount'],
                'total' => $validation['price'] - $validation['discount'],
                'image' => $validation['image'],
            ]);

            return redirect()->route('category-associate-to-product', ['product' => $created]);
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Product $product){
        return view('product.edit', ['product' => $product]);
    }

    public function update(ProductUpdateRequest $request, Product $product){
        $validation = $request->validated();
        $product->update([
            'name' => $validation['name'],
            'slug' => Str::slug($validation['name']),
            'description' => $validation['description'],
            'price' => $validation['price'],
            'quantity' => $validation['quantity'],
            'discount' => $validation['discount'],
            'total' => $validation['price'] - $validation['discount'],
            'image' => $validation['image'],
        ]);

        return redirect()->route('category-associate-to-product', ['product' => $product->slug])->with('message', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('welcome')->with('message', 'Produto excluído com sucesso.');
    }
}

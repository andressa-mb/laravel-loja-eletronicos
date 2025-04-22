<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(){
        $products = Product::get();
        return view('welcome', ['products' => $products]);
    }

    public function create(){
        return view('product.create');
    }

    public function store(Request $request, Product $product){
        $validation = $request->validate([
            'name' => 'required|max:25',
            'description' => 'max:100',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product->create([
            'name' => $validation['name'],
            'slug' => Str::slug($validation['name']),
            'description' => $validation['description'],
            'price' => $validation['price'],
            'quantity' => $validation['quantity'],
            'discount' => $request->discount,
            'image' => $request->image,
        ]);
        return redirect()->route('welcome');
    }
}

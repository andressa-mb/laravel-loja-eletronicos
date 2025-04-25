<?php

namespace App\Http\Controllers\ProductAndCategories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAndCategoriesController extends Controller
{
    public function index(Request $request){
        $category = Category::find($request->category);
        return view('products_in_category.index-category', ['category' => $category]);
    }

    public function index_product(Request $request){
        $product = Product::where('slug', $request->product)->first();
        return view('products_in_category.index-product', ['product' => $product]);
    }

    public function associate(Product $product){
        return view('products_in_category.associate-categories', ['product' => $product]);
    }

    public function saveRelationCategoryAndPost(Request $request, Product $product){
        //pega o name do select e acha o valor dessa id no option
        //o product pega automático e como chama a relação tem que informar apenas o id da categoria
        $product->categories()->detach($request->category_id); //desassocia se houver já da categoria selecionada
        //senão houver ele só faz uma nova associação na próxima linha
        $product->categories()->attach($request->category_id);
        return redirect()->route('welcome')->with('message', 'Produto criado e categoria associada.');
    }
}

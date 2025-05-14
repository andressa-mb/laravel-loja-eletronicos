<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(){
        $this->authorize('create', Category::class);
        return view('category.create');

    }

    public function store(Request $request){
        $validation = $request->validate([
            'name' => 'required|min:3|max:25'
        ]);
        Category::create([
            'name' => $validation['name']
        ]);

        return redirect()->route('index-adm');
    }

    public function show(){
        return view('category.show');
    }

    public function edit(Category $category){
        $this->authorize('update', $category);
        return view('category.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category){
        $validation = $request->validate([
            'name' => 'required|min:3|max:25'
        ]);

        $category->update([
            'name' => $validation['name'],
        ]);
        return redirect()->route('index-adm');
    }

    public function destroy(Category $category){
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('index-adm')->with('message', 'Excluído com sucesso');
    }
}

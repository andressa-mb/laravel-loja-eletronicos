<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function show(Category $category){
        $this->authorize('view', $category);
        return view('category.show', ['categories' => $category->get()]);
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
        return redirect()->route('category.show')->with('message', "Categoria atualizada.");
    }

    public function destroy(Category $category){
        try{
            $this->authorize('delete', $category);
            $category->findOrFail($category->id)->delete();
            return redirect()->route('category.show')->with('message', 'Excluído com sucesso');
        }catch(Exception $e){
            return back()->withErrors("Erro ao excluir categoria. " . $e->getMessage());
        }
    }
}

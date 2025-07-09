<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    public function create(){
        $this->authorize('create', Category::class);
        return view('category.create');

    }

    public function store(Request $request){
        try{
            $validation = $request->validate([
                'name' => 'required|min:3|max:25',
            ]);

            $category = [
                'name' => $validation['name'],
                'slug' => Str::slug($validation['name'])
            ];

            Category::create($category);

            return redirect()->route('category-show')->with('message', 'Categoria criada com sucesso.');

        }catch(Throwable $e){
            return back()->withErrors("Erro ao criar a categoria. " . $e->getMessage());
        }
    }

    public function show(Category $category){
        $this->authorize('view', $category);
        return view('category.show', ['categories' => $category->paginate(6)]);
    }

    public function edit(Category $category){
        $this->authorize('update', $category);
        return view('category.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category){
        try{
            $validation = $request->validate([
                'name' => 'required|min:3|max:25'
            ]);

            $categoryToUpdate = [
                'name' => $validation['name'],
                'slug' => Str::slug($validation['name'])
            ];

            $category->update($categoryToUpdate);
            return redirect()->route('category-show')->with('message', "Categoria atualizada.");

        }catch(Throwable $e){
            return back()->withErrors('Erro ao editar a categoria. ' . $e->getMessage());
        }
    }

    public function destroy(Category $category){
        try{
            $this->authorize('delete', $category);
            $category->findOrFail($category->id)->delete();
            return redirect()->route('category-show')->with('message', 'Excluído com sucesso');
        }catch(Exception $e){
            return back()->withErrors("Erro ao excluir categoria. " . $e->getMessage());
        }
    }
}

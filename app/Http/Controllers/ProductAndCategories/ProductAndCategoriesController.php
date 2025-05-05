<?php

namespace App\Http\Controllers\ProductAndCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserData\UserDataStoreRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserDataToSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProductAndCategoriesController extends Controller
{
    public function index_category(){
        $categories = Category::get();
        return view('products_in_category.index-category', ['categories' => $categories]);
    }

    public function index_product(Request $request){
        $product = Product::where('slug', $request->product)->first();
        return view('products_in_category.index-product', ['product' => $product]);
    }

    public function selling_product(Request $request){
        return view('selling_product.form-client', ['product' => $request->product]);
    }

    public function send_userdata(UserDataStoreRequest $reqStore, $productSlug){
        //user validate para validar os dados do form e após isso retirar os produtos
        try{
            $product = Product::where('slug', $productSlug)->first();
            if (!$product) {
                return back()->withErrors('Produto não encontrado.');
            }
            UserDataToSend::create($reqStore->validated());
            //Teria que ir para uma página para realizar o pagamento que escolheu
            //por enquanto não tem, logo só vou atualizar a quantidade do produto.
            $product->update([
                'quantity' => $product->quantity - 1
            ]);

            return back()->with('message', "Compra concluída.");

        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    public function associate(Product $product){
        return view('products_in_category.associate-categories', ['product' => $product]);
    }

    public function saveRelationCategoryAndPost(Request $request, Product $product){
        //pega o name do select e acha o valor dessa id no option (caso estiver usando select, pois troquei pro checkbox e ai tem que passar por um array)
        //o product pega automático e como chama a relação tem que informar apenas o id da categoria
        $product->categories()->detach($request->category_id); //desassocia se houver já da categoria selecionada
        if(is_array($request->categories)){
            foreach($request->categories as $category_id){
                //senão houver ele só faz uma nova associação na próxima linha
                $product->categories()->attach($category_id);
            }
        }
        return redirect()->route('index-adm')->with('message', 'Produto criado e categoria associada.');
    }
}

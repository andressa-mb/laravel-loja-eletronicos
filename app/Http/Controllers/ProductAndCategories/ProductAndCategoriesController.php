<?php

namespace App\Http\Controllers\ProductAndCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserData\UserDataStoreRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserDataToSend;
use App\Services\Orders\CartProductsService;
use App\Services\Orders\SellService;
use App\Events\NewOrderReceived;
use App\User;
use Illuminate\Http\Request;
use Throwable;

class ProductAndCategoriesController extends Controller
{
    public function index_category(){
        $categories = Category::paginate(3);
        return view('products_in_category.index-category', ['categories' => $categories]);
    }

    public function index_product(Request $request){
        $product = Product::where('slug', $request->product)->first();
        return view('products_in_category.index-product', ['product' => $product]);
    }

    public function selling_product(Request $request){
       if($request->action == 'carrinho'){
            $cart_list = session()->get('cart_list', []);
            $idModel = Product::find($request->product_id);
            $total = (double)$request->price;

            if($request->hasDiscount){
                if($request->discount_type == "%"){
                    $total = $total - ($total * ((double)$request->discount_value /100));
                } else if($request->discount_type == "R$"){
                    $total = $total - (double)$request->discount_value;
                }
            }

            $total = (int)$request->quantity * $total;


            array_push($cart_list, ['product_id' => $request->product_id, 'name' => $request->name, 'quantity' => $request->quantity, 'price' => $request->price, 'hasDiscount' => $request->hasDiscount, 'total' => $total, 'stock' => $idModel->quantity]);
            session(['cart_list' => $cart_list]);
            return redirect()->action([static::class, 'cart_list']);
        }

        $product = Product::find($request->product_id);
        $product->quantity = (int)$request->quantity;
        $product->price = (double)$request->price;
        $product->hasDiscount = $request->hasDiscount;
        $totalPrice = $product->quantity * $product->price;
        $product->total = $totalPrice;
        $this->data['product'] = $product;
        return view('selling_product.form-client', $this->data);
    }

    public function cart_list(Request $request){
        $cart = $request->session()->get('cart_list');
        return view('selling_product.cart-list', ['cart_list' => $cart]);
    }

    public function selling_itens_cart_list(Request $request){
        $productIdsInCart = $request->input('productsCarts', []);
        if(is_null($productIdsInCart)) return back()->with('message', 'Para finalizar compra é preciso selecionar um item.');

        $quantities = $request->input('quantities', []);
        app()->make(CartProductsService::class)->updateCart($quantities);
        $result = app()->make(CartProductsService::class)->addProducts($productIdsInCart);
        if(!$result){
            return back()->with('message', 'Não foi selecionado nenhum item do carrinho para compra.');
        }
        app()->make(CartProductsService::class)->updateSessions();

        return view('selling_product.form-client', ['product' => session()->get('order')]);
    }

    public function send_userdata(UserDataStoreRequest $reqStore){
        try{
            $products = $reqStore->input('product', []);
            $user_data = $reqStore->validated();

            $user_data = UserDataToSend::create($user_data);
            foreach($products as $prod){
                $findProduct = Product::find($prod['id']);
                if($findProduct){
                    $created_new_order = SellService::new()->newOrder($user_data, $findProduct, $prod);
                } else {
                    return back()->withErrors("Erro ao encontrar o produto.");
                }
            }

            $user = User::find(auth()->user()->id);
            broadcast(new NewOrderReceived(
                $created_new_order,
                $user->id,
                "Novo pedido #($created_new_order->id) criado por #($user->name)"
            ))->toOthers();

            session()->forget('order');
            //NÃO SERÁ FEITO: Teria que ir para uma página para realizar o pagamento que escolheu por enquanto não tem, logo só vou atualizar a quantidade do produto.
            return redirect()->route('index-buyer')->with('message', "Compra concluída.");
        } catch(Throwable $e){
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
        return redirect()->route('product-show')->with('message', 'Produto criado e categoria associada.');
    }
}

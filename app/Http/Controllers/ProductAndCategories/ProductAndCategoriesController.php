<?php

namespace App\Http\Controllers\ProductAndCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserData\UserDataStoreRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProductItem;
use App\Models\Product;
use App\Models\UserDataToSend;
use App\Services\Orders\CartProductsService;
use App\Services\Orders\SellService;
use Illuminate\Http\Request;
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
       if($request->action == 'carrinho'){
            $cart_list = session()->get('cart_list', []);
            $idModel = Product::find($request->product_id);

            $totalDiscount = (int)$request->quantity * (double)$request->discount;
            $totalPrice = (int)$request->quantity * (double)$request->price;
            $totalResult = $totalPrice - $totalDiscount;

            array_push($cart_list, ['product_id' => $request->product_id, 'name' => $request->name, 'quantity' => $request->quantity, 'price' => $request->price, 'discount' => $request->discount, 'total' => $totalResult, 'stock' => $idModel->quantity]);
            session(['cart_list' => $cart_list]);
            return redirect()->action([static::class, 'cart_list']);
        }
        $product = Product::find($request->product_id);
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $totalDiscount = (int)$request->quantity * (double)$request->discount;
        $totalPrice = (int)$request->quantity * (double)$request->price;
        $product->total = $totalPrice - $totalDiscount;
        $this->data['product'] = $product;

        return view('selling_product.form-client', $this->data);
    }

    public function cart_list(Request $request){
        $cart = $request->session()->get('cart_list');
        return view('selling_product.cart-list', ['cart_list' => $cart]);
    }

    public function selling_itens_cart_list(Request $request){
        $productIdsInCart = $request->input('productsCarts');
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
            $products = $reqStore->input('product');
            $user_data = $reqStore->validated();
            if(is_array($products)){
                foreach($products as $prod){
                    $findProduct = Product::find($prod['id']);
                    if($findProduct){
                        $user_data = UserDataToSend::create($user_data);
                        SellService::new()->newOrder($user_data, $findProduct, $prod);
                    } else {
                        return back()->withErrors("Erro ao encontrar o produto.");
                    }
                }
            }

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
        return redirect()->route('index-adm')->with('message', 'Produto criado e categoria associada.');
    }
}

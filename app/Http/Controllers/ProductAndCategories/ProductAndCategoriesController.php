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
        return view('selling_product.form-client', ['product' => $request->product]);
    }

    public function cart_list(Request $request){
        $cart = $request->session()->get('cart_list');
        return view('selling_product.cart-list', ['cart_list' => $cart]);
    }

    public function selling_itens_cart_list(Request $request){
        $productsInCart = $request->input('productsCarts');
        $quantities = $request->input('quantities', []);
        app()->make(CartProductsService::class)->updateCart($quantities);
        $result = app()->make(CartProductsService::class)->addProducts($productsInCart);
        if(!$result){
            return back()->with('message', 'Não foi selecionado nenhum item do carrinho para compra.');
        }

        app()->make(CartProductsService::class)->updateSessions();

        return view('selling_product.form-client', ['product' => session()->get('order')]);
    }

    public function send_userdata(UserDataStoreRequest $reqStore){
        try{
            $products = $reqStore->input('products');
            $user_data = UserDataToSend::create($reqStore->validated());

            $newOrder = Order::create([
                'status' => Order::pendente,
                'user_id' => auth()->id(),
                'user_data_id' => $user_data->id
            ]);


            if(is_array($products)){
                foreach($products as $prod){
                    $findProduct = Product::find($prod['product_id']);
                    if($findProduct){
                        SellService::new()->newOrder($newOrder, $findProduct, $prod);
                    } else {
                        return back()->withErrors("Erro ao encontrar o produto.");
                    }
                }
            } else {
                $findProduct = Product::find($products);
                if($findProduct){
                    $qtdConvertion = intval(str_replace("Quantidade: ", "", $reqStore->input('qtd-'.$findProduct->id)));
                    $newQtd = $findProduct->quantity <= $qtdConvertion ? 0 : $findProduct->quantity - $qtdConvertion;
                    $findProduct->update([
                        'quantity' => $newQtd
                    ]);
                    $price = $reqStore->input('price-'.$findProduct->id);
                    $price = str_replace("Preço: ", "", $price);
                    $price = str_replace(".", "", $price);
                    $price = str_replace(",", ".", $price);

                    $discount = $reqStore->input('discount-'.$findProduct->id);
                    $discount = str_replace("Desconto: ", "", $discount);
                    $discount = str_replace(".", "", $discount);
                    $discount = str_replace(",", ".", $discount);

                    $total = $reqStore->input('total-'.$findProduct->id);
                    $total = str_replace("Total: ", "", $total);
                    $total = str_replace(".", "", $total);
                    $total = str_replace(",", ".", $total);

                    OrderProductItem::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $findProduct->id,
                        'order_quantity' => $qtdConvertion,
                        'order_price' => (double)$price,
                        'order_discount' => (double)$discount,
                        'order_total' => (double)$total
                    ]);
                } else {
                    return back()->withErrors("Erro ao encontrar o produto.");
                }
            }


            session()->forget('order');
            //NÃO SERÁ FEITO: Teria que ir para uma página para realizar o pagamento que escolheu por enquanto não tem, logo só vou atualizar a quantidade do produto.
            return redirect()->route('index-buyer')->with('message', "Compra concluída.");
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

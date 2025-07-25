<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function indexAdm(){
        $this->authorize('view', User::class);
        return view('indexAdm');
    }

    public function indexBuyer(Request $request, Product $product){
        $valueToSort = $request->sort;
        $data = [];
        $query = $product->query();
        if(!is_null($valueToSort)){
            $valueToSort = $request->validate([
                'sort' => 'required|in:popular,lowest_price,highest_price,recent'
            ]);
            switch($valueToSort['sort']){
                case 'popular':
                    $query = $query->orderBy('updated_at', 'desc');
                    break;
                case 'lowest_price':
                    $query = $query->orderBy('price', 'asc');
                    break;
                case 'highest_price':
                    $query = $query->orderBy('price', 'desc');
                    break;
                case 'recent':
                    $query = $query->orderBy('created_at', 'desc');
                    break;
            }
            //$query = $query->orderBy($valueToSort['sort']);
            $data['sort'] = $valueToSort['sort'];
        }else {
            if(!is_null($request->search)){
                $query = $query->searchProduct($request->search);
            }
        }
        $data['products'] = $query->paginate(6);

        if(Cache::has('discount_products')){
            $data['latest_discount'] = Cache::get('discount_products');
        } else {
            $data['latest_discount'] = $product->promotionProducts()->first();
        }

        if(Cache::has('popular_product')){
            $data['popular_product'] = Cache::get('popular_product');
        } else {
            $data['popular_product'] = $product->orderByDesc('updated_at')->first();
        }

        if(Cache::has('liquidation_product')){
            $data['liquidation_product'] = Cache::get('liquidation_product');
        }else {
            $data['liquidation_product'] = $product->lessQuantities()->first();
        }

        return view('indexBuyer', $data);
    }

    public function indexProfile(Request $request){
        return view('profile.index', ['user' => $request->user()]);
    }

    public function purchases(Order $order){
        return view('profile.my-purchases', ['orders' =>  $order->where('user_id', auth()->user()->id)->paginate(6)]);
    }

    public function orders(){
       $filterOrder = Order::whereHas('user', function ($query){
        $query->whereNull('deleted_at');
       })->paginate(6);

       return view('order.show', ['orderList' => $filterOrder]);
    }
}

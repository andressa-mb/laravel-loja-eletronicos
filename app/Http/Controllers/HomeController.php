<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function indexAdm(){
        return view('indexAdm');
    }

    public function indexBuyer(Request $request, Product $product){
        $valueToSort = $request->sort;
        if(!is_null($valueToSort)){
            $valueToSort = $request->validate([
                'sort' => 'required|in:popular,lowest_price,highest_price,recent'
            ]);
            $value = $valueToSort['sort'];
            $products = $product->sortBy($value)->get();
            return view('indexBuyer', ['products' => $products, 'sort' => $value]);
        }else {
            if(!is_null($request->search)){
                $searchProducts = $product->searchProduct($request->search)->get();
                return view('indexBuyer', ['products' => $searchProducts]);
            }
            return view('indexBuyer', ['products' => $product->get()]);
        }
    }

    public function indexProfile(Request $request){
        return view('profile.index', ['user' => $request->user()]);
    }
}

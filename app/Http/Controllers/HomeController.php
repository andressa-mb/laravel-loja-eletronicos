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
        return view('indexBuyer', $data);
    }

    public function indexProfile(Request $request){
        return view('profile.index', ['user' => $request->user()]);
    }
}

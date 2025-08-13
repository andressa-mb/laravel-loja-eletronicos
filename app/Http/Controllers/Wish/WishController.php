<?php

namespace App\Http\Controllers\Wish;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class WishController extends Controller{
    public function wishes(){
        $wish = Wish::where('user_id', auth()->user()->id)->paginate(6);
        return view('wish.show', ['wishList' => $wish]);
    }

    public function addToWish(Request $request){
        $findProd = Product::where('slug', $request->product)->first();
        $userLogado = Auth::user()->id;
        Wish::create([
            'user_id' => $userLogado,
            'product_id' => $findProd->id
        ]);

        return back()->with('message', 'Adicionado a lista com sucesso.');
    }

    public function removeWish(Request $request){
        try{
            $wish = Wish::findOrFail($request->wish);
            $wish->delete();
            return back()->with('message', 'Produto retirado da lista de desejos.');
        }catch(Throwable $e) {
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wish;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

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

        return view('indexBuyer', $data);
    }

    public function indexProfile(Request $request){
        return view('profile.index', ['user' => $request->user()]);
    }

    public function purchases(Order $order){
        return view('profile.my-purchases', ['orders' =>  $order->where('user_id', auth()->user()->id)->get()]);
    }

    public function orders(){
       $filterOrder = Order::whereHas('user', function ($query){
        $query->whereNull('deleted_at');
       })->paginate(6);

       return view('order.show', ['orderList' => $filterOrder]);
    }

    public function usersList(User $user){
        $this->authorize('view', $user);
        return view('admin.users-list', ['users' => $user->get()]);
    }

    public function editUser(Request $request, User $user){
        $this->authorize('update', $user);
        return view('admin.edit-user', ['user' => $user->find($request->user->id)]);
    }

    public function updateUser(UserUpdateRequest $request){
        try{
            $validation = $request->validated();
            $user = User::find($request->user);
            $user->update([
                'name' => $validation['name'],
                'email' => $validation['email'],
            ]);
            $user->roles()->sync($request->role);

            return redirect()->route('users-list')->with('message', 'Usuário atualizado');
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id){
        $this->authorize('delete', User::class);
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users-list')->with('message', 'Excluído usuário com sucesso.');

        }catch(Throwable $e) {
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    public function wish(){
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

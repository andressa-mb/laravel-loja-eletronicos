<?php

namespace App\Http\Controllers\Discounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discounts\DiscountUpdateRequest;
use App\Http\Requests\Discounts\DiscountStoreRequest;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Throwable;

class DiscountController extends Controller
{
    public function show(){
        $this->authorize('view', Discount::class);
        return view('discount.show', ['discounts' => Discount::paginate(6)]);
    }

    public function showPromotions(){
        if(Cache::has('discount_products')){
            $new_discount = Cache::get('discount_products');
        } else {
            $new_discount = Product::promotionProducts()->first();
        }
        return view('discount.showPromotions', ['latest_discount' => $new_discount]);
    }

    public function create(){
        $this->authorize('view', Discount::class);
        return view('discount.create');
    }

    public function store(DiscountStoreRequest $req, Discount $discount){
        try{
            $this->authorize('create', $discount);
            $validation = $req->validated();

            $discountValue = ($validation['typeDiscount'] == '%')
            ? (float)$validation['percentDiscount']
            : (float)$validation['valueDiscount'];

            $discount->create([
                'type' => $validation['typeDiscount'],
                'discount_value' => $discountValue,
                'start_date' => $validation['startDate'],
                'end_date' => $validation['endDate'],
                'message' => $validation['messageDiscount']
            ]);

            return redirect()->route('discount-show')->with('message', 'Desconto cadastrado.');

        }catch(Throwable $error){
            return back()->withErrors('Erro ao criar o desconto selecionado. ' + $error->getMessage());
        }

    }

    public function edit(Discount $discount){
        $this->authorize('update', $discount);
        return view('discount.edit', ['discount' => $discount]);
    }

    public function update(DiscountUpdateRequest $req, Discount $discount){
        try{
            $validation = $req->validated();
            $discountValue = ($validation['typeDiscount'] == '%')
            ? (float)$validation['percentDiscount']
            : (float)$validation['valueDiscount'];

            $formDiscount = [
                'type' => $validation['typeDiscount'],
                'discount_value' => $discountValue,
                'start_date' => $validation['startDate'],
                'end_date' => $validation['endDate'],
                'message' => $validation['messageDiscount']
            ];

            $discount->update($formDiscount);
            return redirect('discounts-list')->with('message', 'Desconto atualizado com sucesso.');
        }catch(Throwable $error){
            return back()->withErrors('Erro ao atualizar o desconto selecionado. ' + $error->getMessage());
        }
    }

    public function destroy($id){
        $this->authorize('delete', Discount::class);
        Discount::findOrFail($id)->delete();
        return back()->with('message', 'Excluído com sucesso.');
    }
}

<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showStock(Request $request, Product $product){
        $products = Product::query();
        switch($request->sort){
            case 'smallest_qty':
                $products = $product->orderBy('quantity');
                break;
            case 'largest_qty':
                $products = $product->orderByDesc('quantity');
                break;
            case 'alphabetical':
                $products = $product->orderBy('name');
                break;
            case 'smallest_id':
                $products = $product->orderBy('id');
                break;
            case 'largest_id':
                $products = $product->orderByDesc('id');
                break;
        }

        return view('admin.reports.stock.show', ['products' => $products->paginate(6)]);
    }
}

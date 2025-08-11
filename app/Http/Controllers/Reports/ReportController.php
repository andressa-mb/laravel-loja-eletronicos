<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProductItem;
use App\Models\Product;
use App\Models\Views\OrderItemView;
use App\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PdfDom;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function showStock(Request $request, Product $product){
        $this->authorize('view', User::class);
        $products = Product::query();
        switch($request->sort){
            case 'smallest_qty':
                $products = $product->orderBy('quantity');
                break;
            case 'largest_qty':
                $products = $product->orderByDesc('quantity');
                break;
            case 'aToZ':
                $products = $product->orderBy('name');
                break;
            case 'zToA':
                $products = $product->orderByDesc('name');
                break;
            case 'smallest_id':
                $products = $product->orderBy('id');
                break;
            case 'largest_id':
                $products = $product->orderByDesc('id');
                break;
        }

        return view('admin.reports.stock.show', ['products' => $products->paginate(6), 'allProducts' => $product->get()]);
    }

    public function downloadPdf($tableName){
        if($tableName == "pdf_client"){
            $pdf = PdfDom::loadView('admin.reports.clients.pdf', ['clients' => User::orderBy('id')->get()]);
        } else if ($tableName == "pdf_stock"){
            $pdf = PdfDom::loadView('admin.reports.stock.pdf', ['products' => Product::orderBy('id')->get()]);
        } else if ($tableName == "pdf_orders"){
            $pdf = PdfDom::loadView('admin.reports.pdf', ['orders' => OrderProductItem::orderBy('id')->get()]);
        }
        $pdf->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif'
            ]);

        return $pdf->download();
    }

    public function showClients(Request $request, User $client){
        $this->authorize('view', User::class);
        $clients = User::query();
        switch($request->sort){
            case 'aToZ':
                $clients = $client->orderBy('name');
                break;
            case('zToA'):
                $clients = $client->orderByDesc('name');
                break;
            case('smallest_id'):
                $clients = $client->orderBy('id');
                break;
            case('largest_id'):
                $clients = $client->orderByDesc('id');
                break;
            case('newest'):
                $clients = $client->orderByDesc('created_at');
                break;
            case('oldest'):
                $clients = $client->orderBy('created_at');
                break;
        }

        return view('admin.reports.clients.show', ['clients' => $clients->get()]);
    }

    public function showSales(Request $request){
        $this->authorize('view', User::class);
        //produtos mais vendidos e com menos saidas
        //mais vendidos
        $orderItems = OrderItemView::get();


        return view('admin.reports.sales.show', ['orderItems' => $orderItems]);
    }
}

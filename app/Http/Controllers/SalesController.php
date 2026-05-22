<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Detail_sales;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index() {
        $sales = Sales::whereNotNull('date_sales')->get();
        $customers = Customer::all('id', 'name');
        $products = Product::where('qty_instock', '!=', 0)->get();
        $detail_sales = Detail_sales::where('sales_id', 1)->get();
        $total_price = Detail_sales::where('sales_id', 1)->sum('sub_price');

        return view('penjualan', compact('sales', 'customers', 'products', 'detail_sales', 'total_price'));
    }

    public function detail(Request $request) {
        $sales = Sales::where('id', $request->id)->get();
        $detail_sales = Detail_sales::where('sales_id', $request->id)->get();

        return view('penjualan-rincian', compact('sales', 'detail_sales'));
    }

    public function store(Request $request) {
        $user_id = Auth::id();
        $request->merge(['user_id' => $user_id]);

        $total_qty = Detail_sales::where('sales_id', 1)->sum('sub_qty');
        $request->merge(['total_qty' => $total_qty]);

        $total_price = Detail_sales::where('sales_id', 1)->sum('sub_price');
        $request->merge(['total_price' => $total_price]);
        

        $data = $request->validate([
            'date_sales' => ['required'],
            'customer_id' => ['required'],
            'total_qty' => [''],
            'total_price' => [''],
            'user_id' => [''],
        ]);

        if ($sale = Sales::create($data)) {
            $detail_sales = Detail_sales::where('sales_id', 1)->get();

            foreach ($detail_sales as $ds) {
                $ds->update([
                    'sales_id' => $sale->id,
                ]);

                $product = Product::findOrFail($ds->product_id);
                $product->update([
                    'qty_instock' => $product->qty_instock - $ds->sub_qty,
                ]);
            }

            return back();
        }

        return back()->withErrors([

        ]);
    }

    public function delete(Request $request) {
        Sales::destroy($request->id);

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Detail_sales;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;

class DetailSalesController extends Controller
{
    public function store(Request $request) {
        $sub_price = Product::where('id', $request->product_id)->value('price');
        $request->merge(['sub_price' => $sub_price * $request->sub_qty]);

        $data = $request->validate([
            'sales_id' => ['required'],
            'product_id' => ['required'],
            'sub_qty' => ['required', 'integer'],
            'sub_price' => ['required', 'integer'],
        ]);

        if (Detail_sales::create($data)) {
            return back();
        }

        return back()->withErrors([

        ]);
    }

    public function update_item(Request $request) {
        $original_item = Sales::findOrFail($request->sales_id);
        $updated_item = Detail_sales::findOrFail($request->id);
        $product = Product::findOrFail($request->product_id);

        $product->update([
            'qty_instock' => $product->qty_instock + $updated_item->sub_qty,
        ]);

        $original_item->update([
            'total_qty' => $original_item->total_qty - $updated_item->sub_qty,
            'total_price' => $original_item->total_price - $updated_item->sub_price,

        ]);

        Detail_sales::destroy($request->id);

        return redirect()->route('api.sales.detail', ['id' => $request->sales_id]);
    }

    public function update_qty(Request $request) {
        $sale = Sales::findOrFail($request->sales_id);
        $product = Product::findOrFail($request->product_id);
        $detail = Detail_sales::findOrFail($request->id);

        $product->update([
            'qty_instock' => $product->qty_instock + ($detail->sub_qty - $request->sub_qty),
        ]);
        
        $detail->update([
            'sub_qty' => $request->sub_qty,
            'sub_price' => $product->price * $request->sub_qty,
        ]);

        $total_qty = $sale->detail_sales()->sum('sub_qty');
        $total_price = $sale->detail_sales()->sum('sub_price');

        $sale->update([
            'total_qty' => $total_qty,
            'total_price' => $total_price,
        ]);

        return redirect()->route('api.sales.detail', ['id' => $sale->id]);
    }

    public function delete(Request $request) {
        Detail_sales::destroy($request->id);

        return back();
    }
}

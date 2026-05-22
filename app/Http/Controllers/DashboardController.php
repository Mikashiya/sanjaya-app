<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $lowstocks = Product::where('qty_instock', '<=', 6)->get();

        foreach ($lowstocks as $ls) {
            if ($ls->qty_instock >= 4) {
                $ls->urgency = 'Rendah';
                $ls->bg_color = 'bg-yellow-500';
            } elseif ($ls->qty_instock >= 2) {
                $ls->urgency = 'Sedang';
                $ls->bg_color = 'bg-orange-500';
            } else {
                $ls->urgency = 'Tinggi';
                $ls->bg_color = 'bg-red-500';
            }
        }

        $totalprice = Sales::whereToday('date_sales')->sum('total_price');
        $totalbuyer = Sales::whereToday('date_sales')->count('customer_id');

        return view('beranda', compact('lowstocks', 'totalprice', 'totalbuyer'));
    }
}

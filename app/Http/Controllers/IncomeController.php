<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index() {
        // Daily
        $startWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $daily_sales = Sales::whereBetween('date_sales', [$startWeek, $endWeek])->get();

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $daily_data = array_fill(0, 7, 0);

        foreach ($daily_sales as $ds) {
            $dayIndex = Carbon::parse($ds->date_sales)->dayOfWeekIso - 1;
            $daily_data[$dayIndex] += $ds->total_qty;
        }

        // Weekly
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth   = Carbon::now()->endOfMonth();

        $weekly_sales = Sales::whereBetween('date_sales', [$startMonth, $endMonth])->get();

        $weeks = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'];
        $weekly_data = array_fill(0, count($weeks), 0);

        foreach ($weekly_sales as $ws) {
            $weekIndex = Carbon::parse($ws->date_sales)->weekOfMonth - 1;
            $weekly_data[$weekIndex] += $ws->total_qty;
        }

        // Monthly
        $startYear = Carbon::now()->startOfYear();
        $endYear   = Carbon::now()->endOfYear();

        $monthly_sales = Sales::whereBetween('date_sales', [$startYear, $endYear])->get();

        $months = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
        $monthly_data = array_fill(0, 12, 0);

        foreach ($monthly_sales as $ms) {
            $monthIndex = Carbon::parse($ms->date_sales)->month - 1;
            $monthly_data[$monthIndex] += $ms->total_qty;
        }

        return view('pendapatan', [
            'daily_labels' => $days,
            'daily_data' => $daily_data,
            'weekly_labels' => $weeks,
            'weekly_data' => $weekly_data,
            'monthly_labels' => $months,
            'monthly_data'   => $monthly_data,
        ]);
    }
}

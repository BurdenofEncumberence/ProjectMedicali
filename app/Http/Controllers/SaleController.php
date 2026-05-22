<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('user', 'saleItems.medicine')->latest();

        // Search by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by discount type
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        $sales = $query->paginate(15);

        // Summary stats for the filtered results
        $totalRevenue  = $query->sum('total');
        $totalSales    = $query->count();
        $totalDiscount = $query->sum('discount_amount');

        return view('sales.index', compact(
            'sales',
            'totalRevenue',
            'totalSales',
            'totalDiscount'
        ));
    }

    public function show(Sale $sale)
    {
        $sale->load('saleItems.medicine', 'user');
        return view('sales.show', compact('sale'));
    }
}
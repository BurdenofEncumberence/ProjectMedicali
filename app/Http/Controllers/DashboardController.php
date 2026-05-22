<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedicines  = Medicine::count();
        $totalSuppliers  = Supplier::count();
        $totalSales      = Sale::count();
        $totalRevenue    = Sale::sum('total');

        $lowStock    = Medicine::lowStock()->get();
        $nearExpiry  = Medicine::nearExpiry()->get();
        $expired     = Medicine::expired()->get();

        return view('dashboard', compact(
            'totalMedicines',
            'totalSuppliers',
            'totalSales',
            'totalRevenue',
            'lowStock',
            'nearExpiry',
            'expired'
        ));
    }
}
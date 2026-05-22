<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Medicine;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period   = $request->get('period', 'daily');
        $dateFrom = $request->get('date_from', now()->subDays(7)->format('Y-m-d'));
        $dateTo   = $request->get('date_to', now()->format('Y-m-d'));

        // Daily sales for the last 7 days
        $dailySales = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Weekly sales for the last 4 weeks
        $weeklySales = Sale::select(
                DB::raw('WEEK(created_at) as week'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get();

        // Monthly sales for the last 6 months
        $monthlySales = Sale::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Top 5 best selling medicines
        $topMedicines = SaleItem::select(
                'medicine_id',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->with('medicine')
            ->groupBy('medicine_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Discount breakdown
        $discountBreakdown = Sale::select(
                'discount_type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(discount_amount) as total_discount')
            )
            ->groupBy('discount_type')
            ->get();

        // Payment method breakdown
        $paymentBreakdown = Sale::select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->groupBy('payment_method')
            ->get();

        // Overall stats — filtered by date range
        $totalRevenue   = Sale::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('total');
        $totalSales     = Sale::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count();
        $totalDiscounts = Sale::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('discount_amount');
        $avgSaleValue   = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // Discount labels
        $discountLabels = $discountBreakdown->pluck('discount_type')->map(fn($d) => match($d) {
            'none'   => 'No Discount',
            'senior' => 'Senior',
            'pwd'    => 'PWD',
            default  => $d,
        });

        // Stock health
        $totalMedicines = Medicine::count();
        $expired        = Medicine::whereDate('expiry_date', '<', today())->get();
        $lowStock       = Medicine::whereColumn('stock_qty', '<=', 'reorder_level')
                                  ->whereDate('expiry_date', '>=', today())->get();
        $nearExpiry     = Medicine::whereDate('expiry_date', '>=', today())
                                  ->whereDate('expiry_date', '<=', today()->addDays(30))->get();

        return view('reports.index', compact(
            'dailySales', 'weeklySales', 'monthlySales',
            'topMedicines', 'discountBreakdown', 'discountLabels',
            'paymentBreakdown', 'totalRevenue', 'totalSales',
            'totalDiscounts', 'avgSaleValue', 'totalMedicines',
            'expired', 'lowStock', 'nearExpiry', 'period',
            'dateFrom', 'dateTo'
        ));
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(7)->format('Y-m-d'));
        $dateTo   = $request->get('date_to', now()->format('Y-m-d'));

        $dailySales = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topMedicines = SaleItem::select(
                'medicine_id',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue')
            )
            ->with('medicine')
            ->groupBy('medicine_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $totalRevenue   = Sale::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('total');
        $totalSales     = Sale::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count();
        $totalDiscounts = Sale::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->sum('discount_amount');
        $avgSaleValue   = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        $expired    = Medicine::whereDate('expiry_date', '<', today())->get();
        $lowStock   = Medicine::whereColumn('stock_qty', '<=', 'reorder_level')
                              ->whereDate('expiry_date', '>=', today())->get();
        $nearExpiry = Medicine::whereDate('expiry_date', '>=', today())
                              ->whereDate('expiry_date', '<=', today()->addDays(30))->get();

        $pdf = Pdf::loadView('reports.pdf', compact(
            'dailySales', 'topMedicines',
            'totalRevenue', 'totalSales', 'totalDiscounts', 'avgSaleValue',
            'expired', 'lowStock', 'nearExpiry',
            'dateFrom', 'dateTo'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('medicali-report-' . $dateFrom . '-to-' . $dateTo . '.pdf');
    }
}
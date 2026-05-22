<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Show checkout page
    public function index()
    {
        $medicines = Medicine::where('stock_qty', '>', 0)
            ->orderBy('name')
            ->get();

        return view('checkout.index', compact('medicines'));
    }

    // Process the sale
    public function store(Request $request)
    {
        $request->validate([
            'medicines'             => 'required|array|min:1',
            'medicines.*.id'        => 'required|exists:medicines,id',
            'medicines.*.qty'       => 'required|integer|min:1',
            'discount_type'         => 'required|in:none,senior,pwd',
            'payment_method'        => 'required|in:cash,card,gcash,maya',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $items = [];

            // Calculate subtotal
            foreach ($request->medicines as $item) {
                $medicine = Medicine::findOrFail($item['id']);

                // Check stock
                if ($medicine->stock_qty < $item['qty']) {
                    throw new \Exception("Insufficient stock for {$medicine->name}");
                }

                $itemSubtotal = $medicine->price * $item['qty'];
                $subtotal += $itemSubtotal;

                $items[] = [
                    'medicine'   => $medicine,
                    'qty'        => $item['qty'],
                    'unit_price' => $medicine->price,
                    'subtotal'   => $itemSubtotal,
                ];
            }

            // Apply discount
            $discountAmount = 0;
            if ($request->discount_type !== 'none') {
                $discountAmount = $subtotal * 0.20;
            }

            $total = $subtotal - $discountAmount;

            // Create sale record
            $sale = Sale::create([
                'user_id'         => Auth::id(),
                'total'           => $total,
                'discount_type'   => $request->discount_type,
                'discount_amount' => $discountAmount,
                'payment_method'  => $request->payment_method,
            ]);

            // Create sale items and deduct stock
            foreach ($items as $item) {
                SaleItem::create([
                    'sale_id'     => $sale->id,
                    'medicine_id' => $item['medicine']->id,
                    'qty'         => $item['qty'],
                    'unit_price'  => $item['unit_price'],
                    'subtotal'    => $item['subtotal'],
                ]);

                // Deduct from stock
                $item['medicine']->decrement('stock_qty', $item['qty']);
            }

            session(['last_sale_id' => $sale->id]);
        });

        return redirect()->route('checkout.receipt', session('last_sale_id'))
            ->with('success', 'Sale completed successfully!');
    }

    // Show receipt
    public function receipt(Sale $sale)
    {
        $sale->load('saleItems.medicine', 'user');
        return view('checkout.receipt', compact('sale'));
    }
}
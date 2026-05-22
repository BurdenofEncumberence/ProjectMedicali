<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Sale Details — #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .receipt-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            padding: 36px;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.06);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px dashed #c9e9de;
        }

        .receipt-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: #085041;
            letter-spacing: -0.5px;
        }

        .receipt-sub {
            font-size: 0.75rem;
            color: #9FE1CB;
            margin-top: 2px;
        }

        .receipt-tag {
            display: inline-block;
            margin-top: 8px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1D9E75;
            background: #E1F5EE;
            padding: 3px 12px;
            border-radius: 20px;
        }

        .receipt-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #3B6D11;
            margin-bottom: 4px;
        }

        .receipt-cashier {
            font-size: 0.75rem;
            color: #9FE1CB;
            margin-bottom: 20px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table thead tr {
            border-bottom: 2px solid #E1F5EE;
        }

        .items-table thead th {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #085041;
            padding: 8px 0;
        }

        .items-table thead th:not(:first-child) { text-align: right; }

        .items-table tbody tr {
            border-bottom: 1px solid #f0faf6;
        }

        .items-table tbody td {
            padding: 10px 0;
            font-size: 0.875rem;
            color: #085041;
        }

        .items-table tbody td:not(:first-child) {
            text-align: right;
            color: #3B6D11;
        }

        .items-table tbody td:last-child {
            font-weight: 600;
            color: #085041;
        }

        .totals-section {
            border-top: 2px dashed #c9e9de;
            padding-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #3B6D11;
        }

        .total-row.discount { color: #791F1F; }

        .total-row.grand {
            font-size: 1rem;
            font-weight: 800;
            color: #085041;
            border-top: 1px solid #c9e9de;
            padding-top: 10px;
            margin-top: 4px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 2px dashed #c9e9de;
        }

        .receipt-footer p {
            font-size: 0.72rem;
            color: #9FE1CB;
            margin-bottom: 2px;
        }

        .btn-print {
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .btn-print:hover { background-color: #085041; }

        .btn-back {
            background-color: #E1F5EE;
            color: #085041;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-back:hover { background-color: #9FE1CB; }

        @media print {
            @page { margin: 0.5cm; }

            nav, header,
            .btn-print, .btn-back,
            .print-actions {
                display: none !important;
            }

            body, .bg-gray-100 {
                background-color: #ffffff !important;
            }

            .receipt-card {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }

            .py-8 {
                padding: 0 !important;
            }
        }
    </style>

    <div class="py-8 max-w-2xl mx-auto px-6 sm:px-8">

        <div class="receipt-card">

            <div class="receipt-header">
                <div class="receipt-brand">Medicali</div>
                <div class="receipt-sub">Pharmacy Management System</div>
                <div class="receipt-tag">Official Receipt</div>
            </div>

            <div class="receipt-meta">
                <span>Receipt #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
                <span>{{ $sale->created_at->format('M d, Y h:i A') }}</span>
            </div>
            <div class="receipt-cashier">Cashier: {{ $sale->user->name }}</div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Medicine</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->saleItems as $item)
                        <tr>
                            <td>{{ $item->medicine->name }}</td>
                            <td style="text-align: right;">{{ $item->qty }}</td>
                            <td style="text-align: right;">₱{{ number_format($item->unit_price, 2) }}</td>
                            <td style="text-align: right;">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-section">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($sale->total + $sale->discount_amount, 2) }}</span>
                </div>
                @if($sale->discount_type !== 'none')
                    <div class="total-row discount">
                        <span>{{ ucfirst($sale->discount_type) }} Discount (20%)</span>
                        <span>- ₱{{ number_format($sale->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="total-row grand">
                    <span>Total</span>
                    <span>₱{{ number_format($sale->total, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Payment Method</span>
                    <span style="font-weight: 600; text-transform: uppercase;">{{ $sale->payment_method }}</span>
                </div>
            </div>

            <div class="receipt-footer">
                <p>Thank you for your purchase!</p>
                <p>Sa Medicali, Nakasiguro Gamot ay Laging Bago!</p>
            </div>

        </div>

        <div class="print-actions" style="display: flex; gap: 12px; margin-top: 16px;">
            <button onclick="window.print()" class="btn-print">Print</button>
            <a href="{{ route('sales.index') }}" class="btn-back">Back to Sales</a>
        </div>

    </div>
</x-app-layout>
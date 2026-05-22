<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight print-hide" style="color: #085041;">
            Official Receipt
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .receipt-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #c9e9de;
            padding: 36px;
            box-shadow: 0 2px 8px rgba(15, 110, 86, 0.08);
        }

        .receipt-header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #085041;
        }

        .receipt-header-sub {
            font-size: 0.8rem;
            color: #1D9E75;
            margin-top: 2px;
        }

        .receipt-header-label {
            font-size: 0.7rem;
            color: #9FE1CB;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .receipt-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #3B6D11;
            margin-bottom: 6px;
        }

        .receipt-cashier {
            font-size: 0.75rem;
            color: #3B6D11;
            margin-bottom: 16px;
        }

        .receipt-divider {
            border: none;
            border-top: 1px dashed #9FE1CB;
            margin: 16px 0;
        }

        .receipt-table {
            width: 100%;
            font-size: 0.875rem;
            border-collapse: collapse;
        }

        .receipt-table thead tr th {
            font-size: 0.7rem;
            color: #1D9E75;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #E1F5EE;
        }

        .receipt-table tbody tr td {
            padding: 10px 0;
            color: #085041;
            border-bottom: 1px solid #f0faf6;
        }

        .receipt-table tbody tr:last-child td {
            border-bottom: none;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #3B6D11;
            padding: 5px 0;
        }

        .summary-discount { color: #A32D2D; }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.05rem;
            font-weight: 700;
            color: #085041;
            padding-top: 12px;
            margin-top: 6px;
            border-top: 2px solid #E1F5EE;
        }

        .summary-payment {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #3B6D11;
            padding: 6px 0 0;
        }

        .payment-badge {
            background: #E1F5EE;
            color: #085041;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px dashed #9FE1CB;
        }

        .receipt-footer p {
            font-size: 0.75rem;
            color: #9FE1CB;
            line-height: 1.8;
        }

        .btn-print {
            background-color: #185FA5;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-print:hover { background-color: #0C447C; }

        .btn-new-sale {
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-new-sale:hover { background-color: #0F6E56; }

        .btn-dashboard {
            background-color: #E1F5EE;
            color: #085041;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-dashboard:hover { background-color: #9FE1CB; }

      @media print {
    @page {
        margin: 0;
        size: auto;
    }

    nav,
    header,
    .print-hide {
        display: none !important;
    }

    body {
        margin: 1.5cm;
        background: white !important;
    }

    .bg-gray-100 {
        background: white !important;
    }

    .receipt-card {
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .py-8 {
        padding: 0 !important;
    }

    .max-w-2xl {
        max-width: 100% !important;
    }
}
    </style>

    <div class="py-8 max-w-2xl mx-auto px-6 sm:px-8">

        @if(session('success'))
            <div class="print-hide" style="background: #E1F5EE; color: #085041; border: 1px solid #9FE1CB; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.875rem; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        <div class="receipt-card" id="receipt">

            {{-- Header --}}
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Medicali" class="h-16 w-auto mx-auto mb-2">
                <div class="receipt-header-sub">Pharmacy Management System</div>
                <div class="receipt-header-label">Official Receipt</div>
            </div>

            {{-- Receipt Info --}}
            <div class="receipt-meta">
                <span>Receipt #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
                <span>{{ $sale->created_at->format('M d, Y h:i A') }}</span>
            </div>

            <div class="receipt-cashier">
                Cashier: <strong style="color: #085041;">{{ $sale->user->name }}</strong>
            </div>

            <hr class="receipt-divider">

            {{-- Items --}}
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th class="text-left">Medicine</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->saleItems as $item)
                        <tr>
                            <td>{{ $item->medicine->name }}</td>
                            <td class="text-center" style="color: #1D9E75; font-weight: 600;">{{ $item->qty }}</td>
                            <td class="text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right" style="font-weight: 600;">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr class="receipt-divider">

            {{-- Totals --}}
            <div style="padding-top: 4px;">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($sale->total + $sale->discount_amount, 2) }}</span>
                </div>

                @if($sale->discount_type !== 'none')
                    <div class="summary-row summary-discount">
                        <span>{{ ucfirst($sale->discount_type) }} Discount (20%)</span>
                        <span>− ₱{{ number_format($sale->discount_amount, 2) }}</span>
                    </div>
                @endif

                <div class="summary-total">
                    <span>TOTAL</span>
                    <span>₱{{ number_format($sale->total, 2) }}</span>
                </div>

                <div class="summary-payment">
                    <span>Payment Method</span>
                    <span class="payment-badge">{{ $sale->payment_method }}</span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="receipt-footer">
                <p>Thank you for your purchase!</p>
                <p>Sa Medicali, Nakasiguro Gamot ay Laging Bago!</p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex gap-3 mt-5 flex-wrap print-hide">
            <button onclick="window.print()" class="btn-print">
                Print Receipt
            </button>
            <a href="{{ route('checkout.index') }}" class="btn-new-sale">
                New Sale
            </a>
            <a href="{{ route('dashboard') }}" class="btn-dashboard">
                Dashboard
            </a>
        </div>

    </div>
</x-app-layout>
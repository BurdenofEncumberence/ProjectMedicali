<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Sales History
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.06);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .stat-icon-green { background: #E1F5EE; color: #1D9E75; }
        .stat-icon-teal  { background: #d0f0e4; color: #085041; }
        .stat-icon-red   { background: #FCEBEB; color: #791F1F; }

        .stat-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: #9FE1CB;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #085041;
            line-height: 1.2;
        }

        .filter-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.06);
        }

        .filter-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            color: #085041;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .filter-input, .filter-select {
            border: 1px solid #9FE1CB;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #085041;
            background-color: #f4faf8;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .filter-input:focus, .filter-select:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.15);
        }

        .btn-filter {
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .btn-filter:hover { background-color: #085041; }

        .btn-reset {
            background-color: #E1F5EE;
            color: #085041;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 9px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-reset:hover { background-color: #9FE1CB; }

        .med-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.06);
        }

        .med-table thead tr { background-color: #E1F5EE; }

        .med-table thead th {
            font-size: 0.7rem;
            font-weight: 600;
            color: #085041;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 12px 16px;
            text-align: left;
        }

        .med-table tbody tr {
            border-bottom: 1px solid #f0faf6;
            transition: background-color 0.15s;
        }

        .med-table tbody tr:hover { background-color: #f4faf8; }

        .med-table tbody td {
            padding: 12px 16px;
            font-size: 0.875rem;
            color: #085041;
        }

        .med-table tbody td.muted { color: #3B6D11; }

        .badge-none   { color: #9FE1CB; font-size: 0.75rem; }
        .badge-senior { background: #E6F1FB; color: #0C447C; font-size: 0.7rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .badge-pwd    { background: #EEEDFE; color: #3C3489; font-size: 0.7rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; }

        .btn-view {
            background-color: #E1F5EE;
            color: #085041;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-view:hover { background-color: #9FE1CB; }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-6 sm:px-8 space-y-6">



        {{-- Filters --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('sales.index') }}"
                  style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">

                <div>
                    <label class="filter-label">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="filter-input">
                </div>

                <div>
                    <label class="filter-label">Payment Method</label>
                    <select name="payment_method" class="filter-select">
                        <option value="">All</option>
                        <option value="cash"  {{ request('payment_method') == 'cash'  ? 'selected' : '' }}>Cash</option>
                        <option value="card"  {{ request('payment_method') == 'card'  ? 'selected' : '' }}>Card</option>
                        <option value="gcash" {{ request('payment_method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="maya"  {{ request('payment_method') == 'maya'  ? 'selected' : '' }}>Maya</option>
                    </select>
                </div>

                <div>
                    <label class="filter-label">Discount Type</label>
                    <select name="discount_type" class="filter-select">
                        <option value="">All</option>
                        <option value="none"   {{ request('discount_type') == 'none'   ? 'selected' : '' }}>No Discount</option>
                        <option value="senior" {{ request('discount_type') == 'senior' ? 'selected' : '' }}>Senior Citizen</option>
                        <option value="pwd"    {{ request('discount_type') == 'pwd'    ? 'selected' : '' }}>PWD</option>
                    </select>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter">Filter</button>
                    <a href="{{ route('sales.index') }}" class="btn-reset">Reset</a>
                </div>

            </form>
        </div>

        {{-- Sales Table --}}
        <div class="med-card">
            <table class="med-table w-full">
                <thead>
                    <tr>
                        <th>Receipt #</th>
                        <th>Cashier</th>
                        <th>Items</th>
                        <th>Discount</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td style="font-weight: 600;">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="muted">{{ $sale->user->name }}</td>
                            <td class="muted">{{ $sale->saleItems->count() }} item(s)</td>
                            <td>
                                @if($sale->discount_type === 'none')
                                    <span class="badge-none">None</span>
                                @elseif($sale->discount_type === 'senior')
                                    <span class="badge-senior">Senior</span>
                                @else
                                    <span class="badge-pwd">PWD</span>
                                @endif
                            </td>
                            <td class="muted" style="text-transform: uppercase; font-weight: 600; font-size: 0.75rem;">
                                {{ $sale->payment_method }}
                            </td>
                            <td style="font-weight: 700; color: #0F6E56;">₱{{ number_format($sale->total, 2) }}</td>
                            <td class="muted" style="font-size: 0.75rem;">{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <a href="{{ route('sales.show', $sale) }}" class="btn-view">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 32px; color: #9FE1CB; font-size: 0.875rem;">
                                No sales yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sales->links() }}
        </div>

    </div>
</x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #ffffff;
            padding: 32px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #1D9E75;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            color: #085041;
        }

        .brand-sub {
            font-size: 10px;
            color: #9FE1CB;
            margin-top: 2px;
        }

        .report-meta {
            text-align: right;
            font-size: 10px;
            color: #6b7280;
        }

        .report-meta strong {
            color: #085041;
            font-size: 11px;
        }

        /* Stat strip */
        .stat-strip {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 20px;
        }

        .stat-box {
            display: table-cell;
            width: 25%;
            background: #f0faf6;
            border: 1px solid #c9e9de;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .stat-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9FE1CB;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 16px;
            font-weight: 700;
            color: #085041;
        }

        .stat-sub {
            font-size: 8px;
            color: #9FE1CB;
            margin-top: 2px;
        }

        /* Section */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #085041;
            background: #E1F5EE;
            padding: 6px 10px;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #085041;
            background: #f4faf8;
            padding: 7px 10px;
            text-align: left;
            border-bottom: 1px solid #c9e9de;
        }

        tbody td {
            padding: 7px 10px;
            font-size: 10px;
            color: #374151;
            border-bottom: 1px solid #f0faf6;
        }

        tbody tr:last-child td { border-bottom: none; }

        .td-bold  { font-weight: 700; color: #085041; }
        .td-green { font-weight: 700; color: #0F6E56; }
        .td-right { text-align: right; }

        /* Stock pills */
        .pill {
            display: inline-block;
            font-size: 8px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .pill-red    { background: #FCEBEB; color: #791F1F; }
        .pill-yellow { background: #FEF9E7; color: #7D6008; }
        .pill-orange { background: #FEF0E6; color: #7E3400; }

        .two-col {
            display: table;
            width: 100%;
            border-spacing: 10px 0;
            border-collapse: separate;
        }

        .two-col-left, .two-col-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .footer {
            margin-top: 28px;
            border-top: 1px solid #c9e9de;
            padding-top: 10px;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }

        .empty-row td {
            text-align: center;
            color: #9FE1CB;
            padding: 14px;
            font-style: italic;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="brand-name">Medicali</div>
            <div class="brand-sub">Pharmacy Management System</div>
        </div>
        <div class="report-meta">
            <strong>Pharmacy Report</strong><br>
            Period: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}
            — {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}<br>
            Generated: {{ now()->format('M d, Y h:i A') }}
        </div>
    </div>

    {{-- Stat Strip --}}
    <div class="stat-strip">
        <div class="stat-box">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
            <div class="stat-sub">Selected period</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Transactions</div>
            <div class="stat-value">{{ $totalSales }}</div>
            <div class="stat-sub">Sales recorded</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Discounts</div>
            <div class="stat-value">₱{{ number_format($totalDiscounts, 2) }}</div>
            <div class="stat-sub">Given out</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Avg Sale Value</div>
            <div class="stat-value">₱{{ number_format($avgSaleValue, 2) }}</div>
            <div class="stat-sub">Per transaction</div>
        </div>
    </div>

    {{-- Two column section --}}
    <div class="two-col">

        {{-- Sales Breakdown --}}
        <div class="two-col-left">
            <div class="section">
                <div class="section-title">Sales Breakdown</div>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transactions</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dailySales as $day)
                            <tr>
                                <td class="td-bold">{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                <td>{{ $day->transactions }}</td>
                                <td class="td-green">₱{{ number_format($day->revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="3">No sales in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Medicines --}}
        <div class="two-col-right">
            <div class="section">
                <div class="section-title">Top 5 Best Selling Medicines</div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Medicine</th>
                            <th>Qty Sold</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topMedicines as $i => $item)
                            <tr>
                                <td class="td-bold">#{{ $i + 1 }}</td>
                                <td>{{ $item->medicine->name }}</td>
                                <td>{{ $item->total_qty }}</td>
                                <td class="td-green">₱{{ number_format($item->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="4">No data yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Stock Health --}}
    <div class="section">
        <div class="section-title">Stock Health Alerts</div>
        <div class="two-col">
            {{-- Expired --}}
            <div class="two-col-left">
                <table>
                    <thead>
                        <tr>
                            <th colspan="3">Expired Medicines ({{ $expired->count() }})</th>
                        </tr>
                        <tr>
                            <th>Medicine</th>
                            <th>Expiry Date</th>
                            <th>Stock Left</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expired as $med)
                            <tr>
                                <td class="td-bold">{{ $med->name }}</td>
                                <td>{{ $med->expiry_date->format('M d, Y') }}</td>
                                <td><span class="pill pill-red">{{ $med->stock_qty }} left</span></td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="3">No expired medicines ✓</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Low Stock & Near Expiry --}}
            <div class="two-col-right">
                <table>
                    <thead>
                        <tr>
                            <th colspan="3">Low Stock ({{ $lowStock->count() }})</th>
                        </tr>
                        <tr>
                            <th>Medicine</th>
                            <th>Stock</th>
                            <th>Reorder At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStock as $med)
                            <tr>
                                <td class="td-bold">{{ $med->name }}</td>
                                <td><span class="pill pill-yellow">{{ $med->stock_qty }}</span></td>
                                <td>{{ $med->reorder_level }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="3">All stock levels good ✓</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <br>

                <table>
                    <thead>
                        <tr>
                            <th colspan="3">Near Expiry ({{ $nearExpiry->count() }})</th>
                        </tr>
                        <tr>
                            <th>Medicine</th>
                            <th>Expires</th>
                            <th>Days Left</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nearExpiry as $med)
                            <tr>
                                <td class="td-bold">{{ $med->name }}</td>
                                <td>{{ $med->expiry_date->format('M d, Y') }}</td>
                                <td><span class="pill pill-orange">{{ (int) ceil(now()->floatDiffInDays($med->expiry_date)) }} days</span></td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="3">No medicines near expiry ✓</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    {{-- Footer --}}
    <div class="footer">
        © {{ date('Y') }} Medicali — Pharmacy Management System &nbsp;·&nbsp;
        This report was automatically generated and is for internal use only.
    </div>

</body>
</html>
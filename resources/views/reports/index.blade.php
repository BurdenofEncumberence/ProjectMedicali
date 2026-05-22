<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Reports
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .reports-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto;
            gap: 14px;
        }

        /* Stat strip */
        .stat-strip {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .stat-mini {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #c9e9de;
            padding: 14px 18px;
            box-shadow: 0 1px 3px rgba(15,110,86,0.05);
        }

        .stat-mini-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #9FE1CB;
            margin-bottom: 4px;
        }

        .stat-mini-value {
            font-size: 1.3rem;
            font-weight: 800;
            color: #085041;
            line-height: 1.1;
        }

        .stat-mini-sub {
            font-size: 0.65rem;
            color: #9FE1CB;
            margin-top: 2px;
        }

        /* Panel */
        .panel {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #c9e9de;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(15,110,86,0.05);
            display: flex;
            flex-direction: column;
        }

        .panel-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #085041;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .panel-body {
            flex: 1;
            min-height: 0;
            position: relative;
        }

        /* Tab buttons */
        .tab-group {
            display: flex;
            gap: 4px;
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .tab-btn {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            background: #f0faf6;
            color: #9FE1CB;
            transition: all 0.15s;
        }

        .tab-btn.active {
            background: #1D9E75;
            color: #ffffff;
        }

        /* Rank list */
        .rank-row {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 0;
            border-bottom: 1px solid #f0faf6;
        }

        .rank-row:last-child { border-bottom: none; }

        .rank-num {
            font-size: 0.6rem;
            font-weight: 800;
            color: #1D9E75;
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .rank-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: #085041;
            flex: 1;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rank-val {
            font-size: 0.7rem;
            font-weight: 700;
            color: #1D9E75;
            background: #E1F5EE;
            padding: 2px 8px;
            border-radius: 20px;
            flex-shrink: 0;
        }

        /* Mini table */
        .mini-table { width: 100%; border-collapse: collapse; }

        .mini-table thead th {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #085041;
            padding: 6px 10px;
            background: #f4faf8;
            text-align: left;
        }

        .mini-table tbody tr { border-bottom: 1px solid #f0faf6; }
        .mini-table tbody tr:last-child { border-bottom: none; }

        .mini-table tbody td {
            padding: 7px 10px;
            font-size: 0.78rem;
            color: #3B6D11;
        }

        .mini-table tbody td.bold { font-weight: 700; color: #085041; }
        .mini-table tbody td.rev  { font-weight: 700; color: #0F6E56; }
        .mini-table tbody td.empty { text-align: center; color: #9FE1CB; padding: 16px; font-size: 0.75rem; }

        /* Stock health */
        .health-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0faf6;
        }

        .health-row:last-child { border-bottom: none; }

        .health-label { font-size: 0.78rem; font-weight: 600; color: #085041; }
        .health-sub   { font-size: 0.65rem; color: #9FE1CB; }

        .pill-red    { background: #FCEBEB; color: #791F1F; font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .pill-yellow { background: #FEF9E7; color: #7D6008; font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .pill-orange { background: #FEF0E6; color: #7E3400; font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .pill-green  { background: #E1F5EE; color: #085041; font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

        /* Date filter bar */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            background: #ffffff;
            border: 1px solid #c9e9de;
            border-radius: 10px;
            padding: 12px 16px;
            box-shadow: 0 1px 3px rgba(15,110,86,0.05);
        }

        .filter-bar-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #085041;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .filter-date-input {
            padding: 7px 12px;
            border: 1.5px solid #c9e9de;
            border-radius: 8px;
            font-size: 0.8rem;
            color: #085041;
            background: #f4faf8;
            outline: none;
            transition: border-color 0.15s;
        }

        .filter-date-input:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29,158,117,0.1);
        }

        .btn-apply {
            padding: 7px 18px;
            background: #1D9E75;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-apply:hover { background: #085041; }

        .btn-reset {
            padding: 7px 18px;
            background: #E1F5EE;
            color: #085041;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-reset:hover { background: #9FE1CB; }

        .btn-export {
            padding: 7px 18px;
            background: #085041;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.15s;
        }

        .btn-export:hover { background: #0F6E56; }
    </style>

    <div class="py-6 max-w-7xl mx-auto px-6 sm:px-8">

        {{-- Date Range Filter + Export --}}
        <form method="GET" action="{{ route('reports.index') }}" class="filter-bar">
            <span class="filter-bar-label">Period</span>

            <div style="display:flex; align-items:center; gap:6px;">
                <label class="filter-bar-label" style="font-weight:500; text-transform:none; letter-spacing:0; color:#6b7280;">From</label>
                <input type="date" name="date_from"
                       value="{{ $dateFrom }}"
                       max="{{ date('Y-m-d') }}"
                       class="filter-date-input">
            </div>

            <div style="display:flex; align-items:center; gap:6px;">
                <label class="filter-bar-label" style="font-weight:500; text-transform:none; letter-spacing:0; color:#6b7280;">To</label>
                <input type="date" name="date_to"
                       value="{{ $dateTo }}"
                       max="{{ date('Y-m-d') }}"
                       class="filter-date-input">
            </div>

            <button type="submit" class="btn-apply">Apply</button>

            <a href="{{ route('reports.index') }}" class="btn-reset">Reset</a>

            <a href="{{ route('reports.export-pdf', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
               class="btn-export">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export PDF
            </a>
        </form>

        <div class="reports-grid">

            {{-- Stat Strip --}}
            <div class="stat-strip">
                <div class="stat-mini">
                    <div class="stat-mini-label">Total Revenue</div>
                    <div class="stat-mini-value">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-mini-sub">{{ \Carbon\Carbon::parse($dateFrom)->format('M d') }} — {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Transactions</div>
                    <div class="stat-mini-value">{{ $totalSales }}</div>
                    <div class="stat-mini-sub">Sales recorded</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Total Discounts</div>
                    <div class="stat-mini-value">₱{{ number_format($totalDiscounts, 2) }}</div>
                    <div class="stat-mini-sub">Given out</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-label">Avg Sale Value</div>
                    <div class="stat-mini-value">₱{{ number_format($avgSaleValue, 2) }}</div>
                    <div class="stat-mini-sub">Per transaction</div>
                </div>
            </div>

            {{-- Revenue Chart (col span 3) --}}
            <div class="panel" style="grid-column: span 3;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                    <div class="panel-title" style="margin-bottom:0;">Revenue Trend</div>
                    <div class="tab-group">
                        <button class="tab-btn active" onclick="switchChart('daily', this)">Daily</button>
                        <button class="tab-btn" onclick="switchChart('weekly', this)">Weekly</button>
                        <button class="tab-btn" onclick="switchChart('monthly', this)">Monthly</button>
                    </div>
                </div>
                <div class="panel-body" style="height: 200px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Stock Health --}}
            <div class="panel" style="grid-column: span 1;">
                <div class="panel-title">Stock Health</div>
                <div class="panel-body">
                    <div class="health-row">
                        <div>
                            <div class="health-label">Expired</div>
                            <div class="health-sub">Needs removal</div>
                        </div>
                        <span class="pill-red">{{ $expired->count() }}</span>
                    </div>
                    <div class="health-row">
                        <div>
                            <div class="health-label">Low Stock</div>
                            <div class="health-sub">Below reorder level</div>
                        </div>
                        <span class="pill-yellow">{{ $lowStock->count() }}</span>
                    </div>
                    <div class="health-row">
                        <div>
                            <div class="health-label">Near Expiry</div>
                            <div class="health-sub">Within 30 days</div>
                        </div>
                        <span class="pill-orange">{{ $nearExpiry->count() }}</span>
                    </div>
                    <div class="health-row">
                        <div>
                            <div class="health-label">Healthy Stock</div>
                            <div class="health-sub">All good</div>
                        </div>
                        <span class="pill-green">{{ $totalMedicines - $expired->count() - $lowStock->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Top Medicines --}}
            <div class="panel" style="grid-column: span 2;">
                <div class="panel-title">Top 5 Best Selling</div>
                <div class="panel-body">
                    @forelse($topMedicines as $index => $item)
                        <div class="rank-row">
                            <span class="rank-num">#{{ $index + 1 }}</span>
                            <span class="rank-name">{{ $item->medicine->name }}</span>
                            <span class="rank-val">{{ $item->total_qty }} sold</span>
                        </div>
                    @empty
                        <p style="font-size:0.8rem; color:#9FE1CB; text-align:center; padding:16px 0;">No data yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Payment Pie --}}
            <div class="panel" style="grid-column: span 1;">
                <div class="panel-title">Payment Methods</div>
                <div class="panel-body" style="height: 160px;">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>

            {{-- Discount Pie --}}
            <div class="panel" style="grid-column: span 1;">
                <div class="panel-title">Discount Types</div>
                <div class="panel-body" style="height: 160px;">
                    <canvas id="discountChart"></canvas>
                </div>
            </div>

            {{-- Sales Table (tabbed) --}}
            <div class="panel" style="grid-column: span 4;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                    <div class="panel-title" style="margin-bottom:0;">Sales Breakdown</div>
                    <div class="tab-group">
                        <button class="tab-btn active" onclick="switchTable('daily', this)">Daily</button>
                        <button class="tab-btn" onclick="switchTable('weekly', this)">Weekly</button>
                        <button class="tab-btn" onclick="switchTable('monthly', this)">Monthly</button>
                    </div>
                </div>

                {{-- Daily --}}
                <div id="table-daily">
                    <table class="mini-table">
                        <thead><tr><th>Date</th><th>Transactions</th><th>Revenue</th></tr></thead>
                        <tbody>
                            @forelse($dailySales as $day)
                                <tr>
                                    <td class="bold">{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                    <td>{{ $day->transactions }}</td>
                                    <td class="rev">₱{{ number_format($day->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="empty">No sales in selected period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Weekly --}}
                <div id="table-weekly" style="display:none;">
                    <table class="mini-table">
                        <thead><tr><th>Week</th><th>Transactions</th><th>Revenue</th></tr></thead>
                        <tbody>
                            @forelse($weeklySales as $week)
                                <tr>
                                    <td class="bold">Week {{ $week->week }}, {{ $week->year }}</td>
                                    <td>{{ $week->transactions }}</td>
                                    <td class="rev">₱{{ number_format($week->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="empty">No sales in selected period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Monthly --}}
                <div id="table-monthly" style="display:none;">
                    <table class="mini-table">
                        <thead><tr><th>Month</th><th>Transactions</th><th>Revenue</th></tr></thead>
                        <tbody>
                            @forelse($monthlySales as $month)
                                <tr>
                                    <td class="bold">{{ \Carbon\Carbon::createFromDate($month->year, $month->month, 1)->format('F Y') }}</td>
                                    <td>{{ $month->transactions }}</td>
                                    <td class="rev">₱{{ number_format($month->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="empty">No sales in selected period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        const dailyLabels   = @json($dailySales->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d')));
        const dailyData     = @json($dailySales->pluck('revenue'));
        const weeklyLabels  = @json($weeklySales->map(fn($w) => 'Wk '.$w->week));
        const weeklyData    = @json($weeklySales->pluck('revenue'));
        const monthlyLabels = @json($monthlySales->map(fn($m) => \Carbon\Carbon::createFromDate($m->year, $m->month, 1)->format('M Y')));
        const monthlyData   = @json($monthlySales->pluck('revenue'));

        const paymentLabels = @json($paymentBreakdown->pluck('payment_method')->map(fn($p) => strtoupper($p)));
        const paymentData   = @json($paymentBreakdown->pluck('count'));
        const discountLabels = @json($discountLabels);
        const discountData   = @json($discountBreakdown->pluck('count'));

        // ── Revenue Bar Chart ──
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        let revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Revenue',
                    data: dailyData,
                    backgroundColor: '#1D9E75',
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#3B6D11' } },
                    y: { grid: { color: '#f0faf6' }, ticks: { font: { size: 10 }, color: '#9FE1CB',
                         callback: v => '₱' + v.toLocaleString() } }
                }
            }
        });

        function switchChart(period, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => {
                if (b.onclick.toString().includes('switchChart')) b.classList.remove('active');
            });
            btn.classList.add('active');
            const map = {
                daily:   { labels: dailyLabels,   data: dailyData },
                weekly:  { labels: weeklyLabels,  data: weeklyData },
                monthly: { labels: monthlyLabels, data: monthlyData },
            };
            revenueChart.data.labels = map[period].labels;
            revenueChart.data.datasets[0].data = map[period].data;
            revenueChart.update();
        }

        // ── Payment Donut ──
        new Chart(document.getElementById('paymentChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: paymentLabels,
                datasets: [{
                    data: paymentData,
                    backgroundColor: ['#1D9E75','#085041','#9FE1CB','#3B6D11'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 10 }, color: '#085041', boxWidth: 10 } } }
            }
        });

        // ── Discount Donut ──
        new Chart(document.getElementById('discountChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: discountLabels,
                datasets: [{
                    data: discountData,
                    backgroundColor: ['#E1F5EE','#E6F1FB','#EEEDFE'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverBackgroundColor: ['#9FE1CB','#b3d4f5','#c5c3fc'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 10 }, color: '#085041', boxWidth: 10 } } }
            }
        });

        // ── Table Tabs ──
        function switchTable(period, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => {
                if (b.onclick.toString().includes('switchTable')) b.classList.remove('active');
            });
            btn.classList.add('active');
            ['daily','weekly','monthly'].forEach(p => {
                document.getElementById('table-' + p).style.display = p === period ? '' : 'none';
            });
        }
    </script>
</x-app-layout>
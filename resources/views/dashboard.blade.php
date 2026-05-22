<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Dashboard
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        /* ── Hero Banner ── */
        .dash-hero {
            background: linear-gradient(135deg, #085041 0%, #1D9E75 100%);
            border-radius: 16px;
            padding: 28px 32px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        @media (min-width: 768px) {
            .dash-hero { grid-template-columns: repeat(4, 1fr); }
        }

        .hero-stat { color: #ffffff; }

        .hero-stat-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            opacity: 0.65;
            margin-bottom: 6px;
        }

        .hero-stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .hero-stat-sub {
            font-size: 0.72rem;
            opacity: 0.5;
            margin-top: 3px;
        }

        .hero-divider {
            border-left: 1px solid rgba(255,255,255,0.15);
            padding-left: 24px;
        }

        /* ── Alert Panels ── */
        .panel {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.05);
        }

        .panel-header {
            padding: 12px 18px;
            border-bottom: 1px solid #E1F5EE;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .panel-count {
            font-size: 0.68rem;
            color: #9ca3af;
            font-weight: 500;
        }

        .panel-body { padding: 0; }

        .panel-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 18px;
            border-bottom: 1px solid #f0faf6;
        }

        .panel-row:last-child { border-bottom: none; }

        .panel-row-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #085041;
        }

        .panel-row-sub {
            font-size: 0.7rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        .badge-red {
            background: #FCEBEB;
            color: #791F1F;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .badge-yellow {
            background: #FEF9E7;
            color: #7D6008;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .badge-orange {
            background: #FEF0E6;
            color: #7E3400;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .panel-empty {
            text-align: center;
            padding: 28px;
            font-size: 0.8rem;
            color: #9ca3af;
        }

        /* ── Quick Actions ── */
        .quick-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.05);
        }

        .quick-title {
            font-size: 0.72rem;
            font-weight: 700;
            color: #085041;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
        }

        .btn-action-primary {
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 9px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-action-primary:hover { background-color: #085041; }

        .btn-action-secondary {
            background-color: #E1F5EE;
            color: #085041;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 9px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-action-secondary:hover { background-color: #9FE1CB; }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-6 sm:px-8 space-y-6">

        {{-- Hero Banner --}}
        <div class="dash-hero">
            <div class="hero-stat">
                <div class="hero-stat-label">Total Medicines</div>
                <div class="hero-stat-value">{{ $totalMedicines }}</div>
                <div class="hero-stat-sub">In inventory</div>
            </div>
            <div class="hero-stat hero-divider">
                <div class="hero-stat-label">Total Suppliers</div>
                <div class="hero-stat-value">{{ $totalSuppliers }}</div>
                <div class="hero-stat-sub">Active suppliers</div>
            </div>
            <div class="hero-stat hero-divider">
                <div class="hero-stat-label">Total Sales</div>
                <div class="hero-stat-value">{{ $totalSales }}</div>
                <div class="hero-stat-sub">Transactions</div>
            </div>
            <div class="hero-stat hero-divider">
                <div class="hero-stat-label">Total Revenue</div>
                <div class="hero-stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
                <div class="hero-stat-sub">All time</div>
            </div>
        </div>

        {{-- Alert Panels --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Expired --}}
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title" style="color: #791F1F;">Expired</span>
                    <span class="panel-count">{{ $expired->count() }} items</span>
                </div>
                <div class="panel-body">
                    @forelse($expired as $med)
                        <div class="panel-row">
                            <div>
                                <div class="panel-row-name">{{ $med->name }}</div>
                                <div class="panel-row-sub">
                                    Expired: {{ $med->expiry_date->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="badge-red">{{ $med->stock_qty }} left</span>
                        </div>
                    @empty
                        <div class="panel-empty">No expired medicines ✓</div>
                    @endforelse
                </div>
            </div>

            {{-- Low Stock --}}
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title" style="color: #7D6008;">Low Stock</span>
                    <span class="panel-count">{{ $lowStock->count() }} items</span>
                </div>
                <div class="panel-body">
                    @forelse($lowStock as $med)
                        <div class="panel-row">
                            <div>
                                <div class="panel-row-name">{{ $med->name }}</div>
                                <div class="panel-row-sub">
                                    Reorder at: {{ $med->reorder_level }}
                                </div>
                            </div>
                            <span class="badge-yellow">{{ $med->stock_qty }} left</span>
                        </div>
                    @empty
                        <div class="panel-empty">All stock levels are good ✓</div>
                    @endforelse
                </div>
            </div>

            {{-- Near Expiry --}}
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title" style="color: #7E3400;">Near Expiry</span>
                    <span class="panel-count">{{ $nearExpiry->count() }} items</span>
                </div>
                <div class="panel-body">
                    @forelse($nearExpiry as $med)
                        <div class="panel-row">
                            <div>
                                <div class="panel-row-name">{{ $med->name }}</div>
                                <div class="panel-row-sub">
                                    Expires: {{ $med->expiry_date->format('M d, Y') }}
                                </div>
                            </div>
                            {{-- false = signed value, so future dates are positive --}}
                           <span class="badge-orange">
                                {{ (int) ceil(now()->floatDiffInDays($med->expiry_date)) }} days
                            </span>
                        </div>
                    @empty
                        <div class="panel-empty">No medicines near expiry ✓</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="quick-card">
            <p class="quick-title">Quick Actions</p>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <a href="{{ route('medicines.create') }}"  class="btn-action-primary">+ Add Medicine</a>
                <a href="{{ route('suppliers.create') }}"  class="btn-action-primary">+ Add Supplier</a>
                <a href="{{ route('medicines.index') }}"   class="btn-action-secondary">View Medicines</a>
                <a href="{{ route('suppliers.index') }}"   class="btn-action-secondary">View Suppliers</a>
            </div>
        </div>

    </div>
</x-app-layout>
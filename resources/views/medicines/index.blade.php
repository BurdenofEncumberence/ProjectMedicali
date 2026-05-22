<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Medicines
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .medicine-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #c9e9de;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }
        .medicine-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(8, 80, 65, 0.12);
        }

        .medicine-img { width: 100%; height: 160px; object-fit: cover; background: #E1F5EE; }

        .medicine-img-placeholder {
            width: 100%; height: 160px; background: #E1F5EE;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
        }
        .medicine-img-placeholder svg   { color: #9FE1CB; }
        .medicine-img-placeholder span  { font-size: 0.75rem; color: #9FE1CB; font-weight: 500; }

        .medicine-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .medicine-name    { font-size: 1rem;  font-weight: 700; color: #085041; }
        .medicine-generic { font-size: 0.78rem; color: #1D9E75; font-weight: 500; }
        .medicine-meta    { display: flex; justify-content: space-between; align-items: center; margin-top: 6px; }
        .medicine-price   { font-size: 1.1rem; font-weight: 700; color: #085041; }
        .medicine-stock   { font-size: 0.75rem; color: #6b7280; }

        .medicine-footer {
            padding: 12px 16px; border-top: 1px solid #E1F5EE;
            display: flex; justify-content: space-between; align-items: center;
        }

        .badge { font-size: 0.7rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .badge-expired  { background: #fef2f2; color: #b91c1c; }
        .badge-low      { background: #fefce8; color: #854d0e; }
        .badge-expiring { background: #fff7ed; color: #9a3412; }
        .badge-good     { background: #f0fdf4; color: #15803d; }

        .btn-edit {
            font-size: 0.75rem; font-weight: 600; padding: 5px 12px; border-radius: 8px;
            background: #E1F5EE; color: #085041; text-decoration: none; border: none; cursor: pointer; transition: background 0.2s;
        }
        .btn-edit:hover { background: #9FE1CB; }

        .btn-delete {
            font-size: 0.75rem; font-weight: 600; padding: 5px 12px; border-radius: 8px;
            background: #fef2f2; color: #b91c1c; border: none; cursor: pointer; transition: background 0.2s;
        }
        .btn-delete:hover { background: #fecaca; }

        .btn-add {
            background: #085041; color: #ffffff; font-weight: 600; font-size: 0.875rem;
            padding: 10px 20px; border-radius: 10px; text-decoration: none;
            transition: background 0.2s; white-space: nowrap;
        }
        .btn-add:hover { background: #0F6E56; }

        .search-input {
            padding: 10px 16px; border: 1.5px solid #c9e9de; border-radius: 10px;
            font-size: 0.875rem; color: #085041; background: #ffffff;
            outline: none; width: 260px; transition: border-color 0.2s;
        }
        .search-input:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.1);
        }

        /* ── Collapsible Filter Panel ── */
        .filter-toggle-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 10px; border: 1.5px solid #c9e9de;
            background: #ffffff; color: #085041; font-size: 0.82rem; font-weight: 600;
            cursor: pointer; transition: all 0.18s; margin-bottom: 12px;
        }
        .filter-toggle-btn:hover { background: #E1F5EE; border-color: #1D9E75; }
        .filter-toggle-btn.has-active { background: #085041; color: #ffffff; border-color: #085041; }
        .filter-toggle-btn .arrow {
            transition: transform 0.25s ease;
            display: inline-block;
        }
        .filter-toggle-btn.open .arrow { transform: rotate(180deg); }

        .filter-panel {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.35s ease, opacity 0.25s ease, margin-bottom 0.25s ease;
            margin-bottom: 0;
        }
        .filter-panel.open {
            max-height: 300px;
            opacity: 1;
            margin-bottom: 20px;
        }

        .filter-panel-inner {
            background: #ffffff;
            border: 1.5px solid #c9e9de;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .filter-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

        .filter-row-label {
            font-size: 0.7rem; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.6px;
            white-space: nowrap; min-width: 60px;
        }

        .filter-btn {
            padding: 5px 14px; border-radius: 20px; border: 1.5px solid #c9e9de;
            background: #ffffff; color: #085041; font-size: 0.78rem; font-weight: 600;
            cursor: pointer; transition: all 0.18s; white-space: nowrap;
        }
        .filter-btn:hover  { background: #E1F5EE; border-color: #1D9E75; }
        .filter-btn.active { background: #085041; color: #ffffff; border-color: #085041; }

        .active-summary {
            font-size: 0.75rem; color: #1D9E75; font-weight: 500;
            margin-left: 4px;
        }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-6 sm:px-8">

        @if(session('success'))
            <div style="background: #E1F5EE; color: #085041; border: 1px solid #9FE1CB; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.875rem; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Top bar --}}
        <div class="flex justify-between items-center mb-5">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #085041;">All Medicines</h3>
                <p style="font-size: 0.8rem; color: #6b7280; margin-top: 2px;">{{ $medicines->total() }} medicines total</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <input type="text" id="searchInput" class="search-input"
                       placeholder="Search medicine..."
                       onkeyup="filterCards()">
                @role('admin|inventory_manager')
                    <a href="{{ route('medicines.create') }}" class="btn-add">+ Add Medicine</a>
                @endrole
            </div>
        </div>

        {{-- Filter toggle button --}}
        <button id="filterToggleBtn" class="filter-toggle-btn" onclick="toggleFilterPanel()">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/>
                <line x1="11" y1="18" x2="13" y2="18"/>
            </svg>
            Filters
            <span id="activeSummary" class="active-summary" style="display:none;"></span>
            <span class="arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </span>
        </button>

        {{-- Collapsible Filter Panel --}}
        <div id="filterPanel" class="filter-panel">
            <div class="filter-panel-inner">
                {{-- Category --}}
                <div class="filter-row">
                    <span class="filter-row-label">Category</span>
                    <button class="filter-btn active" onclick="filterCategory('all', this)">All</button>
                    <button class="filter-btn" onclick="filterCategory('analgesic', this)">Analgesic</button>
                    <button class="filter-btn" onclick="filterCategory('antibiotic', this)">Antibiotic</button>
                    <button class="filter-btn" onclick="filterCategory('antacid', this)">Antacid</button>
                    <button class="filter-btn" onclick="filterCategory('antihistamine', this)">Antihistamine</button>
                    <button class="filter-btn" onclick="filterCategory('vitamins', this)">Vitamins</button>
                    <button class="filter-btn" onclick="filterCategory('controlled', this)">Controlled</button>
                    <button class="filter-btn" onclick="filterCategory('others', this)">Others</button>
                </div>
                {{-- Status --}}
                <div class="filter-row">
                    <span class="filter-row-label">Status</span>
                    <button class="filter-btn filter-status active" onclick="filterStatus('all-status', this)">All</button>
                    <button class="filter-btn filter-status" onclick="filterStatus('good', this)">Good</button>
                    <button class="filter-btn filter-status" onclick="filterStatus('low', this)">Low Stock</button>
                    <button class="filter-btn filter-status" onclick="filterStatus('expiring', this)">Near Expiry</button>
                    <button class="filter-btn filter-status" onclick="filterStatus('expired', this)">Expired</button>
                </div>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div id="medicineGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            @forelse($medicines as $medicine)
                <div class="medicine-card"
                     data-name="{{ strtolower($medicine->name) }} {{ strtolower($medicine->generic_name) }}"
                     data-category="{{ strtolower($medicine->category) }}"
                     data-status="@if($medicine->expiry_date->isPast()) expired @elseif($medicine->stock_qty <= $medicine->reorder_level) low @elseif($medicine->expiry_date->diffInDays(now()) <= 30) expiring @else good @endif">

                    @if($medicine->image)
                        <img src="{{ $medicine->image }}" alt="{{ $medicine->name }}" class="medicine-img">                   
                        @else
                        <div class="medicine-img-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                            <span>No image</span>
                        </div>
                    @endif

                    <div class="medicine-body">
                        <div class="medicine-name">{{ $medicine->name }}</div>
                        <div class="medicine-generic">{{ $medicine->generic_name }} · {{ $medicine->brand }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $medicine->category }}</div>
                        <div class="medicine-meta">
                            <div class="medicine-price">₱{{ number_format($medicine->price, 2) }}</div>
                            <div class="medicine-stock">{{ $medicine->stock_qty }} in stock</div>
                        </div>
                        <div style="font-size: 0.72rem; color: #9ca3af; margin-top: 2px;">
                            Expires {{ $medicine->expiry_date->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="medicine-footer">
                        @if($medicine->expiry_date->isPast())
                            <span class="badge badge-expired">Expired</span>
                        @elseif($medicine->stock_qty <= $medicine->reorder_level)
                            <span class="badge badge-low">Low Stock</span>
                        @elseif($medicine->expiry_date->lte(now()->addDays(30)))

                            <span class="badge badge-expiring">Near Expiry</span>
                        @else
                            <span class="badge badge-good">Good</span>
                        @endif

                        @role('admin|inventory_manager')
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('medicines.edit', $medicine) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" onsubmit="return confirm('Delete this medicine?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        @endrole
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #9ca3af;">
                    No medicines yet. Add your first one!
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $medicines->links() }}</div>

    </div>

    <script>
        let activeCategory = 'all';
        let activeStatus = 'all-status';
        let filterOpen = false;

        function toggleFilterPanel() {
            filterOpen = !filterOpen;
            const panel = document.getElementById('filterPanel');
            const btn   = document.getElementById('filterToggleBtn');
            panel.classList.toggle('open', filterOpen);
            btn.classList.toggle('open', filterOpen);
        }

        function updateToggleBtn() {
            const btn     = document.getElementById('filterToggleBtn');
            const summary = document.getElementById('activeSummary');
            const hasFilters = activeCategory !== 'all' || activeStatus !== 'all-status';
            btn.classList.toggle('has-active', hasFilters);

            if (hasFilters) {
                let parts = [];
                if (activeCategory !== 'all')     parts.push(activeCategory);
                if (activeStatus  !== 'all-status') parts.push(activeStatus);
                summary.textContent = '· ' + parts.join(', ');
                summary.style.display = 'inline';
            } else {
                summary.style.display = 'none';
            }
        }

        function filterCards() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#medicineGrid .medicine-card').forEach(card => {
                const matchSearch   = card.getAttribute('data-name').includes(query);
                const matchCategory = activeCategory === 'all' || card.getAttribute('data-category') === activeCategory;
                const matchStatus   = activeStatus === 'all-status' || card.getAttribute('data-status') === activeStatus;
                card.style.display  = (matchSearch && matchCategory && matchStatus) ? 'flex' : 'none';
            });
        }

        function filterCategory(category, btn) {
            activeCategory = category;
            document.querySelectorAll('.filter-btn:not(.filter-status)').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            updateToggleBtn();
            filterCards();
        }

        function filterStatus(status, btn) {
            activeStatus = status;
            document.querySelectorAll('.filter-btn.filter-status').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            updateToggleBtn();
            filterCards();
        }
    </script>

</x-app-layout>
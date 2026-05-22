<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Suppliers
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

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

        .btn-new {
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 9px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s;
        }

        .btn-new:hover { background-color: #085041; }

        .btn-edit {
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

        .btn-edit:hover { background-color: #9FE1CB; }

        .btn-delete {
            background-color: #FCEBEB;
            color: #791F1F;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .btn-delete:hover { background-color: #F09595; color: #fff; }

        .alert-success {
            background: #E1F5EE;
            color: #085041;
            border: 1px solid #9FE1CB;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.875rem;
            font-weight: 600;
        }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-6 sm:px-8">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-base font-semibold" style="color: #085041;">All Suppliers</h3>
            @role('admin|inventory_manager')
                <a href="{{ route('suppliers.create') }}" class="btn-new">+ Add Supplier</a>
            @endrole
        </div>

        <div class="med-card">
            <table class="med-table w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td class="muted">{{ $loop->iteration }}</td>
                            <td style="font-weight: 600;">{{ $supplier->name }}</td>
                            <td class="muted">{{ $supplier->contact }}</td>
                            <td class="muted">{{ $supplier->address }}</td>
                            <td>
                                @role('admin|inventory_manager')
                                    <div style="display: flex; gap: 6px; align-items: center;">
                                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn-edit">Edit</a>
                                        <form action="{{ route('suppliers.destroy', $supplier) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this supplier?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                @endrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 32px; color: #9FE1CB; font-size: 0.875rem;">
                                No suppliers yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</x-app-layout>
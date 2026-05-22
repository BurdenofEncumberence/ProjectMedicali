<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Add Supplier
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .med-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.06);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .med-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #085041;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .med-input {
            width: 100%;
            border: 1px solid #9FE1CB;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 0.875rem;
            color: #085041;
            background-color: #f4faf8;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .med-input:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.15);
        }

        .med-input::placeholder { color: #9FE1CB; }

        .btn-save {
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

        .btn-save:hover { background-color: #085041; }

        .btn-cancel {
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

        .btn-cancel:hover { background-color: #9FE1CB; }

        .alert-error {
            background: #FCEBEB;
            color: #791F1F;
            border: 1px solid #F09595;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.875rem;
        }

        .field-group { display: flex; flex-direction: column; }
    </style>

    <div class="py-8 max-w-2xl mx-auto px-6 sm:px-8">

        @if($errors->any())
            <div class="alert-error">
                <ul style="list-style: disc; padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="med-card">

                <div class="field-group">
                    <label class="med-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Unilab Inc."
                           class="med-input">
                </div>

                <div class="field-group">
                    <label class="med-label">Contact</label>
                    <input type="text" name="contact" value="{{ old('contact') }}"
                           placeholder="e.g. 09171234567"
                           class="med-input">
                </div>

                <div class="field-group">
                    <label class="med-label">Address</label>
                    <textarea name="address" rows="3"
                              placeholder="e.g. 123 Rizal St., Davao City"
                              class="med-input">{{ old('address') }}</textarea>
                </div>

                <div style="display: flex; gap: 12px; padding-top: 4px;">
                    <button type="submit" class="btn-save">Save Supplier</button>
                    <a href="{{ route('suppliers.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
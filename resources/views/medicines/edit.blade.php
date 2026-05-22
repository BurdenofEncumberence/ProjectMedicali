<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Edit Medicine
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

        .med-input, .med-select {
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

        .med-input:focus, .med-select:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.15);
        }

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

        .field-group { display: flex; flex-direction: column; gap: 4px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

        .image-upload-area {
            border: 2px dashed #9FE1CB;
            border-radius: 8px;
            padding: 24px;
            text-align: center;
            background: #f4faf8;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
        }
        .image-upload-area:hover { border-color: #1D9E75; background: #eaf7f2; }
        .image-preview {
            width: 100%; max-height: 180px; object-fit: cover;
            border-radius: 8px; margin-top: 10px;
        }
    </style>

    <div class="py-8 max-w-3xl mx-auto px-6 sm:px-8">

        @if($errors->any())
            <div class="alert-error">
                <ul style="list-style: disc; padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('medicines.update', $medicine) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="med-card" style="display: flex; flex-direction: column; gap: 20px;">

                {{-- Image Upload --}}
                <div class="field-group">
                    <label class="med-label">Medicine Image</label>
                    <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                        <input type="file" id="imageInput" name="image" accept="image/*"
                               onchange="previewImage(event)" style="display:none;">
                        @if($medicine->image)
                            <img id="imagePreview" src="{{ $medicine->image }}" class="image-preview">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                 fill="none" stroke="#9FE1CB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <p style="font-size:0.8rem; color:#9FE1CB; margin-top:8px;">Click to replace image</p>
                            <img id="imagePreview" class="image-preview" style="display:none;">
                        @endif
                    </div>
                </div>

                {{-- Supplier --}}
                <div class="field-group">
                    <label class="med-label">Supplier</label>
                    <select name="supplier_id" class="med-select">
                        <option value="">-- Select Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $medicine->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Name & Generic --}}
                <div class="grid-2">
                    <div class="field-group">
                        <label class="med-label">Medicine Name</label>
                        <input type="text" name="name" value="{{ old('name', $medicine->name) }}" class="med-input">
                    </div>
                    <div class="field-group">
                        <label class="med-label">Generic Name</label>
                        <input type="text" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}" class="med-input">
                    </div>
                </div>

                {{-- Brand & Category --}}
                <div class="grid-2">
                    <div class="field-group">
                        <label class="med-label">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand', $medicine->brand) }}" class="med-input">
                    </div>
                    <div class="field-group">
                        <label class="med-label">Category</label>
                        <select name="category" class="med-select">
                            <option value="">-- Select Category --</option>
                            @foreach(['Analgesic','Antibiotic','Antacid','Antihistamine','Vitamins','Controlled','Others'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $medicine->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Price, Stock, Reorder --}}
                <div class="grid-3">
                    <div class="field-group">
                        <label class="med-label">Price (₱)</label>
                        <input type="number" name="price" value="{{ old('price', $medicine->price) }}" step="0.01" min="0" class="med-input">
                    </div>
                    <div class="field-group">
                        <label class="med-label">Stock Qty</label>
                        <input type="number" name="stock_qty" value="{{ old('stock_qty', $medicine->stock_qty) }}" min="0" class="med-input">
                    </div>
                    <div class="field-group">
                        <label class="med-label">Reorder Level</label>
                        <input type="number" name="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level) }}" min="1" class="med-input">
                    </div>
                </div>

                {{-- Expiry Date --}}
                <div class="field-group">
                    <label class="med-label">Expiry Date</label>
                    <input type="date" name="expiry_date"
                           value="{{ old('expiry_date', $medicine->expiry_date->format('Y-m-d')) }}"
                           class="med-input">
                </div>

                {{-- Buttons --}}
                <div style="display: flex; gap: 12px; padding-top: 4px;">
                    <button type="submit" class="btn-save">Update Medicine</button>
                    <a href="{{ route('medicines.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    </script>
</x-app-layout>
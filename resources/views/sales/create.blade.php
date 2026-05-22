<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            New Prescription
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

        .med-label-hint {
            font-size: 0.7rem;
            color: #9FE1CB;
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
            margin-left: 6px;
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

        .med-input::placeholder { color: #9FE1CB; }

        .med-input-danger {
            border-color: #F09595;
            background-color: #fff8f8;
        }

        .med-input-danger:focus {
            border-color: #E24B4A;
            box-shadow: 0 0 0 3px rgba(226, 75, 74, 0.15);
        }

        .s2-notice {
            background: #FCEBEB;
            border: 1px solid #F09595;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.75rem;
            color: #791F1F;
            font-weight: 600;
            margin-bottom: 8px;
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

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
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

        <form action="{{ route('prescriptions.store') }}" method="POST">
            @csrf

            <div class="med-card">

                <div class="field-group">
                    <label class="med-label">Medicine</label>
                    <select name="medicine_id" id="medicine_id"
                            class="med-select"
                            onchange="checkControlled(this)">
                        <option value="">-- Select Medicine --</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}"
                                    data-category="{{ $medicine->category }}"
                                    {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
                                {{ $medicine->name }} ({{ $medicine->category }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid-2">
                    <div class="field-group">
                        <label class="med-label">Patient Name</label>
                        <input type="text" name="patient_name" value="{{ old('patient_name') }}"
                               placeholder="e.g. Juan Dela Cruz" class="med-input">
                    </div>
                    <div class="field-group">
                        <label class="med-label">Doctor Name</label>
                        <input type="text" name="doctor_name" value="{{ old('doctor_name') }}"
                               placeholder="e.g. Dr. Santos" class="med-input">
                    </div>
                </div>

                <div id="s2_field" class="hidden">
                    <div class="s2-notice">
                        Controlled substance selected — S2 License Number is required.
                    </div>
                    <label class="med-label">S2 License Number</label>
                    <input type="text" name="s2_license" value="{{ old('s2_license') }}"
                           placeholder="e.g. S2-12345"
                           class="med-input med-input-danger">
                </div>

                <div class="field-group">
                    <label class="med-label">Prescription Date</label>
                    <input type="date" name="prescription_date" value="{{ old('prescription_date') }}"
                           class="med-input">
                </div>

                <div style="display: flex; gap: 12px; padding-top: 4px;">
                    <button type="submit" class="btn-save">Save Prescription</button>
                    <a href="{{ route('prescriptions.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </div>
        </form>
    </div>

    <script>
        function checkControlled(select) {
            const selected = select.options[select.selectedIndex];
            const category = selected.getAttribute('data-category');
            const s2Field = document.getElementById('s2_field');
            if (category === 'Controlled') {
                s2Field.classList.remove('hidden');
            } else {
                s2Field.classList.add('hidden');
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('medicine_id');
            if (select.value) checkControlled(select);
        });
    </script>
</x-app-layout>
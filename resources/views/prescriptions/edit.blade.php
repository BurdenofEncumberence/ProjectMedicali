<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Edit Prescription
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

        <form action="{{ route('prescriptions.update', $prescription) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="med-card">

                {{-- Medicine --}}
                <div class="field-group">
                    <label class="med-label">Medicine</label>
                    <select name="medicine_id" class="med-select">
                        <option value="">-- Select Medicine --</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}"
                                    {{ old('medicine_id', $prescription->medicine_id) == $medicine->id ? 'selected' : '' }}>
                                {{ $medicine->name }} ({{ $medicine->category }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Patient & Doctor --}}
                <div class="grid-2">
                    <div class="field-group">
                        <label class="med-label">Patient Name</label>
                        <input type="text" name="patient_name"
                               value="{{ old('patient_name', $prescription->patient_name) }}"
                               class="med-input">
                    </div>
                    <div class="field-group">
                        <label class="med-label">Doctor Name</label>
                        <input type="text" name="doctor_name"
                               value="{{ old('doctor_name', $prescription->doctor_name) }}"
                               class="med-input">
                    </div>
                </div>

                {{-- S2 License --}}
                <div class="field-group">
                    <label class="med-label">
                        S2 License Number
                        <span class="med-label-hint">(leave blank if not controlled)</span>
                    </label>
                    <input type="text" name="s2_license"
                           value="{{ old('s2_license', $prescription->s2_license) }}"
                           placeholder="e.g. S2-12345"
                           class="med-input">
                </div>

                {{-- Prescription Date --}}
                <div class="field-group">
                    <label class="med-label">Prescription Date</label>
                    <input type="date" name="prescription_date"
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('prescription_date', $prescription->prescription_date->format('Y-m-d')) }}"
                        class="med-input">
                </div>

                {{-- Buttons --}}
                <div style="display: flex; gap: 12px; padding-top: 4px;">
                    <button type="submit" class="btn-save">Update Prescription</button>
                    <a href="{{ route('prescriptions.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
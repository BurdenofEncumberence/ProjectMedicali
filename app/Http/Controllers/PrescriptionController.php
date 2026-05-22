<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with('medicine')
            ->latest()
            ->paginate(10);

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('prescriptions.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id'       => 'required|exists:medicines,id',
            'patient_name'      => 'required|string|max:150',
            'doctor_name'       => 'required|string|max:150',
            'prescription_date' => 'required|date|before_or_equal:today',
            's2_license'        => [
                'nullable',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request) {
                    $medicine = Medicine::find($request->medicine_id);
                    if ($medicine && $medicine->category === 'Controlled' && empty($value)) {
                        $fail('S2 License number is required for controlled substances.');
                    }
                }
            ],
        ]);

        Prescription::create($request->all());

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription recorded successfully!');
    }

    public function edit(Prescription $prescription)
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('prescriptions.edit', compact('prescription', 'medicines'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'medicine_id'       => 'required|exists:medicines,id',
            'patient_name'      => 'required|string|max:150',
            'doctor_name'       => 'required|string|max:150',
            'prescription_date' => 'required|date|after_or_equal:today',
            's2_license'        => 'nullable|string|max:50',
        ]);

        $prescription->update($request->all());

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription updated successfully!');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription deleted successfully!');
    }
}
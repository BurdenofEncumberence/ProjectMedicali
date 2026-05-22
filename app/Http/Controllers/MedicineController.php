<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with('supplier')->latest()->paginate(10);

        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        $suppliers = Supplier::all();

        return view('medicines.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'name'          => 'required|string|max:150',
            'generic_name'  => 'required|string|max:150',
            'brand'         => 'required|string|max:100',
            'category'      => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'stock_qty'     => 'required|integer|min:0',
            'expiry_date'   => 'required|date|after:today',
            'reorder_level' => 'required|integer|min:1',
            'image'         => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        // Upload image to Cloudinary
        if ($request->hasFile('image')) {
            $path = Storage::disk('cloudinary')->putFile('medicines', $request->file('image'));
            $data['image'] = Storage::disk('cloudinary')->url($path);
        }

        Medicine::create($data);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicine added successfully!');
    }

    public function edit(Medicine $medicine)
    {
        $suppliers = Supplier::all();

        return view('medicines.edit', compact('medicine', 'suppliers'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'name'          => 'required|string|max:150',
            'generic_name'  => 'required|string|max:150',
            'brand'         => 'required|string|max:100',
            'category'      => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'stock_qty'     => 'required|integer|min:0',
            'expiry_date'   => 'required|date',
            'reorder_level' => 'required|integer|min:1',
            'image'         => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        // Replace old image
        if ($request->hasFile('image')) {

            // Delete old image from Cloudinary
            if ($medicine->image) {
                $publicId = $this->extractPublicId($medicine->image);
                if ($publicId) {
                    Storage::disk('cloudinary')->delete($publicId);
                }
            }

            // Upload new image
            $path = Storage::disk('cloudinary')->putFile('medicines', $request->file('image'));
            $data['image'] = Storage::disk('cloudinary')->url($path);
        }

        $medicine->update($data);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicine updated successfully!');
    }

    public function destroy(Medicine $medicine)
    {
        // Delete image from Cloudinary
        if ($medicine->image) {
            $publicId = $this->extractPublicId($medicine->image);
            if ($publicId) {
                Storage::disk('cloudinary')->delete($publicId);
            }
        }

        $medicine->delete();

        return redirect()
            ->route('medicines.index')
            ->with('success', 'Medicine deleted successfully!');
    }

    /**
     * Extract Cloudinary public_id from URL
     * Example: medicines/abc123
     */
    private function extractPublicId(string $url): string
    {
        $parts = explode('/upload/', $url);

        if (!isset($parts[1])) {
            return '';
        }

        $path = preg_replace('/^v\d+\//', '', $parts[1]);

        return pathinfo($path, PATHINFO_DIRNAME) . '/' .
               pathinfo($path, PATHINFO_FILENAME);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
  
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

  
    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'contact' => 'required|string|max:100',
            'address' => 'required|string',
        ]);

        Supplier::create($request->only('name', 'contact', 'address'));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier added successfully!');
    }

    
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'contact' => 'required|string|max:100',
            'address' => 'required|string',
        ]);

        $supplier->update($request->only('name', 'contact', 'address'));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

   
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}
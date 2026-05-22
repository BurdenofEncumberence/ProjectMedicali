<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MedicineController;    
use App\Http\Controllers\DashboardController;    
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // All roles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile — all roles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Suppliers — admin and inventory manager only
    Route::resource('suppliers', SupplierController::class)
        ->middleware('role:admin|inventory_manager');

    // Medicines — admin and inventory manager only
    Route::resource('medicines', MedicineController::class)
        ->middleware('role:admin|inventory_manager');

    // Prescriptions — admin and pharmacist only
    Route::resource('prescriptions', PrescriptionController::class)
        ->middleware('role:admin|pharmacist');

    // Checkout — admin and cashier only
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')
        ->middleware('role:admin|cashier');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')
        ->middleware('role:admin|cashier');
    Route::get('/checkout/receipt/{sale}', [CheckoutController::class, 'receipt'])->name('checkout.receipt')
        ->middleware('role:admin|cashier');

    // Sales — admin, cashier, inventory manager
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index')
        ->middleware('role:admin|cashier|inventory_manager');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show')
        ->middleware('role:admin|cashier|inventory_manager');

    // Reports — admin and inventory manager only
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')
        ->middleware('role:admin|inventory_manager');

    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');

});

require __DIR__.'/auth.php';
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('generic_name');
            $table->string('brand');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->integer('stock_qty')->default(0);
            $table->date('expiry_date');
            $table->integer('reorder_level')->default(10);
            $table->string('image')->nullable();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};

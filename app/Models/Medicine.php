<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'generic_name',
        'brand',
        'category',
        'price',
        'stock_qty',
        'expiry_date',
        'reorder_level',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'price'       => 'decimal:2',
        ];
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_qty', '<=', 'reorder_level')
                     ->whereDate('expiry_date', '>=', today());
    }

    public function scopeNearExpiry($query)
    {
        return $query->whereDate('expiry_date', '>=', today())
                     ->whereDate('expiry_date', '<=', today()->addDays(30));
    }

    // Scope: already expired
    public function scopeExpired($query)
    {
        return $query->whereDate('expiry_date', '<', today());
    }
}
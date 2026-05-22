<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'discount_type',
        'discount_amount',
        'payment_method',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'discount_amount' => 'decimal:2',
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
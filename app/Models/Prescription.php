<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'patient_name',
        'doctor_name',
        's2_license',
        'prescription_date',
    ];

    protected function casts(): array
    {
        return [
            'prescription_date' => 'date',
        ];
    }

  
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
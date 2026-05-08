<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilNutrient extends Model
{
    protected $fillable = [
        'block_id',
        'nitrogen',
        'phosphorus',
        'potassium',
        'ph',
        'magnesium',
        'organic_carbon',
        'measured_at'
    ];

    protected $casts = [
        'measured_at' => 'date',
        'nitrogen' => 'decimal:3',
        'phosphorus' => 'decimal:3',
        'potassium' => 'decimal:3',
        'ph' => 'decimal:2',
        'magnesium' => 'decimal:3',
        'organic_carbon' => 'decimal:3',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}

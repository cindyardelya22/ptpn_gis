<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilNutrient extends Model
{
    protected $fillable = [
        'block_id',

        // Unsur utama
        'nitrogen',
        'phosphorus',
        'potassium',

        // Tanah
        'ph',
        'ec',

        // Organik & mikro
        'organic_carbon',
        's',
        'magnesium',
        'boron',

        'measured_at'
    ];

    protected $casts = [
        'measured_at' => 'date',

        'nitrogen' => 'decimal:3',
        'phosphorus' => 'decimal:3',
        'potassium' => 'decimal:3',

        'ph' => 'decimal:2',
        'ec' => 'decimal:2',

        'organic_carbon' => 'decimal:3',
        's' => 'decimal:3',
        'magnesium' => 'decimal:3',
        'boron' => 'decimal:3',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
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

        'measured_at',

        // Status kesuburan dari ML
        'fertility_status',
        'fertility_color',
        'fertility_probabilities',

        // rekomendasi pemupukan (array of index yang sudah dicentang)
        'recommendation_progress',
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

        'fertility_probabilities' => 'array',
        'recommendation_progress' => 'array',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}

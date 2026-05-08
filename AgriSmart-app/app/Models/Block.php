<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Block extends Model
{
    protected $fillable = ['name', 'area_ha', 'planted_at', 'polygon_coords'];

    protected $casts = [
        'polygon_coords' => 'array',
        'area_ha' => 'decimal:2',
        'planted_at' => 'date',
    ];

    public function nutrients(): HasMany
    {
        return $this->hasMany(SoilNutrient::class);
    }

    public function latestNutrient()
    {
        return $this->nutrients()->latest('measured_at')->first();
    }
}

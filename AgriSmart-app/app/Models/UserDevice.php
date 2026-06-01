<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'device_name',
        'browser',
        'platform',
        'ip_address',
        'user_agent',
        'last_activity_at',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'last_activity_at' => 'datetime',
            'is_current' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
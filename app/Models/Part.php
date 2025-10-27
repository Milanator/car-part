<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Part extends Model
{
    protected $fillable = [
        'name',
        'serial_number',
        'car_id',
    ];

    /**
     * Relations
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}

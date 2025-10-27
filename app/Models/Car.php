<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        'name',
        'registration_number',
        'is_registered',
    ];

    /**
     * Relations
     */
    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }
}

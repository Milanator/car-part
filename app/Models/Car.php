<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        'name',
        'registration_number',
        'is_registered',
    ];

    protected $appends = ['is_registered_text'];

    /**
     * Relations
     */
    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }

    protected function isRegisteredText(): Attribute
    {
        return Attribute::make(get: fn (): string => $this->is_registered ? __('Yes') : __('No'));
    }
}

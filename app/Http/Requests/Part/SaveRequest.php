<?php

namespace App\Http\Requests\Part;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => [],
            'name' => ['required'],
            'serial_number' => [],
        ];
    }
}

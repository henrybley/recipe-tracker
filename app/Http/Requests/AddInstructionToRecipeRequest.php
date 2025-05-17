<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddInstructionToRecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'instruction' => 'required|string',
        ];
    }
}

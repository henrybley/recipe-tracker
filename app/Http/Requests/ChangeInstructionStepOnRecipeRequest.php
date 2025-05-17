<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeInstructionStepOnRecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'newStep' => 'required|integer',
        ];
    }
}

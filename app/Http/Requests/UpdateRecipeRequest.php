<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => "required|uuid|in:{$this->route('id')}",
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddIngredientToRecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ingredientId' => "required|uuid",
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ];
    }
}

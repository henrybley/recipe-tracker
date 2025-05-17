<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeSearchRequest extends FormRequest {

    public  function rules(): array
    {
        return [
            'ingredients' => 'sometimes|array',
            'ingredients.*' => 'uuid'
        ];
    }

    public function getIngredients(): array
    {
        return $this->query('ingredients', []);
    }
}

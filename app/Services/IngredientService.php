<?php

namespace App\Services;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class IngredientService
{
    public function getAll(): Collection
    {
        return Ingredient::all();
    }

    public function getById(string $id): Ingredient
    {
        $ingredient = Ingredient::findOrFail($id);

        return $ingredient;
    }

    public function create(array $request): Ingredient
    {
        return Ingredient::create([
            'name' => $request['name'],
        ]);
    }

    public function delete(string $id): void {
        $ingredient = $this->getById($id);

        $ingredient->delete();
    }

    public function update(string $id, array $request): Ingredient {
        $ingredient = $this->getById($id);

        $ingredient->name = $request['name'];

        $ingredient->saveOrFail();

        return $ingredient;
    }
}

<?php

namespace App\Repositories\Impl;

use App\Models\Ingredient;
use App\Repositories\IngredientRepository;
use Illuminate\Support\Collection;

class EloquentIngredientRepository implements IngredientRepository
{
    public function all(): Collection
    {
        return Ingredient::all();
    }

    public function findById(string $id): Ingredient
    {
        return Ingredient::findOrFail($id);
    }

    public function create(array $attributes): Ingredient
    {
        return Ingredient::create($attributes);
    }

    public function save(Ingredient $ingredient): Ingredient
    {
        $ingredient->saveOrFail();

        return $ingredient;
    }

    public function delete(Ingredient $ingredient): void
    {
        $ingredient->delete();
    }
}


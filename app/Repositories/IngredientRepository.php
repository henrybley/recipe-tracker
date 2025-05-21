<?php

namespace App\Repositories;

use App\Models\Ingredient;
use Illuminate\Support\Collection;

interface IngredientRepository
{
    public function all(): Collection;

    public function findById(string $id): Ingredient;

    public function create(array $data): Ingredient;

    public function save(Ingredient $ingredient): Ingredient;

    public function delete(Ingredient $ingredient): void;
}

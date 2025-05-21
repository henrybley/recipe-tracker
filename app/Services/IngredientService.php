<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Repositories\IngredientRepository;
use Illuminate\Database\Eloquent\Collection;

class IngredientService
{

    private IngredientRepository $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function findAll(): Collection
    {
        return $this->ingredientRepository->all();
    }

    public function findById(string $id): Ingredient
    {
        $ingredient = $this->ingredientRepository->findById($id);

        return $ingredient;
    }

    public function create(array $request): Ingredient
    {
        return $this->ingredientRepository->create([
            'name' => $request['name'],
        ]);
    }

    public function delete(string $id): void {
        $ingredient = $this->findById($id);

        $this->ingredientRepository->delete($ingredient);
    }

    public function update(string $id, array $request): Ingredient {
        $ingredient = $this->findById($id);

        $ingredient->name = $request['name'];

        $this->ingredientRepository->save($ingredient);

        return $ingredient;
    }
}

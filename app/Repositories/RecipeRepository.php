<?php

namespace App\Repositories;

use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Support\Collection;

interface RecipeRepository
{
    public function all(): Collection;

    public function findWithIngredients(array $ingredientUuids): Collection;

    public function findById(string $id): Recipe;

    public function create(array $data): Recipe;

    public function save(Recipe $recipe): Recipe;

    public function delete(string $id): void;

    public function reorderInstructions(Recipe $recipe, Instruction $movingInstruction, int $newStep): void;

    public function addIngredient(Recipe $recipe, string $ingredientId, string $quantity, string $unit): void;

    public function addInstruction(Recipe $recipe, string $instructionText): Instruction;
}

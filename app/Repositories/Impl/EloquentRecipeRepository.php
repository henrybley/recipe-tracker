<?php

namespace App\Repositories\Impl;

use App\Models\Ingredient;
use App\Models\Instruction;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use DB;
use Illuminate\Support\Collection;

class EloquentRecipeRepository implements RecipeRepository
{
    public function all(): Collection
    {
        return Recipe::all();
    }

    public function findWithIngredients(array $ingredientUuids): Collection
    {
        return Recipe::whereHas(
            'ingredients',
            function ($query) use ($ingredientUuids) {
                $query->whereIn('ingredients.id', $ingredientUuids);
            })->get();
    }

    public function findById(string $id): Recipe
    {
        return Recipe::with([
            'ingredients',
            'instructions' => function ($query) {
                $query->orderBy('step', 'asc');
            },
        ])->findOrFail($id);
    }

    public function create(array $attributes): Recipe
    {
        return Recipe::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ]);
    }

    public function save(Recipe $recipe): Recipe
    {
        $recipe->saveOrFail();
    }

    public function delete(string $id): void
    {
    }

    public function reorderInstructions(Recipe $recipe, Instruction $movingInstruction, int $newStep): void
    {
        DB::transaction(function () use ($recipe, $movingInstruction, $newStep) {
            $instructions = $recipe->instructions()
                ->orderBy('step')->get()->filter(fn ($i) => $i->id !== $movingInstruction->id);
            $instructions->splice($newStep, 0, [$movingInstruction]);

            foreach ($instructions as $index => $inst) {
                $inst->update(['step' => $index]);
            }
        });
    }

    public function addIngredient(Recipe $recipe, string $ingredientId, string $quantity, string $unit): void
    {
        Ingredient::findOrFail($ingredientId);

        $recipe->ingredients()->attach(
            $ingredientId,
            ['quantity' => $quantity, 'unit' => $unit]
        );
    }

    public function addInstruction(Recipe $recipe, string $instructionText): Instruction
    {
        return $recipe->instructions()->create([
            'step' => $recipe->getInstructionsCount(),
            'instruction' => $instructionText,
        ]);
    }
}

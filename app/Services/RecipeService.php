<?php

namespace App\Services;

use App\Models\Instruction;
use App\Models\Recipe;
use DB;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RecipeService
{
    public function getAll(): Collection
    {
        return Recipe::all();
    }

    public function getWithIngredients(array $ingredientUuids): Collection
    {
        $recipes = Recipe::whereHas(
            'ingredients',
            function ($query) use ($ingredientUuids) {
                $query->whereIn('ingredients.id', $ingredientUuids);
            })->get();

        return $recipes;
    }

    public function getById(string $id): Recipe
    {
        $recipe = Recipe::with([
            'ingredients',
            'instructions' => function ($query) {
                $query->orderBy('step', 'asc');
            },
        ])->findOrFail($id);

        return $recipe;
    }

    public function create(array $request): Recipe
    {
        return Recipe::create([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
    }

    public function delete(string $id): void
    {
        $recipe = $this->getById($id);

        $recipe->delete();
    }

    public function update(string $id, array $request): Recipe
    {
        $recipe = $this->getById($id);

        $recipe->name = $request['name'];
        $recipe->description = $request['description'];

        $recipe->saveOrFail();

        return $recipe;
    }

    public function addIngredientToRecipe(string $id, array $request): Recipe
    {
        $recipe = $this->getById($id);

        $recipe->ingredients()->attach(
            $request['ingredientId'],
            ['quantity' => $request['quantity'], 'unit' => $request['unit']]
        );

        return $this->getById($id);
    }

    public function addInstructionToRecipe(string $id, array $request): Instruction
    {
        $recipe = $this->getById($id);
        $instruction = $recipe->instructions()->create([
            'step' => $recipe->instructions()->count(),
            'instruction' => $request['instruction'],
        ]);

        return $instruction;
    }

    public function changeInstructionStepOnRecipe(string $recipeId, string $instructionId, array $request): Instruction
    {
        $recipe = $this->getById($recipeId);
        $instruction = Instruction::findOrFail($instructionId);

        $instructions = $recipe->instructions()->orderBy('step')->get();

        $newStep = $request['newStep'];
        if ($newStep < 0 || $newStep > $instructions->count()) {
            throw new BadRequestHttpException('New Step is out of range');
        }

        DB::transaction(function () use (&$instructions, &$instruction, $newStep) {
            $instructions = $instructions->filter(fn ($i) => $i->id !== $instruction->id);

            $instructions->splice($newStep, 0, [$instruction]);

            $instructions->each(function ($inst, $index) {
                $inst->update(['step' => $index]);
            });
        });

        return Instruction::findOrFail($instructionId);
    }
}

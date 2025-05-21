<?php

namespace App\Services;

use App\Models\Instruction;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RecipeService
{
    private RecipeRepository $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function findAll(): Collection
    {
        return $this->recipeRepository->all();
    }

    public function findWithIngredients(array $ingredientUuids): Collection
    {
        return $this->recipeRepository->findWithIngredients($ingredientUuids);
    }

    public function findById(string $id): Recipe
    {
        return $this->recipeRepository->findById($id);
    }

    public function create(array $request): Recipe
    {
        return $this->recipeRepository->create($request);
    }

    public function delete(string $id): void
    {
        $recipe = $this->findById($id);

        $recipe->delete();
    }

    public function update(string $id, array $request): Recipe
    {
        $recipe = $this->findById($id);

        $recipe->name = $request['name'];
        $recipe->description = $request['description'];

        $this->recipeRepository->save($recipe);

        return $recipe;
    }

    public function addIngredientToRecipe(string $id, array $request): Recipe
    {
        $recipe = $this->findById($id);

        $this->recipeRepository->addIngredient($recipe, $request['ingredientId'], $request['quantity'], $request['unit']);

        return $this->findById($id);
    }

    public function addInstructionToRecipe(string $id, array $request): Instruction
    {
        $recipe = $this->findById($id);

        return $this->recipeRepository->addInstruction($recipe, $request['instruction']);
    }

    public function changeInstructionStepOnRecipe(string $recipeId, string $instructionId, array $request): Instruction
    {
        $recipe = $this->findById($recipeId);
        $movingInstruction = Instruction::findOrFail($instructionId);

        $newStep = $request['newStep'];
        if ($newStep < 0 || $newStep > $recipe->getInstructionsCount()) {
            throw new BadRequestHttpException('New Step is out of range');
        }

        $this->recipeRepository->reorderInstructions($recipe, $movingInstruction, $newStep);

        return Instruction::findOrFail($instructionId);
    }
}

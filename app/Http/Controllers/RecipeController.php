<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIngredientToRecipeRequest;
use App\Http\Requests\AddInstructionToRecipeRequest;
use App\Http\Requests\ChangeInstructionStepOnRecipeRequest;
use App\Http\Requests\CreateRecipeRequest;
use App\Http\Requests\RecipeSearchRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Services\RecipeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RecipeController extends Controller
{
    private RecipeService $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function index(RecipeSearchRequest $request): JsonResponse
    {
        $ingredientsSearchIds = $request->getIngredients();

        if (! empty($ingredientsSearchIds)) {
            $recipes = $this->recipeService->findWithIngredients($ingredientsSearchIds);

            return response()->json($recipes);
        }
        $recipes = $this->recipeService->findAll();

        return response()->json($recipes);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $recipe = $this->recipeService->findById($id);

            return response()->json($recipe);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recipe Not Found',
            ], 404);
        }
    }

    public function create(CreateRecipeRequest $request): JsonResponse
    {
        $recipe = $this->recipeService->create($request->validated());

        return response()->json($recipe);
    }

    public function update(string $id, UpdateRecipeRequest $request): JsonResponse
    {
        try {
            $recipe = $this->recipeService->update($id, $request->validated());

            return response()->json($recipe);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recipe Not Found'], 404);
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $this->recipeService->delete($id);

            return response()->json(['message' => 'Success']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recipe Not Found',
            ], 404);
        }
    }

    public function addIngredientToRecipe(
        string $id,
        AddIngredientToRecipeRequest $request
    ) {
        try {
            $recipe = $this->recipeService->addIngredientToRecipe($id, $request->validated());

            return response()->json($recipe);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Ingredient or Recipe Not Found',
            ], 404);
        }
    }

    public function addInstructionToRecipe(
        string $id,
        AddInstructionToRecipeRequest $request
    ) {
        try {
            $instruction = $this->recipeService->addInstructionToRecipe($id, $request->validated());

            return response()->json($instruction);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recipe Not Found',
            ], 404);
        }
    }

    public function changeInstructionStepOnRecipe(
        string $recipeId,
        string $instructionId,
        ChangeInstructionStepOnRecipeRequest $request
    ) {
        try {
            $instruction = $this->recipeService->changeInstructionStepOnRecipe($recipeId, $instructionId, $request->validated());

            return response()->json($instruction);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recipe or Instruction Not Found',
            ], 404);
        } catch (BadRequestHttpException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}

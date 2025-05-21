<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Services\IngredientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class IngredientController extends Controller
{
    private IngredientService $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function index(): JsonResponse
    {
        $ingredients = $this->ingredientService->findAll();

        return response()->json($ingredients);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $ingredient = $this->ingredientService->findById($id);

            return response()->json($ingredient);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Ingredient Not Found',
            ], 404);
        }
    }

    public function create(CreateIngredientRequest $request): JsonResponse
    {
        $ingredient = $this->ingredientService->create($request->validated());

        return response()->json($ingredient);
    }

    public function update(string $id, UpdateIngredientRequest $request): JsonResponse
    {
        try {
            $ingredient = $this->ingredientService->update($id, $request->validated());

            return response()->json($ingredient);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Ingredient Not Found'], 404);
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $this->ingredientService->delete($id);

            return response()->json(['message' => 'Success']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Ingredient Not Found',
            ], 404);
        }
    }
}

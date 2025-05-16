<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(): JsonResponse
    {
        $recipes = Recipe::all();

        return response()->json($recipes);
    }

    public function show(string $id): JsonResponse
    {
        $recipe = Recipe::with(['ingredients', 'instructions'])->find($id);
        if (empty($recipe)) {
            return response()->json([
                'message' => 'Recipe Not Found',
            ], 404);
        }

        return response()->json($recipe);
    }
}

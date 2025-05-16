<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(): JsonResponse
    {
        $ingredients = Ingredient::all();

        return response()->json($ingredients);
    }

    public function show(string $id): JsonResponse
    {
        $ingredient = Ingredient::find($id);
        if (empty($ingredient)) {
            return response()->json([
                'message' => 'Ingredient Not Found',
            ], 404);
        }

        return response()->json($ingredient);
    }
}

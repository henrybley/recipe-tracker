<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Ingredient
Route::get('/ingredients', [IngredientController::class, 'index']);
Route::post('/ingredients', [IngredientController::class, 'create']);
Route::get('/ingredients/{id}', [IngredientController::class, 'show']);
Route::delete('/ingredients/{id}', [IngredientController::class, 'delete']);
Route::patch('/ingredients/{id}', [IngredientController::class, 'update']);
//Recipe
Route::get('/recipes', [RecipeController::class, 'index']);
Route::post('/recipes', [RecipeController::class, 'create']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);
Route::delete('/recipes/{id}', [RecipeController::class, 'delete']);
Route::patch('/recipes/{id}', [RecipeController::class, 'update']);
Route::post('/recipes/{id}/ingredients', [RecipeController::class, 'addIngredientToRecipe']);
Route::post('/recipes/{id}/instructions', [RecipeController::class, 'addInstructionToRecipe']);
Route::patch('/recipes/{recipeId}/instructions/{instructionId}', [RecipeController::class, 'changeInstructionStepOnRecipe']);


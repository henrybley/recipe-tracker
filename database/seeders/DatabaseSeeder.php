<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ingredient;
use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $recipe = Recipe::create([
            'name' => 'Pasta with Simple Arrabiata Tomato Sauce',
            'description' => 'A simple and classic Italian pasta dish with a rich spicy tomato sauce.',
        ]);

        $ingredientsData = [
            ['name' => 'Spaghetti', 'size' => 500, 'size_unit' => 'g'],
            ['name' => 'Canned Crushed Tomato', 'size' => 400, 'size_unit' => 'g'],
            ['name' => 'Garlic', 'size' => 1, 'size_unit' => 'cloves'],
            ['name' => 'Olive Oil', 'size' => 1, 'size_unit' => 'tbsp'],
            ['name' => 'Salt', 'size' => 1, 'size_unit' => 'tsp'],
            ['name' => 'Pepper', 'size' => 1, 'size_unit' => 'tsp'],
            ['name' => 'Chili Flakes', 'size' => 1, 'size_unit' => 'tsp'],
            ['name' => 'Basil', 'size' => 1, 'size_unit' => 'tsp'],
            ['name' => 'Oregano', 'size' => 1, 'size_unit' => 'tsp'],
        ];

        $ingredients = [];
        foreach ($ingredientsData as $data) {
            $ingredients[] = Ingredient::firstOrCreate($data);
        }

        $recipe->ingredients()->attach($ingredients[0], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[1], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[2], ['quantity' => 4]);
        $recipe->ingredients()->attach($ingredients[3], ['quantity' => 2]);
        $recipe->ingredients()->attach($ingredients[4], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[5], ['quantity' => 0.5]);
        $recipe->ingredients()->attach($ingredients[6], ['quantity' => 1]);
        $recipe->ingredients()->attach($ingredients[7], ['quantity' => 8]);
        /*RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[0]->id,
            'quantity'      => 1,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[1]->id,
            'quantity'      => 1,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[2]->id,
            'quantity'      => 4,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[3]->id,
            'quantity'      => 2,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[4]->id,
            'quantity'      => 1,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[5]->id,
            'quantity'      => 0.5,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[6]->id,
            'quantity'      => 1,
        ]);

        RecipeIngredient::create([
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredients[7]->id,
            'quantity'      => 8,
        ]);*/


        $instructions = [
            'Boil water in a large pot and add salt.',
            'Add the spaghetti and cook until al dente.',
            'Meanwhile, heat olive oil in a pan over medium heat.',
            'Add minced garlic and sauté until fragrant.',
            'Add the Canned tomatos, salt, pepper, and chili flakes and simmer for 10 minutes.',
            'Drain the pasta and mix it with the sauce.',
            'Chop the fresh basil.',
            'Serve hot and garnish with chopped basil.',
        ];

        foreach ($instructions as $step => $instruction) {
            Instruction::create([
                'recipe_id' => $recipe->id,
                'step' => $step + 1,
                'instruction' => $instruction,
            ]);
        }
    }
}

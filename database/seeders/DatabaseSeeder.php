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
            ['name' => 'Spaghetti'],
            ['name' => 'Canned Crushed Tomato'],
            ['name' => 'Garlic'],
            ['name' => 'Olive Oil'],
            ['name' => 'Salt'],
            ['name' => 'Pepper'],
            ['name' => 'Chili Flakes'],
            ['name' => 'Basil'],
        ];

        $ingredients = [];
        foreach ($ingredientsData as $data) {
            $ingredients[] = Ingredient::firstOrCreate($data);
        }

        $recipe->ingredients()->attach($ingredients[0], ['quantity' => 500, 'unit' => 'g']);
        $recipe->ingredients()->attach($ingredients[1], ['quantity' => 1, 'unit' => 'g']);
        $recipe->ingredients()->attach($ingredients[2], ['quantity' => 4, 'unit' => 'cloves']);
        $recipe->ingredients()->attach($ingredients[3], ['quantity' => 2, 'unit' => 'Tbsp']);
        $recipe->ingredients()->attach($ingredients[4], ['quantity' => 1, 'unit' => 'tsp']);
        $recipe->ingredients()->attach($ingredients[5], ['quantity' => 0.5, 'unit' => 'tsp']);
        $recipe->ingredients()->attach($ingredients[6], ['quantity' => 8, 'unit' => 'leaves']);

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

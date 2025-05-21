<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testRecipesReturns200(): void
    {
        $response = $this->get('/api/recipes');

        $response->assertStatus(200);
    }

    public function testRecipesPostCreatesRecipes(): void
    {
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $response->assertSee([
            'name' => 'A Simple Test Recipe',
        ]);

        $response = $this->get('/api/recipes');

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $this->assertIsArray(json_decode($response->getContent()));

        $this->assertCount(2, json_decode($response->getContent()));
    }

    public function testGetSingleRecipe(): void
    {
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);

        $newRecipeId = json_decode($response->getContent())->id;

        $response = $this->get('/api/recipes/'.$newRecipeId);

        $this->assertJson($response->getContent());

        $response->assertSee([
            'name' => 'A Simple Test Recipe',
        ]);
    }

    public function testDelete(): void
    {
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);

        $response = $this->postJson('/api/recipes', [
            'name' => 'Another Simple Test Recipe',
            'description' => 'Another simple and classic Test Recipe.',
        ]);

        $newRecipeId = json_decode($response->getContent())->id;

        $response = $this->delete('/api/recipes/'.$newRecipeId);

        $this->assertJson($response->getContent());

        $this->assertDatabaseMissing('recipes', [
            'name' => 'Another Simple Test Recipe',
        ]);

        $this->assertDatabaseHas('recipes', [
            'name' => 'A Simple Test Recipe',
        ]);
    }

    public function testAddInstruction(): void
    {
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);

        $newRecipeId = json_decode($response->getContent())->id;

        $response = $this->postJson('/api/recipes/'.$newRecipeId.'/instructions', [
            'instruction' => 'This is a basic Instruction',
        ]);

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $this->assertIsObject(json_decode($response->getContent()));

        $response = $this->get('/api/recipes/'.$newRecipeId);

        $this->assertIsArray(json_decode($response->getContent())->instructions);

        $this->assertCount(1, json_decode($response->getContent())->instructions);
    }

    public function testAddInstructionFailsOnRandomUUID(): void
    {
        $recipeId = '9ef77a09-3cec-409f-943c-cb6c7fa1bd8d';

        $response = $this->post('/api/recipes/'.$recipeId.'/instructions', [
            'instruction' => 'This is another basic Instruction',
        ]);

        $response->assertStatus(404);
    }

    public function testAddIngredient(): void
    {
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);

        $newRecipeId = json_decode($response->getContent())->id;

        $response = $this->postJson('/api/ingredients', [
            'name' => 'Rice']);

        $newIngredientId = json_decode($response->getContent())->id;

        $response = $this->postJson('/api/recipes/'.$newRecipeId.'/ingredients', [
            'ingredientId' => $newIngredientId,
            'quantity' => 500,
            'unit' => 'g',
        ]);

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $this->assertIsObject(json_decode($response->getContent()));

        $response = $this->get('/api/recipes/'.$newRecipeId);

        $this->assertIsArray(json_decode($response->getContent())->ingredients);

        $this->assertCount(1, json_decode($response->getContent())->ingredients);
    }

    public function testAddIngredientFailsOnRandomRecipeUUID(): void
    {
        $recipeId = '9ef77a09-3cec-409f-943c-cb6c7fa1bd8d';

        $response = $this->postJson('/api/recipes/'.$recipeId.'/ingredients', [
            'ingredientId' => '9ef77a09-42ce-48a5-ad9a-3eb0555744c2',
            'quantity' => 500,
            'unit' => 'g',
        ]);

        $response->assertStatus(404);
    }

    public function testAddIngredientFailsOnRandomIngredientUUID(): void
    {
        $response = $this->postJson('/api/recipes', [
            'name' => 'A Simple Test Recipe',
            'description' => 'A simple and classic Test Recipe.',
        ]);

        $newRecipeId = json_decode($response->getContent())->id;

        $ingredientId = '9ef77a09-3cec-409f-943c-cb6c7fa1bd8d';

        $response = $this->postJson('/api/recipes/'.$newRecipeId.'/ingredients', [
            'ingredientId' => $ingredientId,
            'quantity' => 500,
            'unit' => 'g',
        ]);

        $response->assertStatus(404);
    }
}

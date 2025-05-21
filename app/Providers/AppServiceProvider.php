<?php

namespace App\Providers;

use App\Repositories\Impl\EloquentIngredientRepository;
use App\Repositories\Impl\EloquentRecipeRepository;
use App\Repositories\IngredientRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IngredientRepository::class, EloquentIngredientRepository::class);
        $this->app->bind(RecipeRepository::class, EloquentRecipeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $size
 * @property string $size_unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereSizeUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ingredient extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['name', 'size', 'size_unit'];

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(
            Recipe::class,
            'recipe_ingredients',
            'ingredient_id',
            'recipe_id'
        )->withPivot(['quantity']);
    }
}

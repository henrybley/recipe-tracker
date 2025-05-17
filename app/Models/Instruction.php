<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property-read \App\Models\Recipe|null $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction query()
 * @mixin \Eloquent
 */
class Instruction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['step', 'instruction', 'recipe_id'];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}

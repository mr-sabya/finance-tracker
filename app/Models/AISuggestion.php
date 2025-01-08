<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $suggestion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion whereSuggestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AISuggestion whereUserId($value)
 * @mixin \Eloquent
 */
class AISuggestion extends Model
{
    use HasFactory;
}

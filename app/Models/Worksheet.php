<?php

namespace App\Models;

use App\Models\Shapes\Circle;
use App\Models\Shapes\Rectangle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worksheet extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'user_id'];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get all of the circles that are assigned this worksheet.
     *
     * @return MorphToMany
     */
    public function circles(): MorphToMany
    {
        return $this->morphedByMany(Circle::class, 'shapelike', 'shapes');
    }


    /**
     * Get all of the rectangles that are assigned this worksheet.
     *
     * @return MorphToMany
     */
    public function rectangles(): MorphToMany
    {
        return $this->morphedByMany(Rectangle::class, 'shapelike', 'shapes');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class Shape extends Model
{
    protected $with = ['color'];
    protected $appends = ['shape_type', 'color_code'];

    /**
     * Array of strings, represents the required attributes for each shape.
     * e.g.: ['radius', 'height', 'width', etc...]
     *
     * @return array
     */
    abstract public function requiredAttributes(): array;


    /**
     * @return string
     */
    public static function shapeType(): string
    {
        return static::TYPE;
    }


    /**
     * @return MorphToMany
     */
    public function worksheets(): MorphToMany
    {
        return $this->morphToMany(Worksheet::class, 'shapelike', 'shapes');
    }


    /**
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return string
     */
    public function getShapeTypeAttribute(): string
    {
        return static::shapeType();
    }


    /**
     * @return string
     */
    public function getColorCodeAttribute(): string
    {
        return $this->color->code;
    }
}

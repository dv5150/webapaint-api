<?php

namespace App\Models\Shapes;

use App\Models\Shape;

class Circle extends Shape
{
    const TYPE = 'circle';

    protected $table = 'circles';
    protected $fillable = ['radius', 'user_id', 'color_id'];


    /**
     * @inheritDoc
     */
    public function requiredAttributes(): array
    {
        return ['radius'];
    }
}

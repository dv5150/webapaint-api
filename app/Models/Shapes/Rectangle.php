<?php

namespace App\Models\Shapes;

use App\Models\Shape;

class Rectangle extends Shape
{
    const TYPE = 'rectangle';

    protected $table = 'rectangles';
    protected $fillable = ['height', 'width', 'user_id', 'color_id'];


    /**
     * @inheritDoc
     */
    public function requiredAttributes(): array
    {
        return ['width', 'height'];
    }
}

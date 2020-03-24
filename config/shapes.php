<?php

$shapesNamespace = 'App\Models\Shapes\\';

$shapes = array_slice(scandir(app_path('Models/Shapes')), 2);

$shapeKeys = array_map(function ($shape) {
    return strtolower(str_replace('.php', '', $shape));
}, $shapes);

$shapeClasses = array_map(function ($shape) use ($shapesNamespace) {
    return $shapesNamespace.str_replace('.php', '', $shape);
}, $shapes);

return [
    'list' => array_combine($shapeKeys, $shapeClasses)
];

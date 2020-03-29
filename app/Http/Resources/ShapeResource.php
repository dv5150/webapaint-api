<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShapeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_filter([
            'id' => $this->id,
            'radius' => $this->radius,
            'height' => $this->height,
            'width' => $this->width,
            'shape_type' => $this->shape_type,
            'color_code' => $this->color_code,
        ]);
    }
}

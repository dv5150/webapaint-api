<?php

namespace App\Http\Services;

use App\Models\Shape;
use App\Models\User;
use Illuminate\Support\Collection;

class ShapeService
{
    /**
     * @param User $user
     *
     * @return Collection
     */
    public function getShapesForUser(User $user): Collection
    {
        $user->loadMissing('worksheets.circles', 'worksheets.rectangles');

        return $user->circles->concat($user->rectangles);
    }


    /**
     * @param User   $user
     * @param string $type
     * @param int    $id
     *
     * @return Shape|null
     */
    public function findShapeForUser(User $user, string $type, int $id): ?Shape
    {
        $this->checkSupportedShape($type);

        return $this->getAvailableShapes()[$type]::query()
                                                 ->where('user_id', '=', $user->id)
                                                 ->findOrFail($id);
    }


    /**
     * @param User  $user
     * @param array $data
     *
     * @return Shape
     */
    public function createShape(User $user, array $data): Shape
    {
        $this->checkSupportedShape($data['type']);

        $data = array_merge($data, [
            'user_id' => $user->id
        ]);

        return $this->getAvailableShapes()[$data['type']]::query()->create($data);
    }


    /**
     * @param string $type
     */
    public function checkSupportedShape(string $type): void
    {
        if (!in_array($type, $this->getAvailableShapeKeys())) {
            abort(422, 'Given shape is not supported.');
        }
    }


    /**
     * @return array
     */
    public function getAvailableShapeKeys(): array
    {
        return array_keys(config('shapes.list'));
    }


    /**
     * @return array
     */
    public function getAvailableShapes(): array
    {
        return config('shapes.list');
    }
}

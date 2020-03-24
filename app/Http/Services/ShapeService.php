<?php


namespace App\Http\Services;


use App\Models\Shape;
use App\Models\Shapes\Circle;
use App\Models\Shapes\Rectangle;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ShapeService
{
    /**
     * @param Worksheet $worksheet
     *
     * @return Collection
     */
    public function getShapesForWorksheet(Worksheet $worksheet): Collection
    {
        return $worksheet->circles
                         ->toBase()
                         ->concat($worksheet->rectangles);
    }


    /**
     * @param User $user
     *
     * @return Collection
     */
    public function getShapesForUser(User $user): Collection
    {
        $user->loadMissing('worksheets.circles', 'worksheets.rectangles');

        $shapes = new Collection();

        $user->worksheets->each(function (Worksheet $ws) use ($shapes) {
            $shapes->push($this->getShapesForWorksheet($ws));
        });

        return $shapes->collapse();
    }


    /**
     * @param User $user
     * @param int  $id
     *
     * @return Shape|null
     */
    public function findShapeForUser(User $user, int $id): ?Shape
    {
        $user->loadMissing('worksheets.circles', 'worksheets.rectangles');

        return $this->getShapesForUser($user)
                    ->where('id', '=', $id)
                    ->first();
    }


    /**
     * @param User  $user
     * @param array $data
     *
     * @return Shape
     */
    public function createShape(User $user, array $data): Shape
    {
        $data = array_merge($data, [
            'user_id' => $user->id
        ]);

        switch ($data['type']) {
            case 'rectangle':
                return Rectangle::query()->create($data);
                break;
            case 'circle':
                return Circle::query()->create($data);
                break;
        }
    }
}

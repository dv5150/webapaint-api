<?php

namespace App\Http\Controllers\API\Users\Shapes;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShapeResource;
use App\Http\Services\ShapeService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Show extends Controller
{
    /**
     * @var ShapeService
     */
    private $shapeService;


    /**
     * HomeController constructor.
     *
     * @param ShapeService $shapeService
     */
    public function __construct(ShapeService $shapeService)
    {
        $this->shapeService = $shapeService;
    }


    /**
     * @param User $user
     * @param int  $id
     *
     * @return JsonResponse
     */
    public function __invoke(User $user, int $id): JsonResponse
    {
        return response()->json(
            ShapeResource::make($this->shapeService->findShapeForUser($user, $id)),
            200
        );
    }
}

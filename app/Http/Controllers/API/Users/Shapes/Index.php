<?php

namespace App\Http\Controllers\API\Users\Shapes;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShapeResource;
use App\Http\Services\ShapeService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Index extends Controller
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
     *
     * @return JsonResponse
     */
    public function __invoke(User $user): JsonResponse
    {
        return response()->json(
            ShapeResource::collection(
                $this->shapeService->getShapesForUser($user)
            ), 200
        );
    }
}

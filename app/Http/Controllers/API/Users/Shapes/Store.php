<?php

namespace App\Http\Controllers\API\Users\Shapes;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreShapeRequest;
use App\Http\Resources\ShapeResource;
use App\Http\Services\AuthService;
use App\Http\Services\ShapeService;
use App\Models\User;

class Store extends Controller
{
    /**
     * @var ShapeService
     */
    private $shapeService;


    /**
     * Store constructor.
     *
     * @param ShapeService $shapeService
     */
    public function __construct(ShapeService $shapeService)
    {
        $this->shapeService = $shapeService;
    }


    /**
     * Handle the incoming request.
     *
     * @param User              $user
     * @param StoreShapeRequest $request
     *
     * @return ShapeResource
     */
    public function __invoke(User $user, StoreShapeRequest $request): ShapeResource
    {
        AuthService::checkToken($user, $request);

        return ShapeResource::make(
            $this->shapeService->createShape($user, $request->all())
        );
    }
}

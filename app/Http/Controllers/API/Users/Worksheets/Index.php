<?php

namespace App\Http\Controllers\API\Users\Worksheets;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorksheetResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Index extends Controller
{
    /**
     *
     * @param User $user
     *
     * @return JsonResponse
     */
    public function __invoke(User $user): JsonResponse
    {
        $user->loadMissing(
            'worksheets.circles',
            'worksheets.rectangles',
            'worksheets.user'
        );

        return response()->json(
            WorksheetResource::collection($user->worksheets),200
        );
    }
}

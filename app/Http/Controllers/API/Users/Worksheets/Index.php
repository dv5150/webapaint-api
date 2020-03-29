<?php

namespace App\Http\Controllers\API\Users\Worksheets;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorksheetResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class Index extends Controller
{
    /**
     *
     * @param User $user
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(User $user): AnonymousResourceCollection
    {
        $user->loadMissing(
            'worksheets.circles',
            'worksheets.rectangles'
        );

        return WorksheetResource::collection($user->worksheets);
    }
}

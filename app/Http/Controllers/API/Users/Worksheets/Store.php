<?php

namespace App\Http\Controllers\API\Users\Worksheets;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreWorksheetRequest;
use App\Http\Resources\WorksheetResource;
use App\Http\Services\AuthService;
use App\Http\Services\WorksheetService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Store extends Controller
{
    /**
     * @var WorksheetService
     */
    private $worksheetService;


    /**
     * Store constructor.
     *
     * @param WorksheetService $worksheetService
     */
    public function __construct(WorksheetService $worksheetService)
    {
        $this->worksheetService = $worksheetService;
    }


    /**
     * Handle the incoming request.
     *
     * @param User                  $user
     * @param StoreWorksheetRequest $request
     *
     * @return WorksheetResource
     */
    public function __invoke(User $user, StoreWorksheetRequest $request): WorksheetResource
    {
        AuthService::checkToken($user, $request);

        return WorksheetResource::make(
            $this->worksheetService->createWorksheet($user, $request->all())
        );
    }
}

<?php

namespace App\Http\Controllers\API\Users\Worksheets\Shapes;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreShapeInWorksheetRequest;
use App\Http\Services\AuthService;
use App\Http\Services\ShapeService;
use App\Http\Services\WorksheetService;
use App\Models\User;
use App\Models\Worksheet;
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
     * @param User                         $user
     * @param Worksheet                    $worksheet
     * @param StoreShapeInWorksheetRequest $request
     * @param ShapeService                 $shapeService
     *
     * @return JsonResponse
     */
    public function __invoke(User $user, Worksheet $worksheet, StoreShapeInWorksheetRequest $request, ShapeService $shapeService)
    {
        AuthService::checkToken($user, $request);

        return response()->json(
            $this->worksheetService->addShape(
                $user, $worksheet, $request->all(), $shapeService
            ), 201
        );
    }
}

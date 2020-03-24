<?php

namespace App\Http\Controllers\API\Users\Worksheets\Shapes;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreShapeInWorksheetRequest;
use App\Http\Resources\WorksheetResource;
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
     *
     * @return JsonResponse
     */
    public function __invoke(User $user, Worksheet $worksheet, StoreShapeInWorksheetRequest $request)
    {
        abort_if(!$worksheet->user->is($user), 403);

        $data = $this->worksheetService->addShape($worksheet, $request->all());

        return response()->json($data, 200);
    }
}

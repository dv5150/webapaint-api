<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class WorksheetService
{
    /**
     * @param User  $user
     * @param array $data
     *
     * @return Worksheet
     */
    public function createWorksheet(User $user, array $data): Worksheet
    {
        return Worksheet::query()->create([
            'user_id' => $user->id,
            'title' => $data['title']
        ]);
    }


    /**
     * @param User         $user
     * @param Worksheet    $worksheet
     * @param array        $data
     *
     * @param ShapeService $shapeService
     *
     * @return JsonResponse
     */
    public function addShape(User $user, Worksheet $worksheet, array $data, ShapeService $shapeService): JsonResponse
    {
        $shapeService->checkSupportedShape($data['type']);

        abort_if(!$worksheet->user->is($user), 403);

        $shapeService->getAvailableShapes()[$data['type']]::query()->findOrFail($data['id']);

        $timestamp = now();

        $data = [
            'worksheet_id' => $worksheet->id,
            'shapelike_type' => $shapeService->getAvailableShapes()[$data['type']],
            'shapelike_id' => $data['id'],
            'x' => $data['x'],
            'y' => $data['y'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        DB::table('shapes')->insert($data);

        return response()->json($data, 200);
    }
}

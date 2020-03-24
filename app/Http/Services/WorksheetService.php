<?php

namespace App\Http\Services;

use App\Models\Shapes\Circle;
use App\Models\Shapes\Rectangle;
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
     * @param Worksheet $worksheet
     * @param array     $data
     *
     * @return JsonResponse
     */
    public function addShape(Worksheet $worksheet, array $data): JsonResponse
    {
        $data['type'] === 'circle'
            ? Circle::query()->findOrFail($data['id'])
            : Rectangle::query()->findOrFail($data['id']);

        $data = [
            'worksheet_id' => $worksheet->id,
            'shapelike_type' => config('shapes.list')[$data['type']],
            'shapelike_id' => $data['id'],
            'x' => $data['x'],
            'y' => $data['y'],
        ];

        DB::table('shapes')->insert($data);

        return response()->json($data, 200);
    }
}

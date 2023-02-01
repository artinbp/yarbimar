<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Disease\CreateDiseaseRequest;
use App\Http\Requests\Api\Dashboard\Disease\UpdateDiseaseRequest;
use App\Models\Disease;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Symfony\Component\HttpFoundation\Response;

class DiseaseController extends Controller
{
    private const DISEASE_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $diseases = Disease::paginate();

        return response()->json($diseases, Response::HTTP_OK);
    }

    public function create(CreateDiseaseRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $disease = Disease::create($fields);
        return response()->json($disease);
    }

    public function update(UpdateDiseaseRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $disease = Disease::findOrFail($fields);
        $disease->update($disease);
        $disease = $disease->fresh();

        return response()->json($disease);
    }
}

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
        $diseases = Disease::paginate(self::DISEASE_PER_PAGE);

        return response()->json($diseases, Response::HTTP_OK);
    }

    public function create(CreateDiseaseRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $disease = Disease::create($fields);
        return response()->json($disease, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $disease = Disease::findOrFail($id);

        return response()->json($disease, Response::HTTP_OK);
    }

    public function update(UpdateDiseaseRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $disease = Disease::findOrFail($fields);
        $disease->update($disease);
        $disease = $disease->fresh();

        return response()->json($disease, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $disease = Disease::findOrFail($id);
        $disease->delete();

        return response()->json(['message' => 'Disease successfully deleted.'], Response::HTTP_OK);
    }
}

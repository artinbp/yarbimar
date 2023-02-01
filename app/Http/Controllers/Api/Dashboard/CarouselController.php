<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Carousel\CreateCarouselRequest;
use App\Http\Requests\Api\Dashboard\Carousel\UpdateCarouselRequest;
use App\Models\Carousel;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CarouselController extends Controller
{
    private const MAX_CAROUSEL = 5;

    public function list(): JsonResponse
    {
        $carousel = Carousel::all();

        return response()->json($carousel, Response::HTTP_OK);
    }

    public function create(CreateCarouselRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $count = Carousel::count();
        if ($count >= self::MAX_CAROUSEL) {
            return response()->json([
                'message' => 'You can\'t create more than ' . self::MAX_CAROUSEL . ' carousel'
            ], Response::HTTP_FORBIDDEN);
        }

        $media = Media::findOrFail($fields['media_id']);
        $carousel = null;
        DB::transaction(function () use ($fields, $media, &$carousel) {
            $carousel = Carousel::create($fields);
            $media->carousel()->save($carousel);
            $carousel = $carousel->fresh();
        });

        return response()->json($carousel, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $carousel = Carousel::findOrFail($id);

        return response()->json($carousel, Response::HTTP_OK);
    }

    public function update(UpdateCarouselRequest $request, $id): JsonResponse
    {
        $carousel = Carousel::findOrFail($id);
        $fields = $request->validated();

        DB::transaction(function () use (&$carousel, $fields) {
            $carousel->update($fields);

            if (isset($fields['media_id']) && !empty($fields['media_id'])) {
                $media = Media::findOrFail($fields['media_id']);
                $media->carousel()->save($carousel);
            }

            $carousel = $carousel->fresh();
        });

        return response()->json($carousel, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->delete();

        return response()->json(['message' => 'Carousel successfully deleted'], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
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

    public function create(Request $request): JsonResponse
    {
        $count = Carousel::count();
        if ($count >= self::MAX_CAROUSEL) {
            return response()->json([
                'message' => 'You can\'t create carousel more than ' . self::MAX_CAROUSEL
            ], Response::HTTP_FORBIDDEN);
        }

        $fields = $request->validate([
            'title' => ['required', 'filled'],
            'media_id' => ['required', 'filled', 'numeric', 'exists:media,id'],
            'description' => ['required', 'filled', 'string'],
            'url' => ['required', 'filled', 'url'],
        ]);

        $media = Media::findOrFail($fields['media_id']);
        $id = 0;
        DB::transaction(function () use ($fields, $media, &$id) {
            $carousel = Carousel::create($fields);
            $id = $carousel->id;
            $media->carousel()->save($carousel);
        });
        $carousel = Carousel::findOrFail($id);

        return response()->json($carousel, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $carousel = Carousel::findOrFail($id);

        return response()->json($carousel, Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $carousel = Carousel::findOrFail($id);

        $fields = $request->validate([
            'title' => ['filled'],
            'media_id' => ['filled', 'numeric', 'exists:media,id'],
            'description' => ['filled', 'string'],
            'url' => ['filled', 'url'],
        ]);

        DB::transaction(function () use ($carousel, $fields) {
            $carousel->update($fields);

            if (isset($fields['media_id']) && !empty($fields['media_id'])) {
                $media = Media::findOrFail($fields['media_id']);
                $media->carousel()->save($carousel);
            }
        });

        $carousel = Carousel::findOrFail($id);

        return response()->json($carousel, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->delete();

        return response()->json(['message' => 'Carousel successfully deleted'], Response::HTTP_OK);
    }
}

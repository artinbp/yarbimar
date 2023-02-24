<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Media\CreateMediaRequest;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use function response;

class MediaController extends Controller
{
    private const MEDIA_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $media = Media::latest()->paginate(self::MEDIA_PER_PAGE);

        return response()->json($media, Response::HTTP_OK);
    }

    public function create(CreateMediaRequest $request): JsonResponse
    {
        $request->validated();

        $file = $request->file('file');
        $hashName = $file->hashName();

        $hashNameWithoutExtension = pathinfo($hashName, PATHINFO_FILENAME);
        $path = $file->storePubliclyAs(
            "media",
            $hashNameWithoutExtension . '_' . urlencode($file->getClientOriginalName())
        );

        $media = Media::create(
            attributes: [
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path' => $path,
                'size' => $file->getSize(),
            ],
        );

        return response()->json([
            'id' => $media->id,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => $path,
            'size' => $file->getSize(),
            'url' => Storage::url($path)
        ], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $media = Media::findOrFail($id);

        DB::transaction(function() use($media) {
            $media->delete();
            Storage::disk('public')->delete($media->path);
        });

        return response()->json(
            ['message' => __('messages.deleted', ['entity' => __('entity.media')])],
            Response::HTTP_OK
        );
    }
}

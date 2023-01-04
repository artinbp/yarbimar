<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MediaApiController extends Controller
{
    private const MEDIA_PER_PAGE = 8;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:'. join(',', [Role::ROLE_SUPER_ADMIN, Role::ROLE_ADMIN]));
    }

    public function list() {
        $media = Media::paginate(self::MEDIA_PER_PAGE);

        return response()->json($media, Response::HTTP_OK);
    }

    public function create(Request $request) {
        $request->validate([
            'file' => ['required', 'file'],
        ]);

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
                'path'      => $path,
                'size'      => $file->getSize(),
            ],
        );

        return response()->json([
            'id'        => $media->id,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path'      => $path,
            'size'      => $file->getSize(),
            'url'       => Storage::url($path)
        ], Response::HTTP_OK);
    }

    public function delete($id) {
        $media = Media::findOrFail($id);
        $media->delete();

        Storage::disk('public')->delete($media->path);

        return response()->json(['message' => 'Media successfully deleted'], Response::HTTP_OK);
    }
}

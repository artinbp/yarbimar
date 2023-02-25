<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CategoryController extends Controller
{
    public function list(): JsonResponse
    {
        $categoriesWithSubs = Category::with('childrenRecursive')
            ->where('parent_id', '=', null)
            ->where('disabled', '=', false)
            ->get();

        return response()->json($categoriesWithSubs, Response::HTTP_OK);
    }
}

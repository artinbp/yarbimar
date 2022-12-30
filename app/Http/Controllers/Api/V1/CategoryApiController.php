<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryApiController extends Controller
{
    public function list() {
        $categoriesWithSubs = Category::with('childrenRecursive')
                                ->where('parent_id', null)
                                ->where('disabled', false)
                                ->get();

        return response()->json($categoriesWithSubs, Response::HTTP_OK);
    }
}

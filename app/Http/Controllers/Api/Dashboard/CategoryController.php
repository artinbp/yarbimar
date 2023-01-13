<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class CategoryController extends Controller
{
    private const maxCategoryDepth = 2;

    public function list(): JsonResponse
    {
        $categoriesWithSubs = Category::with('childrenRecursive')->where('parent_id', null)->get();

        return response()->json($categoriesWithSubs, Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'title' => ['required', 'filled'],
            'parent_id' => ['filled', 'numeric', 'exists:categories,id'],
            'description' => ['required', 'filled', 'string'],
            'boolean' => ['filled', 'boolean']
        ]);

        $depth = 0;
        if (!empty($request->parent_id)) {
            $parentCategory = Category::findOrFail($fields['parent_id']);
            $depth = $parentCategory->depth + 1;
        }

        if ($depth > self::maxCategoryDepth) {
            return response()->json(
                ['message' => 'Category\'s depth can not be greater than ' . self::maxCategoryDepth + 1],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        $fields['depth'] = $depth;

        $category = Category::create($fields);

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $category = Category::with('childrenRecursive')->where('id', $id)->firstOrFail();

        return response()->json($category, Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $fields = $request->validate([
            'title' => ['filled'],
            'parent_id' => ['filled', 'numeric', 'exists:categories,id'],
            'description' => ['filled', 'string'],
            'boolean' => ['filled', 'boolean']
        ]);

        Category::findOrFail($id)->update($fields);
        $category = Category::findOrFail($id);

        return response()->json($category, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category successfully deleted'], Response::HTTP_OK);
    }
}

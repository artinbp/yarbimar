<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class CategoryApiController extends Controller
{
    private const maxCategoryDepth = 2;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:'. join(',', [Role::ROLE_SUPER_ADMIN, Role::ROLE_ADMIN]));
    }

    public function list() {
        $categoriesWithSubs = Category::with('childrenRecursive')->where('parent_id', null)->get()->toArray();

        return response()->json($categoriesWithSubs, Response::HTTP_OK);
    }
    
    public function create(Request $request) {
        $fields = $request->validate([
            'title'       => ['required', 'filled'],
            'parent_id'   => ['filled', 'numeric', 'exists:categories,id'],
            'description' => ['filled', 'string']
        ]);

        $depth = 0;
        if (!empty($request->parent_id)) {
            $parentCategory = Category::find($request->parent_id);
            $depth = $parentCategory->depth + 1;
        }

        if ($depth > self::maxCategoryDepth) {
            return response()->json(
                ['message' => 'Category\'s depth can not be greater than ' . self::maxCategoryDepth + 1],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        Category::create([
            'title'       => $fields['title'],
            'parent_id'   => $fields['parent_id'] ?? null,
            'description' => $fields['description'] ?? '',
            'depth'       => $depth,
        ]);

        return response()->json(['message' => 'Category successfully created'], Response::HTTP_CREATED);
    }

    public function read($id) {
        $category = Category::with('childrenRecursive')->where('id', $id)->get();

        return response()->json($category, Response::HTTP_OK);
    }

    public function update(Request $request, $id) {
        $fields = $request->validate(['title' =>  ['filled']]);

        Category::findOrFail($id)->update($fields);

        return response()->json(['message' => 'Category successfully updated'], Response::HTTP_OK);
    }

    public function delete($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category successfully deleted'], Response::HTTP_OK);
    }
}

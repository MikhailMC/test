<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoriesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function list(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "filter"    => "array",
            "filter.search"  => "string",
        ]);

        $list = Category::with('posts');

        if (isset($validated['filter']['search'])) {
            $list->where('name', 'like', '%' . $validated['filter']['search'] . '%');
        }

        $list = $list
            ->get();

        return response()->json($list);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function add(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $category = Category::create([
            'name' => $validated['name']
        ]);

        return response()->json($category);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function edit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|max:255',
        ]);

        $category = Category::find($validated['id']);

        if (empty($category->id)) {
            return response()->json(['error' => 1]);
        }

        $category->name = $validated['name'];
        $category->save();

        return response()->json($category);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function remove(Request $request, $id): JsonResponse
    {
        $category = Category::find($id);

        if (empty($category->id)) {
            return response()->json(['error' => 1]);
        }

        $category->delete();

        return response()->json(['success' => 1]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostsController extends Controller
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

        $list = Post::with('categories');

        if (isset($validated['filter']['search'])) {
            $list->where('name', 'like', '%' . $validated['filter']['search'] . '%');
        }

        $list = $list
            ->get();

        return response()->json($list->toArray());
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
            'description' => 'string',
        ]);

        $post = Post::create([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        return response()->json($post->toArray());
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
            'description' => 'string',
        ]);

        $post = Post::find($validated['id']);

        if (empty($post->id)) {
            return response()->json(['error' => 1]);
        }

        $post->name = $validated['name'];
        $post->description = $validated['description'];
        $post->save();

        return response()->json($post->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function remove(Request $request, $id): JsonResponse
    {
        $post = Post::find($id);

        if (empty($post->id)) {
            return response()->json(['error' => 1]);
        }

        $post->delete();

        return response()->json(['success' => 1]);
    }

}

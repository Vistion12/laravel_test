<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::with('category')->get()->paginate(5));

//        $response = [
//            'success' => true,
//            'message' => 'List all posts',
//            'data' => $posts,
//        ];
//        return response()->json($response, 200);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return (new PostResource($post))->additional([
            'success'=>true,
            'message'=>'Posts retrieved successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        // Валидация входных данных
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }


        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);


        return (new PostResource($post))->additional([
            'success' => true,
            'message' => 'Post updated successfully',
        ]);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        $deleted = $post->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Пост успешно удален',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка удаления поста',
            ], 500);
        }
    }
}

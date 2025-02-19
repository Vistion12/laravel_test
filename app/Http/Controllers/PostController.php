<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->input('query');

//        $posts = Post::query()
//            ->where('title', 'LIKE', "%{$query}%")
//            ->orWhere('text', 'LIKE', "%{$query}%")
//            ->paginate(10);

//        $postsTitle = Post::query()->title($query);
//        $postsText = Post::query()->text($query);
//
//        $posts = $postsTitle->union($postsText)->paginate(10);
        if (empty($query)) {
            return redirect()->route('posts.index')->with('error', 'Введите текст для поиска.');
        }
        $posts=Post::query()->titleAndText($query)->paginate(10);

        session()->flash('success', 'Результат поиска строки "' . $query . '"');

        return view('posts.index', [
            'posts' => $posts,
            'query' => $query, // Передаем запрос для использования в форме поиска
        ]);
    }
    public function addLike(string $id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->increment('likes');

            return response()->json([
                'success' => true,
                'message' => 'Лайк успешно поставлен',
                'likes' => $post->likes
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Пост не найден',
        ], 404);
    }

    public function index()
    {
        //$posts = $posts->getPosts();
        //$posts = DB::table('posts')->get();
        $posts = Post::orderBy('likes', 'desc')->paginate(10);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show( Post $post)
    {
      return view('posts.show', [
            'post' => $post,
        ]);
    }
}

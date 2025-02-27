<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return redirect()->route('posts.index')->with('error', 'Введите текст для поиска.');
        }

        try {
            $posts = $this->postService->searchPosts($query);
            session()->flash('success', 'Результат поиска строки "' . $query . '"');
            return view('posts.index', ['posts' => $posts, 'query' => $query]);
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при поиске: ' . $e->getMessage());
        }
    }
    public function addLike(string $id)
    {
        try {
            $result = $this->postService->addLike($id);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при добавлении лайка: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $posts = $this->postService->getAllPosts();
            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке постов: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $post = $this->postService->getPostWithComments($id);
            return view('posts.show', compact('post'));
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при загрузке поста: ' . $e->getMessage());
        }
    }
}

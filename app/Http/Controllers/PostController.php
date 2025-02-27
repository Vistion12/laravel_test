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

        $posts = $this->postService->searchPosts($query);

        session()->flash('success', 'Результат поиска строки "' . $query . '"');

        return view('posts.index', [
            'posts' => $posts,
            'query' => $query,
        ]);
    }
    public function addLike(string $id)
    {
        $result = $this->postService->addLike($id);

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json($result, 404);
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('posts.index', compact('posts'));
    }

    public function show(string $id)
    {
        $post = $this->postService->getPostWithComments($id);
        return view('posts.show', compact('post'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts=Post::query()->paginate(10);


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

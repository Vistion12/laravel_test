<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        //$posts = $posts->getPosts();
        //$posts = DB::table('posts')->get();
        $posts=Post::query()->paginate(10);


        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show( Post $post) //опять же, либо айди, либо слаг
    {
        //$post = $posts->getPost($id);
        //$post = DB::table('posts')->find($id);
//        if (!$post) {
//            abort(404);
//        }


       // $post = Post::query()->findOrFail($id);


        return view('posts.show', [
            'post' => $post,
        ]);
    }
}

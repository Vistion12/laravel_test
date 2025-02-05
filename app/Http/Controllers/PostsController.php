<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index(Posts $posts)
    {
        //$posts = $posts->getPosts();
        $posts = DB::table('posts')->get();



        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show( $id) //опять же, либо айди, либо слаг
    {
        //$post = $posts->getPost($id);
        $post = DB::table('posts')->find($id);
        if (!$post) {
            abort(404);
        }
        return view('posts.show', [
            'post' => $post,
        ]);
    }
}

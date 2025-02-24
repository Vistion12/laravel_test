<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|min:5|max:1000',
        ]);

        $comment = new Comment([
            'comment' => $request->input('comment'),
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        $comment->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Комментарий успешно добавлен!');
    }


    public function destroy(Comment $comment)
    {
        if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
            $comment->delete();
            return back()->with('success', 'Комментарий удален!');
        }

        return back()->with('error', 'Вы не можете удалить этот комментарий.');
    }


    public function edit(Comment $comment)
    {
        if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
            return view('comments.edit', compact('comment'));
        }

        return back()->with('error', 'Вы не можете редактировать этот комментарий.');
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|min:5|max:1000',
        ]);

        if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
            $comment->update(['comment' => $request->input('comment')]);
            return redirect()->route('posts.show', $comment->post_id)->with('success', 'Комментарий обновлен!');
        }

        return back()->with('error', 'Вы не можете редактировать этот комментарий.');
    }
}

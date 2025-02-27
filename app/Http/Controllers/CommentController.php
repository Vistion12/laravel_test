<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CreateCommentRequest $request, Post $post)
    {
        try {
            $validatedData = $request->validated();
            $this->commentService->createComment($post, $validatedData);
            return redirect()->route('posts.show', $post->id)->with('success', 'Комментарий успешно добавлен!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при добавлении комментария: ' . $e->getMessage());
        }
    }


    public function destroy(Comment $comment)
    {
        try {
            if ($this->commentService->deleteComment($comment)) {
                return back()->with('success', 'Комментарий удален!');
            }
            return back()->with('error', 'Вы не можете удалить этот комментарий.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при удалении комментария: ' . $e->getMessage());
        }
    }


    public function edit(Comment $comment)
    {
        if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
            return view('comments.edit', compact('comment'));
        }
        return back()->with('error', 'Вы не можете редактировать этот комментарий.');
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        try {
            $validatedData = $request->validated();
            if ($this->commentService->updateComment($comment, $validatedData)) {
                return redirect()->route('posts.show', $comment->post_id)->with('success', 'Комментарий обновлен!');
            }
            return back()->with('error', 'Вы не можете редактировать этот комментарий.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при обновлении комментария: ' . $e->getMessage());
        }
    }
}

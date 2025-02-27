<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentService
{
    public function createComment(Post $post, array $data)
    {
        try {
            $comment = new Comment([
                'comment' => $data['comment'],
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);

            $comment->save();
            return $comment;
        } catch (\Exception $e) {
            Log::error('Ошибка при создании комментария: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteComment(Comment $comment)
    {
        try {
            if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
                $comment->delete();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении комментария: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateComment(Comment $comment, array $data)
    {
        try {
            if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
                $comment->update(['comment' => $data['comment']]);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Ошибка при обновлении комментария: ' . $e->getMessage());
            throw $e;
        }
    }
}

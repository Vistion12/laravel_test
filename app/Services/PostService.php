<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function getAllPosts($paginate = 12, $orderBy = 'likes', $orderDirection = 'desc')
    {
        return Post::orderBy($orderBy, $orderDirection)->paginate($paginate);
    }

    public function searchPosts($query, $paginate = 10)
    {
        return Post::query()->titleAndText($query)->paginate($paginate);
    }
    public function addLike($postId)
    {
        $post = Post::find($postId);

        if ($post) {
            $post->increment('likes');
            return [
                'success' => true,
                'message' => 'Лайк успешно поставлен',
                'likes' => $post->likes
            ];
        }

        return [
            'success' => false,
            'message' => 'Пост не найден',
        ];
    }
    public function getPostWithComments($postId)
    {
        return Post::with('comments')->findOrFail($postId);
    }

    public function createPost(array $data)
    {
        try {
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }
            return Post::create($data);
        } catch (\Exception $e) {
            Log::error('Ошибка при создании поста: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePost(Post $post, array $data)
    {
        try {
            if (isset($data['image'])) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $this->uploadImage($data['image']);
            }

            $post->fill($data);
            return $post->save();
        } catch (\Exception $e) {
            Log::error('Ошибка при обновлении поста: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deletePost(Post $post)
    {
        try {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            return $post->delete();
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении поста: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function uploadImage($image)
    {
        return $image->store('posts', 'public');
    }
}

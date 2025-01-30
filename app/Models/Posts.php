<?php

namespace App\Models;

class Posts
{
    private $posts = [
        [
            'id' => 1,
            'slug' => 'first_post',
            'title' => 'First post',
            'text' => 'This is post 1',
        ],
        [
            'id' => 2,
            'slug' => 'second_post',
            'title' => 'Second post',
            'text' => 'This is post 2',
        ],
    ];

    public function getPosts(): array
    {
        return $this->posts;
    }
//TODO Реализуйте в модели метод getPost() извлекающий одну запись из массива постов, учтите вариант,
// когда будет передаваться не существующий id;
//TODO может перенаправлять на страницу 404 есть какой то хелпер аборт что ли
//TODO попробовать добавить слаг соответственно выводить вместо id на странице - слаг
    public function getPost($id): array //принимаем, либо id, либо слаг
    {
        foreach ($this->posts as $post) {
            if ($post['id'] == $id || $post['slug'] == $id) {
                return $post;
            }
        }
        abort(404);
    }
}

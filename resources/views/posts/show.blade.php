@extends('layouts.app')

@section('title', 'Пост')

@section('menu')
    @include('parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('parts.messages')

                <div class="card">
                    <div class="card-header">{{ $post->title }}</div>

                    <div class="card-body">
                        @if($post->image)
                            <img class="w-25 me-2 float-start" src="{{ asset('storage/' . $post->image) }}" alt="">
                        @endif
                        {{ $post->text }}
                    </div>

                    <button data-id="{{ $post->id }}" class="btn btn-primary w-25 likeButton ms-3 mb-2">
                        Likes: <span id="likeCount">{{ $post->likes }}</span>
                    </button>

                    <div class="card-body">Комментарии: {{ $post->comments->count() }}</div>

                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-25 likeButton ms-3 mb-2">Добавить комментарий</button>
                    </form>

                    <hr>

                    <div class="comments mt-4">
                        @foreach ($post->comments as $comment)
                            <div class="card mb-3" style="border: 1px solid #ccc; padding: 15px;">
                                <div class="card-body">
                                    <span class="text-muted" style="font-size: 0.9em;">Дата: {{ $comment->created_at->format('d-m-Y H:i') }}</span>:<br>
                                    <strong>Автор: {{ $comment->user->name }}</strong>
                                    <p>Комментарий:<br>{{ $comment->comment }}</p>
                                    @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->is_admin))
                                        <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-warning">Редактировать</a>

                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Админ | Посты')

@section('menu')
    @include('admin.parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Посты</h5>
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-success">Создать пост</a>
                    </div>

                    <div class="card-body">
                        <h2 class="mb-4">CRUD посты</h2>

                        @forelse ($posts as $post)
                            <div class="post-item mb-3 p-3 border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $post->title }}</h5>
                                    <div>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary btn-sm">Изменить</a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="mt-2">{{ Str::limit($post->content, 100) }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-link">Читать далее</a>
                            </div>
                        @empty
                            <p>Нет постов</p>
                        @endforelse
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

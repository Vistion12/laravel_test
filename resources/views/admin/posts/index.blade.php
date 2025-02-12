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

                    <div class="card-header">Посты</div>

                    <div class="card-body">
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-success">Создать пост</a>

                        <h2>CRUD посты</h2>

                        @forelse ($posts as $post)
                            <div class="mb-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">изменить</a>
                                <form action="{{ route('posts.delete', $post) }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                <br>

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

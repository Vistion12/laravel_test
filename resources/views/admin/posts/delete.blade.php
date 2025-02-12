@extends('layouts.app')

@section('title', 'Подтверждение удаления поста')

@section('menu')
    @include('admin.parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Удалить пост</div>

                    <div class="card-body">
                        <p>Вы уверены, что хотите удалить пост: <strong>{{ $post->title }}</strong>?</p>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Удалить</button>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Отмена</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

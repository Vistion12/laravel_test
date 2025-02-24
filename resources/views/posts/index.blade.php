@extends('layouts.app')

@section('title', 'Посты')

@section('menu')
    @include('parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('parts.messages')

                <div class="row">
                    @forelse ($posts as $post)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text">Likes: {{ $post->likes }}</p>
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Читать далее</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Нет постов</p>
                    @endforelse
                </div>

                {{ $posts->appends(['query' => request('query')])->links() }}

            </div>
        </div>
    </div>
@endsection

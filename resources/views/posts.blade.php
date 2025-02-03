@extends('layouts.main')

@section('title', 'Посты')

@section('menu')
    @include('menu')
@endsection

@section('content')
    <h2>Посты</h2>

    @forelse($posts as $post)
        <a href="{{route('post',$post['id'])}}">{{ $post['title'] }} </a><br>
    @empty
        <p>нет постов</p>
    @endforelse
@endsection



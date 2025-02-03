@extends('layouts.main')

@section('title', 'Главная')

@section('menu')
    @include('menu')
@endsection

@section('content')
    <h2>{{$post['title']}}</h2>
    <p>{{$post['text']}}</p>
@endsection



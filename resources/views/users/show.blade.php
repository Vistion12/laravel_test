@extends('layouts.app')

@section('title', 'Пользователь')

@section('menu')
    @include('parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('parts.messages')

                <div class="card">

                    <div class="card-header">{{ $user->name }}</div>

                    <div class="card-body">
                        <p>Email: {{ $user->email }}</p>
                        <p>Дата регистрации: {{ $user->created_at->format('d.m.Y H:i') }}</p>
                        <p>Роль: {{ $user->is_admin ? 'Администратор' : 'Пользователь' }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

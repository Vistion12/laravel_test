@extends('layouts.app')

@section('title', 'Пользователи')

@section('menu')
    @include('parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @forelse ($users as $user)
                    <a href="{{ route('users.show', $user) }}">{{ $user->name }} ({{ $user->email }})</a><br>
                @empty
                    <p>Нет пользователей</p>
                @endforelse

                {{ $users->links() }}

            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Админ | Пользователи')

@section('menu')
    @include('admin.parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Пользователи</h5>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Создать пользователя</a>
                    </div>

                    <div class="card-body">
                        <h2 class="mb-4">CRUD Пользователи</h2>

                        @forelse ($users as $user)
                            <div class="post-item mb-3 p-3 border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <div>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">Изменить</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="mt-2">{{ $user->email }}</p>
                                <a href="{{ route('users.show', $user) }}" class="btn btn-link">Просмотреть</a>
                            </div>
                        @empty
                            <p>Нет пользователей</p>
                        @endforelse
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('layouts.app')

@section('title', 'Админ | Категории')

@section('menu')
    @include('admin.parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Категории</h5>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Создать категорию</a>
                    </div>

                    <div class="card-body">
                        <h2 class="mb-4">CRUD Категории</h2>

                        @forelse ($categories as $category)
                            <div class="post-item mb-3 p-3 border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $category->name }}</h5>
                                    <div>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">Изменить</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </div>
                                </div>

                                <a href="{{ route('categories.show', $category) }}" class="btn btn-link">Просмотреть</a>
                            </div>
                        @empty
                            <p>Нет категорий</p>
                        @endforelse
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Редактировать комментарий')

@section('menu')
    @include('parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('comments.update', $comment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <textarea class="form-control" name="comment" rows="3" required>{{ old('comment', $comment->comment) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Обновить комментарий</button>
                </form>
            </div>
        </div>
    </div>
@endsection

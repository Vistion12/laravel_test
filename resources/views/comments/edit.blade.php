@extends('layouts.app')

@section('title', 'Редактировать комментарий')

@section('menu')
    @include('parts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('comments.update', $comment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" rows="3" required>{{ old('comment', $comment->comment) }}</textarea>
                        @error('comment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Обновить комментарий</button>
                </form>
            </div>
        </div>
    </div>
@endsection

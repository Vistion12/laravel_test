@extends('layouts.app')

@section('title', 'Админ | Посты')

@section('menu')
    @include('admin.parts.menu')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Посты</div>

                    <div class="card-body">
                        <a href="{{route('admin.create')}}" class="btn btn-success">создать пост</a>

                        <h2>CRUD посты</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

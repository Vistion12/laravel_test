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
                    <div class="card-header">Категории</div>

                    <div class="card-body">
                        <a href="" class="btn btn-success">создать категорию </a>

                        <h2>CRUD категории</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


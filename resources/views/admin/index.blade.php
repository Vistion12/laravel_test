@extends('layouts.app')

@section('title', 'Админ | Главная')

@section('menu')
    @include('admin.parts.menu')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Админка</div>

                    <div class="card-body">

                        <h2>Добро пожаловать в админку!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

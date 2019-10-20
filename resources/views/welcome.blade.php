@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1 class="display-4" align="center">{{ trans('app.name') }}</h1>
        <p class="lead">{{ trans('app.description') }}</p>
        <hr class="my-4">
        <p>{{ trans('app.functionality') }}</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg btn-block" href="/register" role="button">{{ trans('app.start') }}</a>
        </p>
    </div>
@endsection

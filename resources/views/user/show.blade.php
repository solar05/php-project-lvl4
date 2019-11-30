@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('account.info_acc') }}</div>
                <div class="card-body">
                    <table>
                        <tr>
                            <th>{{trans('account.name')}}: {{ $user->name }}</th>
                        </tr>
                        <tr>
                            <th>{{trans('account.email_acc')}}: {{ $user->email }}</th>
                        </tr>
                        <tr>
                            <th>
                                {{trans('account.home_tasks_count')}}:
                                @if($completedTasksCount === 0)
                                    <span class="badge badge-danger">{{ trans('account.home_no_completed_tasks') }}</span>
                                @else
                                    <span class="badge badge-success">{{ $completedTasksCount }}</span>
                                @endif
                                </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($canUpdate)
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('account.update_acc') }}</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('users.update', $user) }}">
                            @method('patch')
                            @csrf
                            <table class="table">
                                <tr>
                                    <th scope="row">
                                        {{ trans('account.login_acc') }}
                                        <div class="d-flex justify-content-start">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        {{ trans('account.email_acc') }}
                                        <div class="d-flex justify-content-end">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                        </div>
                                    </th>
                                </tr>
                            </table>
                            <input class="btn btn-success btn-block" type="submit" value="{{ trans('account.update_btn') }}" data-confirm="Are you sure you want to update account info?">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('account.delete_acc') }}</div>
                    <div class="card-body">
                        <form action="{{ route('users.destroy', $user) }}" method="post">
                            @method('delete')
                            @csrf
                            <input class="btn btn-danger btn-block" type="submit" value="{{ trans('account.delete_btn') }}" data-confirm="{{ trans('account.delete') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>
@endsection

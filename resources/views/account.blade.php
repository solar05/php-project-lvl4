@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('account.info_acc') }}</div>
                    <div class="card-body">
                        <div class="text-center">
                        <p class="center font-weight-normal">{{ $userName }}</p>
                        <p class="center font-weight-normal">{{ $userEmail }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('account.update_acc') }}</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('user.update') }}">
                            @method('patch')
                            @csrf
                            <table class="table">
                                <th scope="row">
                                    {{ trans('account.login_acc') }}
                                    <div class="d-flex justify-content-start">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                    </div>
                                </th>
                                <th scope="row">
                                    {{ trans('account.email_acc') }}
                                    <div class="d-flex justify-content-end">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                    </div>
                                </th>
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
                    <form action="{{ route('user.delete') }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="{{ trans('account.delete_btn') }}" data-confirm="Are you sure you want to delete account?">
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection

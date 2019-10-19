@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Account Info</div>
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
                    <div class="card-header">Update account info</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('user.update') }}">
                            @method('patch')
                            @csrf
                            <table class="table">
                                <th scope="row">
                                    <div class="d-flex justify-content-start">
                                        <input type="text"  id="name" name="name" placeholder="New Account name" class="label">
                                    </div>
                                </th>
                                <th scope="row">
                                    <div class="d-flex justify-content-end">
                                        <input type="text" id="email" name="email" placeholder="New account email" class="label">
                                    </div>
                                </th>
                            </table>
                            <input class="btn btn-success btn-block" type="submit" value="Update account info" data-confirm="Are you sure you want to update account info?">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card">
                <div class="card-header">Delete account</div>
                <div class="card-body">
                    <form action="{{ route('user.delete') }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="Delete account" data-confirm="Are you sure you want to delete account?">
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection

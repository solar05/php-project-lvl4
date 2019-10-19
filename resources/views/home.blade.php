@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    You are logged in!
                </div>
            </div>
            <form action="{{ route('delete') }}" method="post">
                @method('delete')
                @csrf
                <input class="btn-danger btn-block" type="submit" value="Delete account" data-confirm="Are you sure you want to delete account?">
            </form>
        </div>
    </div>
</div>
@endsection

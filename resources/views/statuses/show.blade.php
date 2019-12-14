@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <a href="{{route('statuses.show', $status)}}" class="{{ $status->present()->stateBadgeClass }}">
                {{ $status->present()->stateName }}
            </a>
        </div>
        <div class="card-body">
            @if(Auth::user()->can('update', $status))
                <form method="post" action="{{ route('statuses.update', $status) }}">
                    @method('patch')
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('state.status_name') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input class="btn btn-primary btn-block" type="submit" value="{{ trans('state.update') }}">
                    </div>
                </form>
            @else
                {{ trans('state.permission_denied') }}
            @endif
        </div>
    </div>
</div>
@endsection

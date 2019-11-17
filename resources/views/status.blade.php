@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="card">
        <div class="card-header">
            @include('layouts.state', ['stateId' => $status->id, 'stateName' => $status->name])
        </div>
        <div class="card-body">
            @if(in_array($status->name, ['created', 'in_work', 'testing', 'completed']))
                {{ trans('state.permission_denied') }}
            @else
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
            @endif
        </div>
    </div>
@endsection

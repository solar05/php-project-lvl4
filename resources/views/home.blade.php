@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('account.home') }}</div>

                <div class="card-body">
                    {{ trans('account.home_login') }}<br>
                    @if(count($userTasks) > 0)
                        {{ trans('account.home_tasks') }}
                        <table class="table">
                        @foreach($userTasks as $task)
                                <tr>
                                <td><a href="{{ route('task.show', $task['id']) }}">{{ $task['name'] }}</a></td>
                                <td align="right">@include('layouts.state', ['state' => $task['status_id']])</td>
                                </tr>
                        @endforeach
                        </table>
                    @else
                        {{ trans('account.home_no_tasks') }}
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('user.show', Auth::user()) }}">{{ trans('account.settings') }}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ trans('task.creating') }}</div>
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('task.name') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ trans('task.description') }}</label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control" name="description">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tags" class="col-md-4 col-form-label text-md-right">{{ trans('task.tags') }}</label>
                        <div class="col-md-6">
                            <input id="tags" type="text" class="form-control" name="tags" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assignedTo" class="col-md-4 col-form-label text-md-right">{{ trans('task.assigned') }}</label>
                        <div class="col-md-6">
                            <select name="assignedTo">
                            @foreach($usersNames as $userName)
                                    <option value="{{ $userName }}">{{ $userName }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <input class="btn btn-primary btn-block" type="submit" value="{{ trans('task.create') }}">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

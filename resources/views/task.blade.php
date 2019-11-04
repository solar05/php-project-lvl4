@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="card">
    <div class="card-header"> {{ trans('task.id') }}: {{ $task->id }}</div>
        <div class="card-body">
        <table>
            <th>{{trans('task.name')}}: {{ $task->name }}</th>
            <tr><th>
                    {{trans('task.description')}}: {{ $task->description }}
                </th></tr>
            <tr><th>{{ trans('task.state') }}: @include('layouts.state', ['stateId' => $task->status_id, 'stateName' => $task->status->name])</th></tr>
        <tr>
            <th> {{ trans('task.tags') }}:
        @foreach($tags as $tag)
                    <span class="badge badge-primary">{{ $tag->name }}</span>
        @endforeach
            </th>
        </tr>
            <tr>
                <th>
                    {{trans('task.creator')}}: <a href="{{route('users.show', $creator->id)}}">{{ $creator['name']}}</a>
                </th>
            </tr>
            <tr>
                <th>
                    {{trans('task.assigned')}}: <a href="{{route('users.show', $performer->id)}}">{{ $performer['name']}}</a>
                </th>
            </tr>
        </table>

    @if(Auth::user()['id'] == $creator['id'])
                @if($task->status_id < 4)
                    @include('layouts.proceed', ['taskId' => $task['id']])
                @endif
        </div>
                    <div class="card">
                        <div class="card-header">
                            {{ trans('task.update') }}
                        </div>
                        <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @method('patch')
                        @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('task.name') }}</label>
                                <div class="col-md-6">
                                    <input value="{{ $task->name }}" id="name" type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ trans('task.description') }}</label>
                                <div class="col-md-6">
                                    <input value="{{ $task->description }}" id="description" type="text" class="form-control" name="description">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tags" class="col-md-4 col-form-label text-md-right">{{ trans('task.tags') }}</label>
                                <div class="col-md-6">
                                    <input id="tags" type="text" class="form-control" name="tags">
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ trans('task.state') }}</label>
                            <div class="col-md-6">
                                <select name="status" class="browser-default custom-select">
                                    @foreach($statuses as $status)
                                        @if($status->name == $task->status->name)
                                            <option selected value="">{{ $status->name }}</option>
                                        @else
                                            <option value="{{ $status->name }}">{{ $status->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="assignedTo" class="col-md-4 col-form-label text-md-right">{{ trans('task.assigned') }}</label>
                                <div class="col-md-6">
                                    <select name="assignedTo" class="browser-default custom-select">
                                        @foreach($usersNames as $userName)
                                            @if($performer->name == $userName)
                                                <option selected value="{{ $userName }}">{{ $userName }}</option>
                                            @else
                                                <option value="{{ $userName }}">{{ $userName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input class="btn btn-success btn-block" type="submit" value="{{ trans('task.update') }}" data-confirm="{{ trans('task.update_confirm') }}">
                    </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ trans('task.delete') }}
                        </div>
                        <div class="card-body">
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="{{ trans('task.delete') }}" data-confirm="{{ trans('task.delete_confirm') }}">
                    </form>
                    </div>
                    </div>
            @elseif(Auth::user()->id == $performer->id && $task->status_id < 4 )
                @include('layouts.proceed', ['taskId' => $task->id])
    </div>
            @endif
    </div>
@endsection

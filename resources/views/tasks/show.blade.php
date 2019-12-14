@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            {{ trans('task.id') }}: {{ $task->id }}
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>
                        {{trans('task.name')}}: {{ $task->name }}
                    </th>
                </tr>
                <tr>
                    <th>
                        {{trans('task.description')}}: {{ $task->description }}
                    </th>
                </tr>
                <tr>
                    <th>
                        {{ trans('task.state') }}:
                        <a href="{{route('statuses.show', $task->status)}}" class="{{ $task->status->present()->stateBadgeClass }}">
                            {{ $task->status->present()->stateName }}
                        </a>
                    </th>
                </tr>
                <tr>
                    <th>
                        {{ trans('task.tags') }}:
                        @foreach($tags as $tag)
                            <span class="badge badge-primary">{{ $tag->name }}</span>
                        @endforeach
                    </th>
                </tr>
                <tr>
                    <th>
                        {{trans('task.creator')}}: <a href="{{route('users.show', $creator)}}">{{ $creator->name}}</a>
                    </th>
                </tr>
                <tr>
                    <th>
                        {{trans('task.assigned')}}: <a href="{{route('users.show', $performer)}}">{{ $performer->name}}</a>
                    </th>
                </tr>
            </table>
        </div>
    </div>
        @if(Auth::user()->can('update', $task))
            <div class="card">
                <div class="card-header">
                    {{ trans('task.update') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
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
                                        @if($status->id == $task->status->id)
                                            <option selected value="">{{ $status->name }}</option>
                                        @else
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="assignedTo" class="col-md-4 col-form-label text-md-right">{{ trans('task.assigned') }}</label>
                            <div class="col-md-6">
                                <select name="assignedTo" class="browser-default custom-select">
                                    @foreach($users as $user)
                                        @if($performer->id == $user->id)
                                            <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                                        @else
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input class="btn btn-success btn-block" type="submit" value="{{ trans('task.update') }}" data-confirm="{{ trans('task.update_confirm') }}">
                    </form>
                </div>
            </div>
    @endif
    @if(Auth::user()->can('delete', $task))
            <div class="card">
                <div class="card-header">
                    {{ trans('task.delete') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.destroy', $task) }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="{{ trans('task.delete') }}" data-confirm="{{ trans('task.delete_confirm') }}">
                    </form>
                </div>
            </div>
        @endif
</div>
@endsection

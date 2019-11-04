@extends('layouts.app')

@section('content')
    <form action="{{ route('tasks.index') }}" method="get">
    <div class="form-row">
        <div class="form-group col-md-4">
        <label for="status_id" >{{ trans('task.state') }}</label>
        <select id="status_id" class="custom-select" name="status_id">
            <option value="" {{ Request::get('status_id') ? '' : 'selected' }}>{{ trans('task.all_states') }}</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}" {{ Request::get('status_id') === $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>
    </div>
        <div class="form-group col-md-3">
            <label for="assigned_to_id">{{ trans('task.assigned') }}</label>
            <select id="assigned_to_id" class="custom-select" name="assigned_to_id">
                <option value="" {{ Request::get('assigned_to_id') ? '' : 'selected' }}>{{ trans('task.all_assigned') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ Request::get('assigned_to_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="tag_id">{{ trans('task.tags') }}</label>
            <select id="tag_id" class="custom-select" name="tag_id">
            <option value="" {{ Request::get('tag_id') ? '' : 'selected' }}>{{ trans('task.all_tags') }}</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ Request::get('tag_id') == $tag->id ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-8">
            <div class="form-check">
                <input id="is_my_task" class="form-check-input" type="checkbox" name="is_my_task" {{ Request::get('is_my_task') ? 'checked' : '' }}>
                <label for="is_my_task" class="form-check-label">{{ trans('task.creator_me') }}</label>
            </div>
        </div>
        <div class="form-group col-md-4" >
            <button type="submit" class="btn btn-outline-success">{{ trans('task.search') }}</button>
            <a class="btn btn-outline-success" href="{{ route('tasks.index') }}">{{ trans('task.all') }}</a>
        </div>
    </div>
    </form>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{ trans('task.id') }}</th>
            <th scope="col">{{ trans('task.name') }}</th>
            <th scope="col">{{ trans('task.state') }}</th>
            <th scope="col">{{ trans('task.tags') }}</th>
            <th scope="col">{{ trans('task.assigned') }}</th>
            <th scope="col">{{ trans('task.creator') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
        <tr>
            <th scope="row">{{ $task->id }}</th>
            <td><a href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a></td>
            <td>@include('layouts.state', ['stateId' => $task->status_id, 'stateName' => $task->status->name])</td>
            <td>@foreach($task->tags as $tag)
                    <span class="badge badge-primary">{{ $tag->name }}</span>
                @endforeach</td>
            <td><a href="{{ route('users.show', $task->assigned_to_id) }}">{{ $task->assignedTo->name }}</a></td>
            <td><a href="{{ route('users.show', $task->creator_id) }}">{{ $task->creator->name  }}</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
@endsection

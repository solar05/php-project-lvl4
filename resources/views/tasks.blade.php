@extends('layouts.app')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">{{ trans('task.id') }}</th>
            <th scope="col">{{ trans('task.name') }}</th>
            <th scope="col">{{ trans('task.state') }}</th>
            <th scope="col">{{ trans('task.assigned') }}</th>
            <th scope="col">{{ trans('task.creator') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
        <tr>
            <th scope="row">{{ $task['id'] }}</th>
            <td><a href="{{ route('task.show', $task['id']) }}">{{ $task['name'] }}</a></td>
            <td>@include('layouts.state', ['state' => $task['status_id']])</td>
            <td><a href="{{ route('users.show', $task['assigned_to_id']) }}">{{ $task['assigned_to_id'] }}</a></td>
            <td><a href="{{ route('users.show', $task['creator_id']) }}">{{ $task['creator_id']  }}</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
@endsection

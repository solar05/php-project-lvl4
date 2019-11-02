@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="card">
    <div class="card-header"> {{ trans('task.id') }}: {{ $task['id'] }}</div>
        <div class="card-body">
        <table>
            <th>{{trans('task.name')}}: {{ $task['name'] }}</th>
            <tr><th>
                    {{trans('task.description')}}: {{ $task['description'] }}
                </th></tr>
            <tr><th>{{ trans('task.state') }}: @include('layouts.state', ['state' => $task['status_id']])</th></tr>
        <tr>
            <th> {{ trans('task.tags') }}:
        @foreach($tags as $tag)
                <span class="badge badge-primary">{{ $tag->name }}</span>
        @endforeach
            </th>
        </tr>
            <tr>
                <th>
                    {{trans('task.creator')}}: <a href="{{route('user.show', $creator['id'])}}">{{ $creator['name']}}</a>
                </th>
            </tr>
            <tr>
                <th>
                    {{trans('task.assigned')}}: <a href="{{route('user.show', $performer['id'])}}">{{ $performer['name']}}</a>
                </th>
            </tr>
        </table>


    @if(Auth::user()['id'] == $creator['id'])
                @if($task['status_id'] != 4)
                    @include('layouts.proceed', ['taskId' => $task['id']])
                @endif
                <a href="#" class="btn btn-success btn-block">{{trans('task.update')}}</a>
                    <form action="{{ route('tasks.destroy', $task['id']) }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="{{ trans('task.delete') }}" data-confirm="{{ trans('task.delete_confirm') }}">
                    </form>
            @elseif(Auth::user()['id'] == $performer['id'] && $task['status_id'] != 4)
                @include('layouts.proceed', ['taskId' => $task['id']])
            @endif
        </div>
    </div>
    </div>
@endsection

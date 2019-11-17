@yield('state')
@if($status->name == 'created')
    <a href="{{route('statuses.show', $status)}}" class="badge badge-primary">{{ trans('state.created') }}</a>
@elseif($status->name == 'in_work')
    <a href="{{route('statuses.show', $status)}}" class="badge badge-info">{{ trans('state.in_work') }}</a>
@elseif($status->name == 'testing')
    <a href="{{route('statuses.show', $status)}}" class="badge badge-warning">{{ trans('state.testing') }}</a>
@elseif($status->name == 'completed')
    <a href="{{route('statuses.show', $status)}}" class="badge badge-success">{{ trans('state.completed') }}</a>
@else
    <a href="{{route('statuses.show', $status)}}" class="badge badge-secondary">{{ $status->name }}</a>
@endif

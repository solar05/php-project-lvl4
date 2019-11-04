@yield('state')

@if(in_array($stateName, ['created', 'in_work', 'testing', 'completed']))
@switch($stateId)
    @case(1)
    <a href="{{route('statuses.show', $stateId)}}" class="badge badge-primary">{{ trans('state.created') }}</a>
    @break
    @case(2)
    <a href="{{route('statuses.show', $stateId)}}" class="badge badge-info">{{ trans('state.in_work') }}</a>
    @break
    @case(3)
    <a href="{{route('statuses.show', $stateId)}}" class="badge badge-warning">{{ trans('state.testing') }}</a>
    @break
    @case(4)
    <a href="{{route('statuses.show', $stateId)}}" class="badge badge-success">{{ trans('state.completed') }}</a>
    @break
@endswitch
@else
    <a href="{{route('statuses.show', $stateId)}}" class="badge badge-secondary">{{ $stateName }}</a>
@endif

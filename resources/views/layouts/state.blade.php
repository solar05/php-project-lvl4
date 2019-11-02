@yield('state')
@switch($state)
    @case(1)
    <span class="badge badge-primary">{{ trans('state.created') }}</span>
    @break
    @case(2)
    <span class="badge badge-info">{{ trans('state.in_work') }}</span>
    @break
    @case(3)
    <span class="badge badge-warning">{{ trans('state.testing') }}</span>
    @break
    @case(4)
    <span class="badge badge-success">{{ trans('state.completed') }}</span>
    @break
    @default
    <span class="badge badge-danger">{{ trans('state.error') }}</span>
@endswitch

@yield('proceed')

<form method="post" action="{{ route('tasks.proceed', $taskId) }}">
@method('patch')
@csrf
    <input class="btn btn-primary btn-block" type="submit" data="{{ $taskId }}" value="{{trans('task.proceed')}}">
</form>


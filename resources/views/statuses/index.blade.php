@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <th>{{ trans('state.id') }}</th>
            <th>{{ trans('state.name') }}</th>
            <th>{{ trans('state.created_at') }}</th>
            <th>{{ trans('state.updated_at') }}</th>
            <th><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModal">
                    {{ trans('state.create') }}
                </button>
            </th>
    @foreach($statuses as $status)
        <tr>
            <th>{{ $status->id }}</th>
            <td>@include('layouts.state', ['statuses.show' => $status])</td>
            <td>{{ $status->created_at }}</td>
            <td>{{ $status->updated_at }}</td>
            <td>
                @if(!in_array($status->name, ['created', 'in_work', 'testing', 'completed']))
                    <form action="{{ route('statuses.destroy', $status) }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger" type="submit" value="{{ trans('state.delete') }}" data-confirm="{{ trans('state.delete_confirm') }}">
                    </form>
                @else
                    <p>{{ trans('state.delete_system') }}</p>
                @endif
            </td>
        </tr>
    @endforeach
        </table>
        {{ $statuses->links() }}

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('state.create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form role="form" method="post" action="{{ route('statuses.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-5 col-form-label text-md-right">{{ trans('state.status_name') }}</label>
                                <div class="col-md-5">
                                    <input id="name" type="text" class="form-control " name="name" required>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-block" value="{{ trans('state.create_accept') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


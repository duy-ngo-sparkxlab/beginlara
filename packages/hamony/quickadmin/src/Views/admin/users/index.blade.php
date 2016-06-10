@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <p>{!! link_to_route('users.create', trans('quickadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']) !!}</p>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('quickadmin::admin.users-index-users_list') }}</h3>
                </div>
                @if($users->count() > 0)
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ trans('quickadmin::admin.users-index-name') }}</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    {!! link_to_route('users.edit', trans('quickadmin::admin.users-index-edit'), [$user->id], ['class' => 'btn btn-xs btn-info']) !!}
                                    {!! Form::open(['style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'' . trans('quickadmin::admin.users-index-are_you_sure') . '\');',  'route' => array('users.destroy', $user->id)]) !!}
                                    {!! Form::submit(trans('quickadmin::admin.users-index-delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('quickadmin::admin.users-index-name') }}</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                    {{ trans('quickadmin::admin.users-index-no_entries_found') }}
                @endif
            </div>
                <!-- /.box-body -->
        </div>
    </div>
@endsection
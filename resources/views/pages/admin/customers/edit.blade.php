@extends('layouts.admin.application', ['menu' => 'customers'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
$('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});
</script>
@stop

@section('title')
@stop

@section('header')
Customers
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CustomerController@index') !!}"><i class="fa fa-files-o"></i> Customers</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $customer->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if( $isNew )
        <form action="{!! action('Admin\CustomerController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\CustomerController@update', [$customer->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label for="name">@lang('admin.pages.customers.columns.name')</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $customer->name }}">
                    </div>

                    <div class="form-group @if ($errors->has('address')) has-error @endif">
                        <label for="address">@lang('admin.pages.customers.columns.address')</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') ? old('address') : $customer->address }}">
                    </div>

                    <div class="form-group @if ($errors->has('telephone')) has-error @endif">
                        <label for="telephone">@lang('admin.pages.customers.columns.telephone')</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') ? old('telephone') : $customer->telephone }}">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_enabled" value="1"
                                       @if( $customer->is_enabled) checked @endif
                                > @lang('admin.pages.customers.columns.is_enabled')
                            </label>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop

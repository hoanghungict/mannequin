@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'categories'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.categories')
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CategoryController@index') !!}"><i class="fa fa-files-o"></i> @lang('admin.breadcrumb.categories')</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $category->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\CategoryController@store') !!} @else {!! action('Admin\CategoryController@update', [$category->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\CategoryController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.categories.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $category->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('slug')) has-error @endif">
                            <label for="slug">@lang('admin.pages.categories.columns.slug')</label>
                            <input type="text" class="form-control" id="slug" name="slug" required value="{{ old('slug') ? old('slug') : $category->slug }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('order')) has-error @endif">
                            <label for="order">@lang('admin.pages.categories.columns.order')</label>
                            <input type="number" min="0" class="form-control" id="order" name="order" required value="{{ old('order') ? old('order') : $category->order }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('notes')) has-error @endif">
                            <label for="notes">@lang('admin.pages.categories.columns.notes')</label>
                            <textarea name="notes" class="form-control" rows="5" placeholder="@lang('admin.pages.categories.columns.notes')">{{ old('notes') ? old('notes') : $category->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop

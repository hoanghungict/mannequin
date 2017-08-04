@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'subcategories'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.categories')
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\SubcategoryController@index') !!}"><i class="fa fa-files-o"></i>@lang('admin.breadcrumb.categories')</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $subcategory->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\SubcategoryController@store') !!} @else {!! action('Admin\SubcategoryController@update', [$subcategory->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\SubcategoryController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.subcategories.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $subcategory->name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('category_id')) has-error @endif">
                            <label for="category_id">@lang('admin.pages.subcategories.columns.category_id')</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">@lang('admin.pages.common.label.select_category')</option>
                                @foreach( $categories as $category )
                                    <option value="{!! $category->id !!}" @if( (old('category_id') && old('category_id') == $category->id) || ( isset($subcategory->category_id) && ($subcategory->category_id == $category->id) ) ) selected @endif >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('slug')) has-error @endif">
                            <label for="slug">@lang('admin.pages.subcategories.columns.slug')</label>
                            <input type="text" class="form-control" id="slug" name="slug" required value="{{ old('slug') ? old('slug') : $subcategory->slug }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('order')) has-error @endif">
                            <label for="order">@lang('admin.pages.subcategories.columns.order')</label>
                            <input type="number" min="0" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $subcategory->order }}">
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

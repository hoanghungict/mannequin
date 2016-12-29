@extends('layouts.admin.application', ['menu' => 'products'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>

    <script>
        Boilerplate.subcategories = {!! $subcategories !!};

        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});

        $(document).ready(function () {
            $('select[name="category_id"]').on('change', function () {
                generateSubcategories();
            });
        });

        function generateSubcategories() {
            $('select[name="subcategory_id"]').html('');
            Boilerplate.subcategories.forEach(function (subcategory) {
                if( subcategory.category_id == $('select[name="category_id"]').val() ) {
                    $('select[name="subcategory_id"]').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                }
            });
        }
    </script>
@stop

@section('title')
@stop

@section('header')
    Products
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ProductController@index') !!}"><i class="fa fa-files-o"></i> Products</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $product->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\ProductController@store') !!} @else {!! action('Admin\ProductController@update', [$product->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\ProductController@index') !!}"
                       class="btn btn-block btn-default btn-sm"
                       style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if ($errors->has('code')) has-error @endif">
                            <label for="code">@lang('admin.pages.products.columns.code')</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ old('code') ? old('code') : $product->code }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.products.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $product->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="category_id">@lang('admin.pages.products.columns.category_id')</label>
                        <select class="form-control" name="category_id" style="margin-bottom: 15px;" required>
                            <option value="">@lang('admin.pages.common.label.select_category')</option>
                            @foreach( $categories as $category )
                                <option value="{!! $category->id !!}" @if( (old('category_id') && old('category_id') == $category->id) || ( isset($product->subcategory->category_id) && ($product->subcategory->category_id == $category->id) ) ) selected @endif >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="category_id">@lang('admin.pages.products.columns.subcategory_id')</label>
                        <select class="form-control" name="subcategory_id" style="margin-bottom: 15px;" required>
                            <option value="">@lang('admin.pages.common.label.select_subcategory')</option>
                            @foreach( $subcategories as $subcategory )
                                @if( isset($product->subcategory->category_id) && $product->subcategory->category_id == $subcategory->category_id )
                                    <option value="{!! $subcategory->id !!}" @if( (old('subcategory_id') && old('subcategory_id') == $subcategory->id) || ($product->subcategory_id == $subcategory->id) ) selected @endif >
                                        {{ $subcategory->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="is_enabled">@lang('admin.pages.common.label.is_enabled')</label>
                            <div class="switch">
                                <input id="is_enabled" name="is_enabled" value="1" @if( $product->is_enabled) checked
                                       @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                <label for="is_enabled"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if ($errors->has('import_price')) has-error @endif">
                            <label for="import_price">@lang('admin.pages.products.columns.import_price')</label>
                            <input type="text" class="form-control" id="import_price" name="import_price" required value="{{ old('import_price') ? old('import_price') : (isset($product->present()->getStandardOption->import_price) ? $product->present()->getStandardOption->import_price : 0) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group @if ($errors->has('export_price')) has-error @endif">
                            <label for="export_price">@lang('admin.pages.products.columns.export_price')</label>
                            <input type="text" class="form-control" id="export_price" name="export_price" required value="{{ old('export_price') ? old('export_price') : (isset($product->present()->getStandardOption->export_price) ? $product->present()->getStandardOption->export_price : 0) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if ($errors->has('quantity')) has-error @endif">
                            <label for="quantity">@lang('admin.pages.products.columns.quantity')</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" required value="{{ old('quantity') ? old('quantity') : (isset($product->present()->getStandardOption->quantity) ? $product->present()->getStandardOption->quantity : 0) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="unit_id">@lang('admin.pages.products.columns.unit_id')</label>
                        <select class="form-control" name="unit_id" style="margin-bottom: 15px;">
                            <option value="">@lang('admin.pages.common.label.select_unit')</option>
                            @foreach( $units as $unit )
                                <option value="{!! $unit->id !!}" @if( (old('unit_id') && old('unit_id') == $unit->id) || ( isset($product->present()->getStandardOption->unit_id) && ($product->present()->getStandardOption->unit_id == $unit->id) ) ) selected @endif >
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group @if ($errors->has('descriptions')) has-error @endif">
                            <label for="descriptions">@lang('admin.pages.products.columns.descriptions')</label>
                            <textarea name="descriptions" class="form-control" rows="5" placeholder="@lang('admin.pages.products.columns.descriptions')">{{ old('descriptions') ? old('descriptions') : $product->descriptions }}</textarea>
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

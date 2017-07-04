@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'products'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/jquery-filer/css/jquery.filer.css', 'admin') !!}">
@stop

@section('scripts')
    <script>
        Boilerplate.subcategories = {!! $subcategories !!};
    </script>
    <script src="{!! \URLHelper::asset('libs/plugins/jquery-filer/js/jquery.filer.min.js', 'admin') !!}"></script>
    <script src="{!! \URLHelper::asset('js/pages/products/edit.js', 'admin') !!}"></script>
    <script>
        $('#edit-import-price').on('click', function () {
            $('#import-price').removeAttr('disabled');
            $(this).remove()
        });
        $('#edit-export-price').on('click', function () {
            $('#export-price').removeAttr('disabled');
            $(this).remove()
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.products')
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ProductController@index') !!}"><i class="fa fa-files-o"></i> @lang('admin.breadcrumb.products')</a></li>
    @if( $isNew )
        <li class="active">@lang('admin.breadcrumb.create_new')</li>
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
                            <input type="text" class="form-control" id="code" name="code" @if(!$isNew) disabled @endif value="{{ old('code') ? old('code') : $product->code }}">
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

                @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @if ($errors->has('import_price')) has-error @endif" style="position:relative;">
                                <label for="import_price">@lang('admin.pages.products.columns.import_price')</label>
                                <input type="number" class="form-control" id="import-price" name="import_price" @if( !$isNew ) disabled @endif required value="{{ old('import_price') ? old('import_price') : (isset($product->present()->getStandardOption->import_price) ? $product->present()->getStandardOption->import_price : 0) }}">
                                @if( !$isNew )
                                    <div id="edit-import-price" style="position: absolute; right: 20px; top: 32px; cursor: pointer; color: #005999;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group @if ($errors->has('export_price')) has-error @endif">
                                <label for="export_price">@lang('admin.pages.products.columns.export_price')</label>
                                <input type="number" class="form-control" id="export-price" name="export_price" @if( !$isNew ) disabled @endif required value="{{ old('export_price') ? old('export_price') : (isset($product->present()->getStandardOption->export_price) ? $product->present()->getStandardOption->export_price : 0) }}">
                                @if( !$isNew )
                                    <div id="edit-export-price" style="position: absolute; right: 20px; top: 32px; cursor: pointer; color: #005999;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if ($errors->has('quantity')) has-error @endif">
                            <label for="quantity">@lang('admin.pages.products.columns.quantity')</label>
                            <input type="number" @if( !$isNew ) disabled @endif class="form-control" id="quantity" name="quantity" value="{{ old('quantity') ? old('quantity') : (isset($product->present()->getStandardOption->quantity) ? $product->present()->getStandardOption->quantity : 0) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="unit_id">@lang('admin.pages.products.columns.unit_id')</label>
                        <select class="form-control" name="unit_id" style="margin-bottom: 15px;">
                            <option value="">@lang('admin.pages.common.label.select_unit')</option>
                            @foreach( $units as $unit )
                                <option value="{!! $unit->id !!}" @if( (old('unit_id') && old('unit_id') == $unit->id) || ( isset($product->unit_id) && ($product->unit_id == $unit->id) ) ) selected @endif >
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

                <div class="row">
                    <div class="col-md-12">
                        <input type="file" name="images[]" id="product-images" multiple="multiple">
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>

    @if( !$isNew )
        @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
        @endif
        <form action="{{ \URL::action('Admin\ProductOptionController@create') }}" method="post" onsubmit="return confirm('Are you sure to create new Product Options');">
            {!! csrf_field() !!}
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="box">
                <div class="box-header with-border">
                    <strong style="font-size: 18px;"></strong>

                    @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                        <h3 class="box-title">
                            <span class="btn btn-block btn-default btn-sm" data-toggle="modal" data-target="#ModalOptions" onclick="resetModalProductOption();"  style="width: 125px;">@lang('admin.pages.products.options.create_option_button')</span>
                        </h3>
                    @endif
                </div>

                <div class="box-body">
                    <table class="table table-bordered create-product-options">
                        <tr>
                            <th>@lang('admin.pages.products.options.properties')</th>

                            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                                <th width="100px">@lang('admin.pages.products.columns.import_price')</th>
                                <th width="100px">@lang('admin.pages.products.columns.export_price')</th>
                            @endif

                            <th width="100px">@lang('admin.pages.products.columns.quantity')</th>
                            <th width="100px">@lang('admin.pages.products.columns.unit_id')</th>

                            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                                <th width="100px">@lang('admin.pages.common.label.actions')</th>
                            @endif
                        </tr>
                        @foreach( $product->options as $option )
                            <tr>
                                <td>{{ $option->present()->getProductOptionName}}</td>

                                @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                                    <td>{{ number_format($option['import_price'], '0', ',', ' ') }}</td>
                                    <td>{{ number_format($option['export_price'], '0', ',', ' ') }}</td>
                                @endif

                                <td>{{ number_format($option['quantity'], '0', ',', ' ') }}</td>
                                <td>{{ $product->unit->name }}</td>

                                @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="box-footer">
                    @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                        <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                    @endif
                </div>
            </div>
        </form>

        <!------------------------------------------------------------------->
        <!-- line modal: create product option -->
        <div class="modal fade" id="ModalOptions" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" style="margin-top: 60px;">
                <div class="modal-content">
                    <form action="#" onsubmit="return false;">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">@lang('admin.pages.common.buttons.close')</span>
                            </button>
                            <h3 class="modal-title box-title" id="lineModalLabel" style="text-align: center;">@lang('admin.pages.products.options.create_option_title')</h3>
                        </div>

                        <div class="modal-body" style="padding-bottom: 0;">
                            <table class="table" id="" style="margin-bottom: 0;">
                                <tr>
                                    <th style="">@lang('admin.pages.products.columns.import_price')</th>
                                    <td>
                                        <input type="number" name="option_import_price" class="form-control" required="required" min="0" style="width: 70%;" index="-1" id="option-import-price" value="0">
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 175px;">@lang('admin.pages.products.columns.export_price')</th>
                                    <td>
                                        <input type="number" name="option_export_price" class="form-control" required="required" min="0" style="width: 70%;" id="option-export-price" value="0">
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 175px;">@lang('admin.pages.products.columns.quantity')</th>
                                    <td>
                                        <input type="number" name="option_quantity" class="form-control" required="required" min="0" style="width: 70%;" id="option-quantity" value="0">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <table class="table " style="display: table; margin-bottom: 0;">
                                            <tr>
                                                <td style="border: none;">
                                                    <section>
                                                        <div id="initRow" style="margin-bottom: 10px;">
                                                            <input class="form-control" name="property_name[]" placeholder="Property" style="width: 35%; display: inline-block;">
                                                            <input class="form-control" name="property_values[]" placeholder="Values (Ex: value 1, value 2)" style="width: 55%; display: inline-block;">
                                                        </div>
                                                    </section>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" role="button">
                                        @lang('admin.pages.common.buttons.close')
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="submit" id="save-properties" class="btn btn-default btn-hover-green" data-action="save" role="button">
                                        @lang('admin.pages.common.buttons.save')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------->
    @endif
@stop

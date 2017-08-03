@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'products'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
    <script>
        if ($('#p_search_advance').is(':checked')) {
            $('.search-advance').show();
        } else {
            $('.search-advance').hide();
        }

        $('#p_search_advance').on('click', function () {
            if ($('#p_search_advance').is(':checked')) {
                $('.search-advance').show();
                $('input[name="p_search[status][]"]').prop("checked", true);
                $('input[name="p_search[categories][]"]').prop("checked", true);
            } else {
                $('.search-advance').hide();
            }
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.products')
@stop

@section('breadcrumb')
    <li class="active">@lang('admin.breadcrumb.products')</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('pages.admin.' . config('view.admin') . '.products.index.searchBar')

            <div class="row">
                <div class="col-sm-6">
                    <h3 class="box-title">
                        <p class="text-right">
                            <a href="{!! URL::action('Admin\ProductController@create') !!}"
                               class="btn btn-block btn-primary btn-sm"
                               style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
                        </p>
                    </h3>
                    <br>
                    <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
                </div>
                <div class="col-sm-6 wrap-top-pagination">
                    <div class="heading-page-pagination">
                        {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], [], $count, 'shared.topPagination') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered products-index">
                <tr>
                    <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                    <th>{!! \PaginationHelper::sort('code', trans('admin.pages.products.columns.code')) !!}</th>
                    <th>{!! \PaginationHelper::sort('name', trans('admin.pages.products.columns.name')) !!}</th>

                    @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                        <th>@lang('admin.pages.products.columns.import_price')</th>
                        <th>@lang('admin.pages.products.columns.export_price')</th>
                    @endif

                    <th style="width: 10px;">@lang('admin.pages.products.columns.quantity')</th>
                    <th style="width: 10px;">@lang('admin.pages.products.columns.unit_id')</th>

                    <th style="width: 40px">{!! \PaginationHelper::sort('is_enabled', trans('admin.pages.common.label.is_enabled')) !!}</th>
                    <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                </tr>

                @foreach( $products as $product )
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>

                        @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                            <td>{{ $product->present()->getRangeImportPrice }}</td>
                            <td>{{ $product->present()->getRangeExportPrice }}</td>
                        @endif

                        <td>{{ $product->present()->getCurrentQuantity }}</td>
                        <td>{{ isset($product->unit) ? $product->unit->name : '' }}</td>

                        <td>
                            @if( $product->is_enabled )
                                <span class="badge bg-green">@lang('admin.pages.common.label.is_enabled_true')</span>
                            @else
                                <span class="badge bg-red">@lang('admin.pages.common.label.is_enabled_false')</span>
                            @endif
                        </td>
                        <td>
                            <a href="{!! URL::action('Admin\ProductController@show', $product->id) !!}"
                               class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                            <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                               data-delete-url="{!! action('Admin\ProductController@destroy', $product->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="box-footer">
            {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], []) !!}
        </div>
    </div>
@stop
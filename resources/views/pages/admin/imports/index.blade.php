@extends('layouts.admin.application', ['menu' => 'imports'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.imports')
@stop

@section('breadcrumb')
    <li class="active">@lang('admin.breadcrumb.imports')</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">

            <div class="row">
                <div class="col-sm-6">
                    <h3 class="box-title">
                        <p class="text-right">
                            <a href="{!! URL::action('Admin\ImportController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
        <div class="box-body" style=" overflow-x: scroll; ">
            <table class="table table-bordered imports-index">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th style="width: 150px;">@lang('admin.pages.imports.columns.total_amount')</th>
                    <th>@lang('admin.pages.imports.columns.times')</th>
                    <th style="width: 150px;">@lang('admin.pages.imports.columns.creator_id')</th>

                    <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                </tr>
                @foreach( $imports as $import )
                    <tr>
                        <td>{{ $import->id }}</td>
                        <td>{{ number_format($import->total_amount, 0, '.', ' ') }} <span style="font-size: 11px;">VND</span></td>
                        <td>{{ $import->times }}</td>
                        <td>@if( !empty($import->creator->name) ) {{ $import->creator->name }} @else Unknown @endif</td>

                        <td>
                            <a href="{!! URL::action('Admin\ImportController@show', $import->id) !!}"
                               class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                            <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                               data-delete-url="{!! action('Admin\ImportController@destroy', $import->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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
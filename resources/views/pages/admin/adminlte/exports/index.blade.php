@extends('layouts.admin.application', ['menu' => 'exports'] )

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
    @lang('admin.breadcrumb.exports')
@stop

@section('breadcrumb')
    <li class="active">@lang('admin.breadcrumb.exports')</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">

            <div class="row">
                <div class="col-sm-6">
                    <h3 class="box-title">
                        <p class="text-right">
                            <a href="{!! URL::action('Admin\ExportController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
            <table class="table table-bordered exports-index">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>@lang('admin.pages.exports.columns.times')</th>
                    <th>@lang('admin.pages.exports.columns.total_amount')</th>
                    <th>@lang('admin.pages.exports.columns.discount')</th>
                    <th>@lang('admin.pages.exports.columns.amount_payable')</th>
                    <th>@lang('admin.pages.exports.columns.customer_id')</th>
                    <th>@lang('admin.pages.exports.columns.creator_id')</th>

                    <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                </tr>
                @foreach( $exports as $export )
                    <tr>
                        <td>{{ $export->id }}</td>
                        <td>{{ $export->times }}</td>
                        <td>{{ number_format($export->total_amount, 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>
                        <td>{{ number_format($export->discount, 0, ',', ' ') }} <span style="font-size: 11px;">{{ $export->discount_unit }}</span></td>

                        @php
                            if( $export->discount_unit == '%' ) {
                                $amountPayable = $export->total_amount * (100 - $export->discount) / 100;
                            } else {
                                $amountPayable = $export->total_amount - $export->discount;
                            }
                        @endphp
                        <td>{{ number_format($amountPayable, 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>

                        <td>@if( !empty($export->customer) ) {{ $export->customer->name }} @else Unknown @endif</td>
                        <td>@if( !empty($export->creator) ) {{ $export->creator->name }} @else Unknown @endif</td>

                        <td>
                            <a href="{!! URL::action('Admin\ExportController@show', $export->id) !!}" class="btn btn-block btn-default btn-xs">@lang('admin.pages.common.buttons.view')</a>
                            <a href="{!! URL::action('Admin\ExportController@edit', $export->id) !!}" class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
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
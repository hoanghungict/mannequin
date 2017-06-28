@extends('layouts.admin.application', ['menu' => 'exports'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
@stop

@section('header')
    Exports
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ExportController@index') !!}"><i class="fa fa-files-o"></i> Exports</a></li>
    <li class="active">{{ $export->id }}</li>
@stop

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border no-print">
            <h3 class="box-title">
                <a href="{!! URL::action('Admin\ExportController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px; display: inline-block;">@lang('admin.pages.common.buttons.back')</a>
                <span onclick="javascript: window.print();" class="btn btn-block btn-success btn-sm" style="width: 125px; display: inline-block; margin: 0 10px;">@lang('admin.pages.common.buttons.print')</span>
            </h3>
        </div>
        <div class="box-body">
            <div class="row" style="margin: 15px 0; border: 1px solid #cccccc; padding: 30px; padding-top: 0;">
                <div class="row" style="padding-bottom: 20px; border-bottom: 1px solid #cccccc;">
                    <div class="col-md-6" style="float: left;">
                        <img src="{!! \URLHelper::asset('img/logo.jpg', 'common') !!}" alt="" style="width: 280px; height: 120px;">
                    </div>

                    <div class="col-md-5 col-md-offset-1" style="float: right; padding-top: 20px;">
                        <h1 style="margin-top: 0;">Mannequin Thu Huyền</h1>
                        <h5>Cổng số 6 - Chợ Đồng Xuân / Kiot 24 Chợ Ninh Hiệp</h5>
                        <h5>SĐT: 0986156651 / 0168862268</h5>
                        <h5>Website: mannequinthuhuyen.com</h5>
                    </div>
                </div>

                <div class="row">
                    <h1 style="text-align: center;">@lang('admin.pages.exports.view.delivery_bill')</h1>

                    <table id="print-export-detail">
                        <tr>
                            <th>@lang('admin.pages.exports.view.code')</th>
                            <td>{{ $export->id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.pages.exports.view.customer')</th>
                            <td>@if( !empty($export->customer) ) {{ $export->customer->name }} @endif</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.pages.exports.view.address')</th>
                            <td>@if( !empty($export->customer) ) {{ $export->customer->address }} @endif</td>
                        </tr>
                        <tr>
                            <th>@lang('admin.pages.exports.view.telephone')</th>
                            <td>@if( !empty($export->telephone) ) {{ $export->customer->telephone }} @endif</td>
                        </tr>
                    </table>
                </div>

                <div class="row">
                    <table id="print-export-products" class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>@lang('admin.pages.exports.view.stt')</th>
                            <th>@lang('admin.pages.exports.view.products')</th>
                            <th>@lang('admin.pages.exports.view.options')</th>
                            <th>@lang('admin.pages.exports.view.quantity')</th>
                            <th>@lang('admin.pages.exports.view.unit')</th>
                            <th style="width: 90px;">@lang('admin.pages.exports.view.price')</th>
                            <th style="width: 125px;">@lang('admin.pages.exports.view.total')</th>
                        </tr>

                        @foreach( $export->details as $key => $exportDetail )
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $exportDetail->product->name }}</td>
                                <td>{{ $exportDetail->productOption->present()->getProductOptionName }}</td>
                                <td>{{ number_format($exportDetail->quantity, 0, ',', ' ') }}</td>
                                <td>{{ $exportDetail->product->unit->name }}</td>
                                <td>{{ number_format($exportDetail->prices, 0, ',', ' ') }}</td>
                                <td>{{ number_format(($exportDetail->prices * $exportDetail->quantity), 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>
                            </tr>
                        @endforeach
                    </table>
                    <table class="table table-bordered ">
                        <tr>
                            <th width="200px" style="text-align: right">@lang('admin.pages.exports.view.total_amount')</th>
                            <td style="text-align: right">{{ number_format($export->total_amount, 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>
                        </tr>

                        <tr>
                            <th style="text-align: right">@lang('admin.pages.exports.view.discount')</th>
                            <td style="text-align: right">{{ number_format($export->discount, 0, ',', ' ') }} <span style="font-size: 11px;">{{ $export->discount_unit }}</span></td>
                        </tr>

                        @php
                            if( $export->discount_unit == '%' ) {
                                $amountPayable = $export->total_amount * (100 - $export->discount) / 100;
                            } else {
                                $amountPayable = $export->total_amount - $export->discount;
                            }
                        @endphp
                        <tr>
                            <th style="text-align: right">@lang('admin.pages.exports.view.payable_amount')</th>
                            <td style="text-align: right">{{ number_format($amountPayable, 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th style="width: 100px; vertical-align: text-top;">@lang('admin.pages.exports.view.notes')</th>
                            <td>{{ $export->notes }}</td>
                        </tr>
                    </table>
                </div>

                <div class="row" style="margin-top: 20px; border-top: 1px solid #cccccc;">
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-6">
                            <h4 style="margin-bottom: 0; margin-top: 15px; text-align: center;">
                                <?= "Hà nội, Ngày " . date('d') . " tháng " . date('m') . " năm " . date('Y'); ?>
                            </h4>
                        </div>
                    </div>
                    <div class="col-xs-6" style="float: left;">
                        <h4 class="text-center">@lang('admin.pages.exports.view.receiver')</h4>
                        <h6 class="text-center">@lang('admin.pages.exports.view.sign_and_name')</h6>
                    </div>

                    <div class="col-xs-6" style="float: right;">
                        <h4 class="text-center">@lang('admin.pages.exports.view.biller')</h4>
                        <h6 class="text-center">@lang('admin.pages.exports.view.sign_and_name')</h6>
                        <h4 style="margin-top: 80px; text-align: center;">@if( !empty($export->creator) ) {{ $export->creator->name }} @endif</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

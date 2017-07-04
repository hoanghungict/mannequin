@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'exports'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/select2/select2.min.css', 'admin') !!}">
@stop

@section('scripts')
    @php
        foreach( $products as $key => $product ) {
            $products[$key]['unit_name'] = $product->unit->name;
        }

        foreach( $districts as $key => $district ) {
            $districts[$key]['full_name'] = $district->present()->fullName;
        }
    @endphp
    <script>
        Boilerplate.districts   = {!! $districts !!};
        Boilerplate.employeeId  = @if( empty($export->employee_id) ) '[]' @else {!! $export->employee_id !!} @endif ;
        Boilerplate.products    = {!! $products !!};

        $('select[name="modal_customer_province_id"]').on('change', function () {
            generateDistricts();
        });

        function generateDistricts() {
            $('select[name="district_id"]').html('');
            Boilerplate.districts.forEach(function (district) {
                if( district.province_id == $('select[name="modal_customer_province_id"]').val() ) {
                    $('select[name="modal_customer_district_id"]').append('<option value="' + district.id + '">' + district.full_name + '</option>');
                }
            });
        }
    </script>

    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/plugins/select2/select2.full.min.js', 'admin') }}"></script>

    <script src="{!! \URLHelper::asset('js/pages/exports/edit.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.exports')
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ExportController@index') !!}"><i class="fa fa-files-o"></i> @lang('admin.breadcrumb.exports')</a></li>
    @if( $isNew )
        <li class="active">@lang('admin.breadcrumb.create_new')</li>
    @else
        <li class="active">{{ $export->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\ExportController@store') !!} @else {!! action('Admin\ExportController@update', [$export->id]) !!} @endif"
          method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\ExportController@index') !!}"
                       class="btn btn-block btn-default btn-sm"
                       style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer-id">
                                @lang('admin.pages.exports.columns.customer_id')
                                <i class="fa fa-plus-square-o new-customer" data-toggle="modal" data-target="#ModalNewCustomer"  aria-hidden="true" style="vertical-align: middle; margin-left: 5px; cursor: pointer;"></i>
                            </label>
                            <select class="form-control customer-id" name="customer_id" required id="customer-id" style="margin-bottom: 15px;">
                                <option value="">@lang('admin.pages.common.label.select_customer')</option>
                                @foreach( $customers as $key => $customer )
                                    <option value="{!! $customer->id !!}" @if( (old('customer_id') && old('customer_id') == $customer->id) || ( isset($export->customer_id) && ($export->customer_id == $customer->id) ) ) selected @endif>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('times')) has-error @endif">
                            <label for="times">@lang('admin.pages.exports.columns.times')</label>
                            <div class="input-group @if( $isNew ) date datetime-field @endif">
                                <input type="text" class="form-control" name="times" @if( $isNew ) required @else disabled @endif value="{{ old('times') ? old('times') : $export->times }}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="store-id">@lang('admin.pages.exports.columns.store_id')</label>
                            <select class="form-control store-id" name="store_id" required id="store-id" style="margin-bottom: 15px;">
                                <option value="">@lang('admin.pages.common.label.select_store')</option>
                                @foreach( $stores as $key => $store )
                                    <option value="{!! $store->id !!}" @if( (old('store_id') && old('store_id') == $store->id) || ( isset($export->store_id) && ($export->store_id == $store->id) ) ) selected @endif>
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="creator_id">@lang('admin.pages.exports.columns.creator_id')</label>
                            <input type="text" class="form-control" id="creator_id" disabled value="@if( !empty($export->creator) ) {{ $export->creator->name }} @else {{ $authUser->name }} @endif">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="employee-id">@lang('admin.pages.exports.columns.employee_id')</label>
                            <select class="form-control employee-id" name="employee_id[]" required id="employee-id" style="margin-bottom: 15px;" multiple="multiple">
                                @foreach( $employees as $key => $employee )
                                    <option value="{!! $employee->id !!}">
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('discount')) has-error @endif">
                            <label for="discount">@lang('admin.pages.exports.columns.discount')</label>
                            <input type="number" min="0" class="form-control" id="discount" name="discount" value="{{ old('discount') ? old('discount') : ($export->discount ? $export->discount : 0) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('discount_unit')) has-error @endif">
                            <label for="discount_unit">@lang('admin.pages.exports.columns.discount_unit')</label>
                            <select class="form-control discount-unit" name="discount_unit" required id="discount-unit" style="margin-bottom: 15px;">
                                <option value="{{ \App\Models\Export::TYPE_DISCOUNT_PERCENT }}" @if( (old('discount_unit') && old('discount_unit') == \App\Models\Export::TYPE_DISCOUNT_PERCENT) || \App\Models\Export::TYPE_DISCOUNT_PERCENT == $export->discount_unit ) selected @endif>{{ \App\Models\Export::TYPE_DISCOUNT_PERCENT }}</option>
                                <option value="{{ \App\Models\Export::TYPE_DISCOUNT_VND }}" @if( (old('discount_unit') && old('discount_unit') == \App\Models\Export::TYPE_DISCOUNT_VND) || \App\Models\Export::TYPE_DISCOUNT_VND == $export->discount_unit ) selected @endif>{{ \App\Models\Export::TYPE_DISCOUNT_VND }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_amount">@lang('admin.pages.exports.columns.total_amount')</label>
                            <input type="text" min="0" class="form-control" id="total_amount" disabled value="{{ (is_numeric($export->total_amount) && $export->total_amount) ? number_format($export->total_amount, 0, ',', ' ') : 0 }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            @php
                                if( $export->discount_unit == '%' ) {
                                    $amountPayable = $export->total_amount * (100 - $export->discount) / 100;
                                } else {
                                    $amountPayable = $export->total_amount - $export->discount;
                                }
                            @endphp
                            <label for="amount_payable">@lang('admin.pages.exports.columns.amount_payable')</label>
                            <input type="text" min="0" class="form-control" id="amount_payable" disabled value="{{ number_format($amountPayable, 0, ',', ' ') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('notes')) has-error @endif">
                            <label for="notes">@lang('admin.pages.exports.columns.notes')</label>
                            <textarea name="notes" class="form-control" rows="5" placeholder="@lang('admin.pages.exports.columns.notes')">{{ old('notes') ? old('notes') : $export->notes }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="overflow-x: scroll;">
                        <span class="btn btn-block btn-default btn-sm" data-toggle="modal" data-target="#ModalOptions" onclick="resetModalExport();"  style="width: 125px; margin-bottom: 10px;">@lang('admin.pages.exports.modal.create_button')</span>

                        <table class="table table-bordered export-products" id="export-products">
                            <tr>
                                <th>@lang('admin.pages.exports.modal.product_name')</th>
                                <th>@lang('admin.pages.exports.modal.product_option')</th>
                                <th>@lang('admin.pages.exports.modal.export_price')</th>
                                <th>@lang('admin.pages.exports.modal.quantity')</th>
                                <th>@lang('admin.pages.exports.modal.unit')</th>
                                <th>@lang('admin.pages.exports.columns.total_amount')</th>
                                <th width="100px">@lang('admin.pages.common.label.actions')</th>
                            </tr>

                            @if( !empty($export->details) )
                                @foreach( $export->details as $exportDetail )
                                    <tr>
                                        <td>{{ $exportDetail->present()->product->name }}</td>
                                        <td>{{ $exportDetail->productOption->present()->getProductOptionName }}</td>
                                        <td>{{ number_format($exportDetail->prices, 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>
                                        <td>{{ number_format($exportDetail->quantity, 0, ',', ' ') }}</td>
                                        <td>{{ $exportDetail->product->unit->name }}</td>
                                        <td>{{ number_format(($exportDetail->prices * $exportDetail->quantity), 0, ',', ' ') }} <span style="font-size: 11px;">VND</span></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>


    <!------------------------------------------------------------------->
    <!-- line modal: export products -->
    <div class="modal fade" id="ModalOptions" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 100px;">
            <div class="modal-content" style="width: 700px;">
                <form action="#" onsubmit="return false;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">@lang('admin.pages.common.buttons.close')</span>
                        </button>
                        <h3 class="modal-title box-title" id="lineModalLabel" style="text-align: center;">@lang('admin.pages.exports.modal.title')</h3>
                    </div>

                    <div class="modal-body" style="padding-bottom: 0;">
                        <table class="table" id="modal-export-product" style="margin-bottom: 0;">
                            <tr>
                                <th style="width: 150px;">@lang('admin.pages.exports.modal.product_name')</th>
                                <td>
                                    <select class="form-control" name="modal_product_name" id="modal-product-name" required>
                                        <option value="">@lang('admin.pages.common.label.select_product')</option>
                                        @foreach( $products as $product )
                                            <option value="{!! $product->id !!}" @if( (old('modal_product_name') && old('modal_product_name') == $product->id) ) selected @endif option-url="{!! action('Admin\ProductController@getAllOptionOfProduct', $product->id) !!}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th style="">@lang('admin.pages.exports.modal.product_option')</th>
                                <td>
                                    <select class="form-control" name="modal_product_option" id="modal-product-option" required>
                                        <option value="">@lang('admin.pages.common.label.select_option')</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th style="">@lang('admin.pages.exports.modal.export_price')</th>
                                <td>
                                    <input type="text" name="modal_export_price" id="modal-export-price" disabled value="0" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <th style="">@lang('admin.pages.exports.modal.quantity')</th>
                                <td>
                                    <div class="input-group" style="width: 100%; border: 1px solid #ccc;">
                                        <span id="modal-current-quantity" class="input-group-addon" style="padding: 0 25px; border: none; background: #eeeeee">0 +</span>
                                        <input type="number" name="modal_option_quantity" class="form-control" required="required" min="0" id="modal-quantity" value="0" style="border: none;">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th style="">@lang('admin.pages.exports.modal.unit')</th>
                                <td>
                                    <input type="text" name="modal_unit" id="modal-unit" disabled value="Chiếc" uid="0" class="form-control">
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
                                <button type="submit" id="modal-save" class="btn btn-default btn-hover-green" data-action="save" role="button">
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

    <!------------------------------------------------------------------->
    <!-- line modal: new customers -->
    <div class="modal fade" id="ModalNewCustomer" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 100px;">
            <div class="modal-content" style="width: 700px;">
                <form action="{{action('API\V1\CustomerController@store')}}" id="modal-form-customers" onsubmit="return createNewCustomer();">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">@lang('admin.pages.common.buttons.close')</span>
                        </button>
                        <h3 class="modal-title box-title" id="" style="text-align: center;">@lang('admin.pages.exports.modal.new_customer')</h3>
                    </div>

                    <div class="modal-body" style="padding-bottom: 0;">
                        <table class="table" id="modal-new-customer" style="margin-bottom: 0;">
                            <tr>
                                <td>
                                    <label for="name">@lang('admin.pages.customers.columns.name')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="modal-customer-name" name="modal_customer_name" value="{{ old('name') }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telephone">@lang('admin.pages.customers.columns.telephone')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="modal-customer-telephone" name="modal_customer_telephone" value="{{ old('telephone') }}" required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="province_id">@lang('admin.pages.customers.columns.province_id')</label>
                                </td>
                                <td>
                                    <select class="form-control" id="modal-customer-province_id" name="modal_customer_province_id" required>
                                        <option value="">@lang('admin.pages.common.label.select_province')</option>
                                        @foreach( $provinces as $key => $province )
                                            <option value="{!! $province->id !!}" @if( (old('province_id') && old('province_id') == $province->id) ) selected @endif >
                                                {{ $province->present()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="district_id">@lang('admin.pages.customers.columns.district_id')</label>
                                </td>
                                <td>
                                    <select class="form-control" id="modal-customer-district_id" name="modal_customer_district_id" required>
                                        <option value="">@lang('admin.pages.common.label.select_district')</option>
                                        @foreach( $districts as $key => $district )
                                            @if( isset($customer->province_id) && $district->province_id == $customer->province_id )
                                                <option value="{!! $district->id !!}" @if( (old('district_id') && old('district_id') == $district->id) || ($district->id === $customer->district_id) ) selected @endif >
                                                    {{ $district->present()->fullName }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="address">@lang('admin.pages.customers.columns.address')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="modal-customer-address" name="modal_customer_address" value="{{ old('address') }}" required>
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
                                <button type="submit" id="modal-customer-save" class="btn btn-default btn-hover-green" data-action="save" role="button">
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
@stop

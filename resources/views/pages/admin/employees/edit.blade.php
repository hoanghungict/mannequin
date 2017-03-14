@extends('layouts.admin.application', ['menu' => 'employees'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>

    @php
        foreach( $districts as $key => $district ) {
            $districts[$key]['full_name'] = $district->present()->fullName;
        }
    @endphp

    <script>
        Boilerplate.districts = {!! $districts !!};

        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});

        $(document).ready(function () {
            $('#avatar-image').change(function (event) {
                $('#avatar-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });

            $('select[name="province_id"]').on('change', function () {
                generateDistricts();
            });
        });

        function generateDistricts() {
            $('select[name="district_id"]').html('');
            Boilerplate.districts.forEach(function (district) {
                if( district.province_id == $('select[name="province_id"]').val() ) {
                    $('select[name="district_id"]').append('<option value="' + district.id + '">' + district.full_name + '</option>');
                }
            });
        }
    </script>
@stop

@section('title')
@stop

@section('header')
    @lang('admin.breadcrumb.employees')
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\EmployeeController@index') !!}"><i class="fa fa-files-o"></i> @lang('admin.breadcrumb.employees')</a></li>
    @if( $isNew )
        <li class="active">@lang('admin.breadcrumb.create_new')</li>
    @else
        <li class="active">{{ $employee->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\EmployeeController@store') !!} @else {!! action('Admin\EmployeeController@update', [$employee->id]) !!} @endif"
          method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\EmployeeController@index') !!}"
                       class="btn btn-block btn-default btn-sm"
                       style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group text-center">
                            @if( !empty($employee->avatarImage) )
                                <img id="avatar-image-preview"  style="max-width: 500px; width: 100%;" src="{!! $employee->avatarImage->getThumbnailUrl(480, 300) !!}" alt="" class="margin" />
                            @else
                                <img id="avatar-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin" />
                            @endif

                            <input type="file" style="display: none;"  id="avatar-image" name="avatar_image">
                            <p class="help-block" style="font-weight: bolder;">
                                @lang('admin.pages.employees.columns.avatar_image_id')
                                <label for="avatar-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <table class="edit-user-profile">
                            <tr class="@if ($errors->has('name')) has-error @endif">
                                <td>
                                    <label for="name">@lang('admin.pages.employees.columns.name')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $employee->name }}">
                                </td>
                            </tr>
                            <tr class="@if ($errors->has('telephone')) has-error @endif">
                                <td>
                                    <label for="telephone">@lang('admin.pages.employees.columns.telephone')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') ? old('telephone') : $employee->telephone }}">
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('province_id')) has-error @endif">
                                <td>
                                    <label for="province_id">@lang('admin.pages.employees.columns.province_id')</label>
                                </td>
                                <td>
                                    <select class="form-control" name="province_id" style="margin-bottom: 15px;">
                                        <option value="">@lang('admin.pages.common.label.select_province')</option>
                                        @foreach( $provinces as $key => $province )
                                            <option value="{!! $province->id !!}" @if( (old('province_id') && old('province_id') == $province->id) || ( ($employee->province_id != null) && ($province->id === $employee->province_id) ) ) selected @endif >
                                                {{ $province->present()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('district_id')) has-error @endif">
                                <td>
                                    <label for="district_id">@lang('admin.pages.employees.columns.district_id')</label>
                                </td>
                                <td>
                                    <select class="form-control" name="district_id" style="margin-bottom: 15px;">
                                        <option value="">@lang('admin.pages.common.label.select_district')</option>
                                        @foreach( $districts as $key => $district )
                                            @if( isset($employee->province_id) && $district->province_id == $employee->province_id )
                                                <option value="{!! $district->id !!}" @if( (old('district_id') && old('district_id') == $district->id) || ($district->id === $employee->district_id) ) selected @endif >
                                                    {{ $district->present()->fullName }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr class="@if ($errors->has('address')) has-error @endif">
                                <td>
                                    <label for="address">@lang('admin.pages.employees.columns.address')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') ? old('address') : $employee->address }}">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm"
                        style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop

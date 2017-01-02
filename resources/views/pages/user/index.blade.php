@extends('layouts.user.application' )
@section('content')
<div class="home-content-block">

    <div class="home-content">
        <div class="home-content-title">
            <h3>SẢN PHẨM BÁN CHẠY</h3>
        </div>
    </div>

    <div class="home-content-detail" style="background: rgb(228, 228, 228); text-align: center;">
            <a href="{!! route('product') !!}"><h5 style="line-height: 175px;">Xem thêm ...</h5></a>
        </div>
    </div>

<div class="home-content-block">
    <div class="banner970x90">
        <img src="{!! \URLHelper::asset('libs/userlte/banner/970x90.png', 'user') !!}" alt="">
    </div>

    <div class="home-content">
        <div class="home-content-title">
            <h3>MANNEQUIN</h3>
            <h5>Nổi bật</h5><img src="{!! \URLHelper::asset('libs/userlte/arrow.png', 'user') !!}" alt="">
        </div>
    </div>

        <div class="home-content-detail" style="background: rgb(228, 228, 228); text-align: center;">
            <a href="{!! route('product') !!}"><h5 style="line-height: 175px;">Xem thêm ...</h5></a>
        </div>
    </div>

<div class="home-content-block">
    <div class="banner970x90">
        <img src="{!! \URLHelper::asset('libs/userlte/banner/970x90.png', 'user') !!}" alt="">
    </div>

    <div class="home-content">
        <div class="home-content-title">
            <h3>MẮC QUẦN ÁO</h3>
            <h5>Nổi bật</h5><img src="{!! \URLHelper::asset('libs/userlte/arrow.png', 'user') !!}" alt="">

        </div>
    </div>
        <div class="home-content-detail" style="background: rgb(228, 228, 228); text-align: center;">
            <a href="{!! route('product') !!}"><h5 style="line-height: 175px;">Xem thêm ...</h5></a>
        </div>
    </div>
@endsection
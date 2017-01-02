@extends('layouts.user.application' )
@section('content')
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Library</a></li>
    <li class="active">Data</li>
</ol>

<div class="image-slider">
    <div class="slider-inner">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-1.jpg', 'user') !!}" style="opacity: 1 " alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-2.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-3.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-4.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-5.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-6.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-7.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-8.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-9.jpg', 'user') !!}" alt="">
        <img src="{!! \URLHelper::asset('libs/userlte/img/cS-10.jpg', 'user') !!}" alt="">

    </div>
    <div class="slider-thumbnail">
        <div class="slider-thumbnail-list">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-1.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-2.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-3.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-4.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-5.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-6.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-7.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-8.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-9.jpg', 'user') !!}" alt="">
            <img src="{!! \URLHelper::asset('libs/userlte/img/cS-10.jpg', 'user') !!}" alt="">

        </div>
    </div>

    <script>
        $('.slider-thumbnail').find('img').on('click', function() {
            $('.slider-inner').find('img').css('opacity', 0);
            $('.slider-inner').find('img[src="' + $(this).attr('src') + '"]').css(
                    {
                        "opacity": 1,
                        "-webkit-transition": "1s",
                        "-moz-transition": "1s",
                        "-ms-transition": "1s",
                        "-o-transition": "1s",
                        "transition": "1s"
                    }
            );
        });
    </script>
</div>

<div class="product-intro">
    <h3>Mannequin Nam 2016</h3>
    <p style="font-size: 13px;">
        Hàng chính hãng được phân phối rộng rãi tại thị trường Việt Nam bởi nhà phân phối chính thức nhận ủy quyền trực tiếp từ Apple. Bảo hành hàng chính hãng ngay tại các trung tâm được ủy quyền bởi Apple (FPT, VNPT, Viettel,…)
        <br>Hàng chính hãng được bảo hành 1 đổi 1 trong vòng 12 tháng với các lỗi do nhà cung cấp, nguồn, màn hình, cảm ứng,…
    </p>

    <table style="font-size: 13px;">
        <tr>
            <td width="110px">Màu sắc</td>
            <td>
                <span>Xanh</span>
                <span>Đỏ</span>
                <span style="color: red">Tím</span>
                <span>Vàng</span>
            </td>
        </tr>
        <tr>
            <td>Xuất xứ</td>
            <td>
                <span style="color: red">China</span>
                <span>Vietnam</span>
            </td>
        </tr>
        <tr>
            <td>Kích thước</td>
            <td>
                <span>S</span>
                <span style="color: red">M</span>
                <span>L</span>
                <span>XL</span>
            </td>
        </tr>
        <tr>
            <td>Tình trạng</td>
            <td>
                <span>Còn hàng</span>
            </td>
        </tr>
    </table>
</div>

<div class="main-product-info">
    <div class="left-info">
        <div class="product-info">
            <h4 style="padding-left: 5px;"><strong>THÔNG SỐ SẢN PHẨM</strong></h4>
            <table class="table">
                <tr>
                    <th width="150px;">Xuất xứ</th>
                    <td>China</td>
                </tr>
                <tr>
                    <th>Chất liệu</th>
                    <td>Nhựa, sắt</td>
                </tr>
                <tr>
                    <th>Màu sắc</th>
                    <td>Xanh, Đỏ</td>
                </tr>
                <tr>
                    <th>Kích thước</th>
                    <td>S, M</td>
                </tr>
            </table>
        </div>

        <div style="width: 468px; height: 60px; background-color: #cccccc; margin: 0 auto;">

        </div>

        <div class="fb-comment">
            <img src="{!! \URLHelper::asset('libs/userlte/banner/fb-comment.png', 'user') !!}" alt="">

        </div>
    </div>

    <div class="right-info">
        <div class="right-suggest">
            <h4>SẢN PHẨM TƯƠNG TỰ</h4>

            <div class="product-suggest">
                <div class="suggest-image">
                    <img src="{!! \URLHelper::asset('libs/userlte/banner/90x130.jpg', 'user') !!}" alt="">

                </div>
                <div class="suggest-info">
                    <h5>Mannequin nam 2016</h5>
                    <h6>1.050.000 VND</h6>
                </div>
            </div>
            <div class="product-suggest">
                <div class="suggest-image">
                    <img src="{!! \URLHelper::asset('libs/userlte/banner/90x130.jpg', 'user') !!}" alt="">

                </div>
                <div class="suggest-info">
                    <h5>Mannequin nam 2016</h5>
                    <h6>1.050.000 VND</h6>
                </div>
            </div>
            <div class="product-suggest">
                <div class="suggest-image">
                    <img src="{!! \URLHelper::asset('libs/userlte/banner/90x130.jpg', 'user') !!}" alt="">
                </div>
                <div class="suggest-info">
                    <h5>Mannequin nam 2016</h5>
                    <h6>1.050.000 VND</h6>
                </div>
            </div>
        </div>

        <div class="right-info-banner">
            <img src="{!! \URLHelper::asset('libs/userlte/banner/300x600.jpg', 'user') !!}" alt="">

        </div>
    </div>
</div>

<div id="Tag">
    <h4>Tag:</h4>
    <a href="#" class="btn btn-xs btn-default">Mannequin</a>
    <a href="#" class="btn btn-xs btn-default">Mắc quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Dàn khung quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Mannequin</a>
    <a href="#" class="btn btn-xs btn-default">Mắc quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Dàn khung quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Mannequin</a>
    <a href="#" class="btn btn-xs btn-default">Mắc quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Dàn khung quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Mannequin</a>
    <a href="#" class="btn btn-xs btn-default">Mắc quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Dàn khung quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Mannequin</a>
    <a href="#" class="btn btn-xs btn-default">Mắc quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Dàn khung quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Mannequin</a>
    <a href="#" class="btn btn-xs btn-default">Mắc quần áo</a>
    <a href="#" class="btn btn-xs btn-default">Dàn khung quần áo</a>
</div>

<div class="banner970x90">
    <img src="{!! \URLHelper::asset('libs/userlte/banner/970x90.jpg', 'user') !!}" alt="">

</div>
@endsection
